<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\CloudinaryImage;
use Illuminate\Support\Facades\Log;

class ProfileController
{
    /**
     * @unauthenticated
     */
    public function getAboutImages()
    {
        $profile = Profile::findOrFail(1);

        // Ambil semua gambar yang terkait profile ini
        $images = $profile->aboutImages()->select('public_id', 'secure_url')->get();

        // Cek apakah hasilnya kosong
        if ($images->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada gambar yang terkait dengan profil.',
                'data' => [],
            ], 200); // atau 200 jika tidak ingin dianggap error
        }

        return response()->json([
            'message' => 'Daftar gambar profile berhasil diambil.',
            'data' => $images,
        ]);
    }

    public function assignAboutImages(Request $request)
    {

        $request->validate([
            'public_id' => 'required|array',
            'public_id.*' => 'exists:cloudinary_images,public_id',
        ]);
        $profile = Profile::findOrFail(1);

        $publicIds = $request->input('public_id');

        $count = CloudinaryImage::whereIn('public_id', $publicIds)->count();
        if ($count !== count($publicIds)) {
            return response()->json([
                'message' => 'Beberapa public_id tidak ditemukan di database.'
            ], 422);
        }

        // Update gambar
        CloudinaryImage::whereIn('public_id', $publicIds)
            ->where(function ($query) use ($profile) {
                $query->where('profile_id', '!=', $profile->id)
                    ->orWhereNull('profile_id');
            })
            ->update([
                'profile_id' => $profile->id,
                'image_type' => 'about_us',
            ]);

        return response()->json([
            'message' => 'Gambar About Us berhasil ditambahkan.'
        ]);
    }

    public function unassignAboutImage(Request $request)
    {
        // Validasi: bisa berupa array atau string
        $request->validate([
            'public_id' => ['required'],
        ]);

        $publicIds = $request->input('public_id');

        // Jika input berupa string, ubah ke array agar proses sama
        if (is_string($publicIds)) {
            $publicIds = [$publicIds];
        } elseif (!is_array($publicIds)) {
            return response()->json(['message' => 'public_id harus berupa string atau array'], 422);
        }

        // Validasi tiap public_id harus ada di DB
        $existsCount = CloudinaryImage::whereIn('public_id', $publicIds)->count();
        if ($existsCount !== count($publicIds)) {
            return response()->json(['message' => 'Beberapa public_id tidak ditemukan di database'], 422);
        }

        // Update sekaligus
        CloudinaryImage::whereIn('public_id', $publicIds)->update([
            'profile_id' => null,
            'image_type' => null,
        ]);

        return response()->json(['message' => 'Gambar berhasil dihapus dari About Us']);
    }

    // Ambil data profile (hanya satu baris)
    /**
     * @unauthenticated
     */
    public function show()
    {
        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profil belum tersedia'], 404);
        }

        return response()->json($profile, 200);
    }

    // Perbarui data profile (satu-satunya baris)
    public function update(Request $request)
    {
        Log::info('BODY REQUEST:', $request->all());
        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profil belum tersedia'], 404);
        }

        $validated = $request->validate([
            'headline' => 'sometimes|required|array',
            'headline.*' => 'string|max:255', // validasi setiap elemen array
            'main_description'     => 'sometimes|required|string',
            'recent_project_desc'  => 'sometimes|required|string',
            'about_desc'           => 'sometimes|required|string',
            'visi' => 'sometimes|required|string',
            'misi' => 'sometimes|required|string',

            'nama_kantor'          => 'sometimes|required|string|max:255',
            'nomor_hp'             => 'sometimes|required|string|max:20',
            'email'                => 'sometimes|required|email',
            'website_url'          => 'nullable|string',
            'facebook'             => 'sometimes|required|string',
            'instagram'            => 'sometimes|required|string',
        ]);

        $profile->update($validated);

        return response()->json(['message' => 'Profil berhasil diperbarui', 'data' => $profile], 200);
    }
}
