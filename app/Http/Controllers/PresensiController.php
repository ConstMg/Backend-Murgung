<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Presensi;
use Carbon\Carbon;
use Cloudinary\Cloudinary;

class PresensiController
{
    public function presensi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'status_presensi' => 'nullable|in:Hadir,Izin,Sakit,Alpa',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required_if:status_presensi,Izin,Sakit|file|image|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'latitude.required' => 'Lokasi latitude wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',

            'longitude.required' => 'Lokasi longitude wajib diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',

            'status_presensi.in' => 'Status presensi harus salah satu dari Hadir, Izin, Sakit, atau Alpa.',

            'gambar.required_if' => 'Gambar bukti wajib diunggah jika status presensi adalah Izin atau Sakit.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $karyawan = Karyawan::where('nama', $request->nama)->first();
        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $tanggal = Carbon::today('Asia/Jakarta')->toDateString();
        $now = Carbon::now('Asia/Jakarta')->format('H:i:s');

        $presensi = Presensi::where('karyawan_id', $karyawan->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$presensi) {
            if (!$request->status_presensi) {
                return response()->json(['message' => 'Status presensi wajib diisi saat presensi masuk.'], 422);
            }

            $presensi = new Presensi();
            $presensi->nama = $karyawan->nama;
            $presensi->karyawan_id = $karyawan->id;
            $presensi->tanggal = $tanggal;
            $presensi->jam_masuk = $now;
            $presensi->status_presensi = $request->status_presensi;
            $presensi->latitude = $request->latitude;
            $presensi->longitude = $request->longitude;
            $presensi->deskripsi = $request->deskripsi;

            // Jika ada gambar, upload ke Cloudinary
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                $file = $request->file('gambar');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $publicId = "presensi/{$karyawan->nama}/{$tanggal}_{$originalName}";

                try {
                    $cloudinary = new Cloudinary();

                    $uploaded = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                        'folder' => "presensi/{$karyawan->nama}",
                        'public_id' => "{$tanggal}_{$originalName}",
                        'resource_type' => 'image',
                        'overwrite' => false,
                    ]);

                    $presensi->gambar = $uploaded['secure_url'];
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'Presensi berhasil dicatat, namun upload gambar gagal: ' . $e->getMessage()
                    ], 200);
                }
            }

            $presensi->save();

            return response()->json([
                'message' => "Presensi Anda dicatat sebagai " . $presensi->status_presensi . ".",
                'gambar_url' => $presensi->gambar,
            ], 200);
        }

        if ($presensi->jam_keluar) {
            return response()->json(['message' => 'Anda sudah melakukan presensi masuk dan keluar pada hari ini.'], 409);
        }

        if ($presensi->status_presensi !== 'Hadir') {
            return response()->json(['message' => 'Presensi keluar tidak diperlukan karena status Anda adalah ' . $presensi->status_presensi . '.'], 403);
        }

        $presensi->jam_keluar = $now;
        $presensi->save();

        return response()->json(['message' => 'Presensi keluar berhasil dicatat.'], 200);
    }

    public function apiList(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal',
        ]);

        // Ambil user dari token
        $user = $request->user(); // atau auth()->user();

        // Cek apakah user adalah karyawan
        $karyawan = Karyawan::where('email', $user->email)->first(); // atau gunakan relasi langsung jika ada
        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $query = Presensi::where('karyawan_id', $karyawan->id);

        // Filter tanggal jika tersedia
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $data = $query->orderByDesc('tanggal')
            ->take(100)
            ->get()
            ->map(function ($item) use ($karyawan) {
                return [
                    'nama' => $karyawan->nama,
                    'email' => $karyawan->email,
                    'tanggal' => $item->tanggal,
                    'jam_masuk' => $item->jam_masuk,
                    'status_presensi' => $item->status_presensi,
                    'jam_keluar' => $item->jam_keluar,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'deskripsi' => $item->deskripsi,
                ];
            });

        return response()->json($data, 200);
    }

    // get all presensi for admin
    public function getAllPresensi()
    {
        // Mengambil semua data presensi tanpa reslasi karyawan
        $presensi = Presensi::orderByDesc('tanggal')
            ->take(100)
            ->get();

        // Mengambil data presensi dengan relasi karyawan
        // $presensi = Presensi::with('karyawan')
        //     ->orderByDesc('tanggal')
        //     ->take(100)
        //     ->get();


        return response()->json([
            'message' => 'Data presensi berhasil diambil.',
            'count' => $presensi->count(),
            'data' => $presensi
        ], 200);
    }
}
