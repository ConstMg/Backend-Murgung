<?php

namespace App\Http\Controllers;

use App\Models\CloudinaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Exception\ApiError;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

class CloudinaryController
{
    /**
     * @unauthenticated
     */
    public function fetchImageFromDb(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'project_name' => 'nullable|string',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        // Ambil nilai dari hasil validasi, atau set default jika tidak tersedia
        $projectName = $validated['project_name'] ?? null;
        $limit = $validated['limit'] ?? 10;

        // === Jika project_name tidak diisi, ambil project secara acak ===
        if (!$projectName) {
            $projectsWithImages = Project::whereHas('images')->with('images')->get();

            if ($projectsWithImages->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada project dengan gambar',
                    'error' => 404
                ], 404);
            }

            $randomProjects = $projectsWithImages->random(min($limit, $projectsWithImages->count()));

            $formatted = $randomProjects->map(function ($project) {
                return [
                    'project_id' => $project->id,
                    'project_name' => $project->name,
                    'images' => $project->images->map(function ($img) {
                        return [
                            'public_id' => $img->public_id,
                            'secure_url' => $img->secure_url,
                        ];
                    })->values()
                ];
            })->values();

            return response()->json([
                'message' => "Berhasil mengambil {$formatted->count()} project secara random",
                'data' => $formatted
            ]);
        }

        // === Jika project_name ada, cari berdasarkan keyword ===
        $projects = Project::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($projectName) . '%'])
            ->has('images')
            ->with('images')
            ->get();

        if ($projects->isEmpty()) {
            return response()->json([
                'message' => "Tidak ada project yang cocok dengan kata kunci '{$projectName}'",
                'error' => 404
            ], 404);
        }

        $limitedProjects = $projects->shuffle()->take(min($limit, $projects->count()));

        $formatted = $limitedProjects->map(function ($project) {
            return [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'images' => $project->images->map(function ($img) {
                    return [
                        'public_id' => $img->public_id,
                        'secure_url' => $img->secure_url,
                    ];
                })->values()
            ];
        })->values();

        return response()->json([
            'message' => "Berhasil mengambil {$formatted->count()} project yang mengandung '{$projectName}'",
            'data' => $formatted
        ]);
    }

    /**
     * @unauthenticated
     */
    public function fetchProjects(Request $request)
    {
        // Validasi input query
        $validated = $request->validate([
            'name' => 'nullable|string',
            'limit' => 'nullable|integer|min:1|max:100',
            'kategori' => 'nullable|string',
        ]);

        $name = $validated['name'] ?? null;
        $limit = $validated['limit'] ?? null;
        $kategori = $validated['kategori'] ?? null;

        // Query project dengan relasi gambar
        $query = Project::with('images')
            ->when($name, function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            })
            ->when($kategori, function ($q) use ($kategori) {
                $q->where('kategori', $kategori);
            })
            ->orderBy('created_at', 'desc');

        // Ambil semua atau dibatasi limit
        $projects = $limit ? $query->take($limit)->get() : $query->get();

        // Jika tidak ada data
        if ($projects->isEmpty()) {
            return response()->json([
                'message' => $name || $kategori
                    ? "Tidak ada project yang cocok dengan "
                    . ($name ? "nama '{$name}'" : '')
                    . ($name && $kategori ? " dan " : '')
                    . ($kategori ? "kategori '{$kategori}'" : '')
                    : 'Tidak ada data project tersedia',
                'error' => 404
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil mengambil data project beserta gambarnya',
            'data' => ProjectResource::collection($projects),
        ]);
    }

    public function addImageToProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'image' => 'required|image|max:2048',
            // 'deskripsi' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('image');
        if (!$file || !$file->isValid()) {
            return response()->json(['message' => 'File tidak ditemukan atau tidak valid.'], 400);
        }

        $project = Project::find($request->project_id);

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $publicId = "dokumentasi_company_profile/{$project->name}/{$originalName}";

        try {
            $cloudinary = new Cloudinary();

            // Cek apakah file dengan public_id sudah ada
            try {
                $cloudinary->adminApi()->asset($publicId);
                return response()->json(['message' => 'Gambar dengan nama ini sudah ada.'], 409);
            } catch (ApiError $e) {
                if (!str_contains($e->getMessage(), 'Resource not found')) {
                    throw $e;
                }
            }

            $uploaded = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => "dokumentasi_company_profile/{$project->name}",
                'public_id' => $originalName,
                'resource_type' => 'image',
                'overwrite' => false,
            ]);


            CloudinaryImage::create([
                'asset_id' => $uploaded['asset_id'],
                'public_id' => $uploaded['public_id'],
                'asset_folder' => dirname($publicId),
                'display_name' => $file->getClientOriginalName(),
                'url' => $uploaded['url'],
                'secure_url' => $uploaded['secure_url'],
                'project_id' => $project->id,
            ]);

            return response()->json([
                'message' => 'Gambar berhasil ditambahkan ke project',
                'secure_url' => $uploaded['secure_url'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menghapus gambar dari Cloudinary dan database.
     *
     * @bodyParam public_id string required ID publik dari gambar yang akan dihapus. Contoh: sample_image_id
     *
     * @response 200 {
     *   "message": "Gambar berhasil dihapus dari Cloudinary dan database."
     * }
     *
     * @response 422 {
     *   "errors": {
     *     "public_id": ["The public_id field is required."]
     *   }
     * }
     *
     * @response 500 {"message": "Gagal menghapus gambar: error_message"}
     */
    public function deleteImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'public_id' => 'required|string|exists:cloudinary_images,public_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $cloudinary = new Cloudinary();

            // Hapus gambar dari Cloudinary
            $cloudinary->uploadApi()->destroy($request->public_id, [
                'resource_type' => 'image',
            ]);

            // Hapus dari database
            CloudinaryImage::where('public_id', $request->public_id)->delete();

            return response()->json([
                'message' => 'Gambar berhasil dihapus dari Cloudinary dan database.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage(),
            ], 500);
        }
    }
}
