<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\CloudinaryImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProfileController
{
    /**
     * @unauthenticated
     */
    public function getAboutImages()
    {
        $profile = Profile::findOrFail(1);

        $images = Cache::remember("profile_about_images", 3600, function () use ($profile) {
            return $profile->aboutImages()->select('public_id', 'secure_url')->get();
        });

        if ($images->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada gambar yang terkait dengan profil.',
                'data' => [],
            ], 200);
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

        CloudinaryImage::whereIn('public_id', $publicIds)
            ->where(function ($query) use ($profile) {
                $query->where('profile_id', '!=', $profile->id)
                    ->orWhereNull('profile_id');
            })
            ->update([
                'profile_id' => $profile->id,
                'image_type' => 'about_us',
            ]);

        // ❌ Invalidate cache
        Cache::forget("profile_about_images");

        return response()->json([
            'message' => 'Gambar About Us berhasil ditambahkan.'
        ]);
    }

    public function unassignAboutImage(Request $request)
    {
        $request->validate([
            'public_id' => ['required'],
        ]);

        $publicIds = $request->input('public_id');

        if (is_string($publicIds)) {
            $publicIds = [$publicIds];
        } elseif (!is_array($publicIds)) {
            return response()->json(['message' => 'public_id harus berupa string atau array'], 422);
        }

        $existsCount = CloudinaryImage::whereIn('public_id', $publicIds)->count();
        if ($existsCount !== count($publicIds)) {
            return response()->json(['message' => 'Beberapa public_id tidak ditemukan di database'], 422);
        }

        CloudinaryImage::whereIn('public_id', $publicIds)->update([
            'profile_id' => null,
            'image_type' => null,
        ]);

        // ❌ Invalidate cache
        Cache::forget("profile_about_images");

        return response()->json(['message' => 'Gambar berhasil dihapus dari About Us']);
    }

    /**
     * @unauthenticated
     */
    public function show()
    {
        $profile = Cache::remember("profile_data", 3600, function () {
            return Profile::first();
        });

        if (!$profile) {
            return response()->json(['message' => 'Profil belum tersedia'], 404);
        }

        return response()->json($profile, 200);
    }

    public function update(Request $request)
    {
        Log::info('BODY REQUEST:', $request->all());

        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profil belum tersedia'], 404);
        }

        $validated = $request->validate([
            'headline' => 'sometimes|required|array',
            'headline.*' => 'string|max:255',
            'main_description'     => 'sometimes|required|string',
            'recent_project_desc'  => 'sometimes|required|string',
            'about_desc'           => 'sometimes|required|string',
            'visi'                 => 'sometimes|required|string',
            'misi'                 => 'sometimes|required|string',
            'nama_kantor'          => 'sometimes|required|string|max:255',
            'nomor_hp'             => 'sometimes|required|string|max:20',
            'email'                => 'sometimes|required|email',
            'website_url'          => 'nullable|string',
            'facebook'             => 'sometimes|required|string',
            'instagram'            => 'sometimes|required|string',
        ]);

        $profile->update($validated);

        // ❌ Invalidate cache
        Cache::forget("profile_data");

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data' => $profile
        ], 200);
    }
}
