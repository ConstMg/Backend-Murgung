<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Http\Resources\ListPresensiKaryawanResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AllKaryawanResource;
use App\Http\Resources\KaryawanResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;


class AdminController
{

    private function checkRole()
    {
        $user = Auth::user();


        // Cek apakah user yang login memiliki role admin
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }
        return null;
    }
    // public function getAllKaryawan(Request $request)
    // Melihat semua karyawan
    /**
     * @authenticated
     * @group User Management
     */
    public function getAllKaryawan(Request $request)
    {

        $karyawan = Karyawan::orderBy('id')->get();

        return response()->json([
            'message' => 'Daftar semua karyawan',
            'data' => AllKaryawanResource::collection($karyawan)
        ], 200);
    }

    public function updateRoleByNama(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'role' => 'nullable|string|in:karyawan,admin'
        ]);

        $karyawan = Karyawan::where('nama', $request->nama)->first();

        if (!$karyawan) {
            return response()->json([
                'message' => 'Karyawan dengan nama tersebut tidak ditemukan.'
            ], 404);
        }

        // Gunakan default 'karyawan' jika tidak ada input
        $role = $request->input('role', 'karyawan');

        $karyawan->role = $role;
        $karyawan->save();

        return response()->json([
            'message' => 'Role berhasil diperbarui.',
            'data' => $karyawan
        ]);
    }

    public function tambahKaryawan(Request $request)
    {
        // $request->validate([
        //     'akses' => 'required|in:admin'
        // ]);


        try {
            // Normalisasi jk agar valid dengan enum di database
            $jk = ucfirst(strtolower($request->jk));
            if ($jk === 'Laki-laki') {
                $jk = 'Laki-Laki';
            }
            $request->merge(['jk' => $jk]);

            // Validasi manual dengan Validator supaya bisa tangani error-nya sendiri
            $validator = Validator::make($request->all(), [
                'nama'        => 'required|string|max:100',
                'nik'         => 'required|string|max:20|unique:karyawan,nik',
                'jk'          => 'required|in:Laki-Laki,Perempuan',
                'alamat'      => 'required|string',
                'divisi'      => 'required|string',
                'penempatan'  => 'required|string',
                'email'       => 'required|email|unique:karyawan,email|ends_with:@constmg.com',
                'password'    => 'required|string|min:6',
                'role'        => 'sometimes|required|in:karyawan,admin'

            ]);

            // Jika gagal validasi
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Simpan data
            $karyawan = Karyawan::create([
                'nama'        => $request->nama,
                'nik'         => $request->nik,
                'jk'          => $request->jk,
                'alamat'      => $request->alamat,
                'divisi'      => $request->divisi,
                'penempatan'  => $request->penempatan,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
            ]);

            return response()->json([
                'message'  => 'Karyawan berhasil ditambahkan.',
                'data'     =>  new KaryawanResource($karyawan)
            ], 201);
        } catch (QueryException $e) {
            // Tangani error dari database, misalnya constraint violation
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return response()->json([
                'message' => 'Terjadi kesalahan tidak terduga.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    // Update data karyawan
    public function updateKaryawan(Request $request, $id)
    {
        // $request->validate([
        //     'akses' => 'required|in:admin'
        // ]);

        Log::info('BODY REQUEST:', $request->all());

        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        // Validasi hanya field yang dikirim
        $validated = $request->validate([
            'nama'       => 'sometimes|required|string|max:255',
            'nik'        => 'sometimes|required|string|max:225',
            'jk'         => 'sometimes|required|in:Laki-Laki,Perempuan',
            'alamat'     => 'sometimes|required|string',
            'divisi'     => 'sometimes|required|string|max:100',
            'penempatan' => 'sometimes|required|string|max:100',
            'email'      => 'sometimes|required|email|ends_with:@constmg.com|unique:karyawan,email,' . $id,
            'password'   => 'nullable|string|min:6', // ubah jadi nullable, bukan required
        ]);
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }


        // Jika password dikirim, bisa di-hash dulu jika perlu
        // if ($request->has('password')) {
        //     $validated['password'] = bcrypt($request->password); // jika ingin hashing
        // }

        $karyawan->fill($validated);
        $karyawan->save();

        return response()->json([
            'message' => 'Karyawan berhasil diperbarui.',
            'data'    =>  new KaryawanResource($karyawan)
        ]);
    }

    // Menghapus karyawan
    public function hapusKaryawan(Request $request, $id)
    {
        // $request->validate([
        //     'akses' => 'required|in:admin'
        // ]);


        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $karyawan->delete();

        return response()->json(['message' => 'Karyawan berhasil dihapus.']);
    }

    public function listPresensiSemuaKaryawan(Request $request)
    {
        // $request->validate([
        //     'akses' => 'required|in:admin'
        // ]);

        // if ($response = $this->checkRole()) {
        //     return $response;
        // };
        $request->validate([
            'nama' => 'nullable|string',
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_awal'
        ]);

        $query = Presensi::with('karyawan');

        // Filter berdasarkan nama (opsional)
        if ($request->filled('nama')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', $request->tanggal_awal);
        }


        $data = $query->orderByDesc('tanggal')
            ->take(200)
            ->get();

        return response()->json([
            'message' => 'Data presensi karyawan berhasil di ambil.',
            'data'    =>  ListPresensiKaryawanResource::collection($data),
        ], 200);

        // return response()->json($data, 200);
    }


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
            ->orderBy('id', 'desc');

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



    public function updateProject(Request $request, $id)
    {
        // Cari project berdasarkan ID
        Log::info('BODY REQUEST:', $request->all());
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => "Project dengan ID '{$id}' tidak ditemukan",
                'error' => 404
            ], 404);
        }

        // Validasi input dengan custom messages
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'pemberi_kerja' => 'nullable|string',
                'tanggal_dimulai_proyek' => 'nullable|date',
                'tanggal_selesai_proyek' => 'nullable|date|after_or_equal:tanggal_dimulai_proyek',
                'kategori' => 'nullable|string',
                'nilai_kontrak' => 'nullable|integer|min:0'
            ],
            [
                'name.required' => 'Nama proyek wajib diisi.',
                'name.max' => 'Nama proyek tidak boleh lebih dari 255 karakter.',
                'tanggal_dimulai_proyek.date' => 'Tanggal dimulai harus berupa tanggal yang valid.',
                'tanggal_selesai_proyek.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
                'tanggal_selesai_proyek.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal dimulai.',
                'nilai_kontrak.integer' => 'Nilai kontrak harus berupa angka.',
                'nilai_kontrak.min' => 'Nilai kontrak tidak boleh bernilai negatif.'
            ]
        );

        // Update project
        $project->update($validated);

        return response()->json([
            'message' => "Project '{$project->nama_project}' berhasil diperbarui",
            'data' => $project
        ]);
    }



    public function deleteProject($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'message' => "Project dengan ID '{$id}' tidak ditemukan",
                'error' => 404
            ], 404);
        }

        try {
            $cloudinary = new Cloudinary();

            // Ambil semua gambar terkait
            $images = $project->images; // asumsi relasi bernama 'images'

            foreach ($images as $image) {
                // Hapus dari Cloudinary
                $cloudinary->uploadApi()->destroy($image->public_id, [
                    'resource_type' => 'image',
                ]);
            }

            // Hapus dari database
            $project->images()->delete();

            // Hapus project
            $project->delete();

            return response()->json([
                'message' => "Project '{$project->name}' berhasil dihapus beserta semua gambar terkait dari Cloudinary dan database."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus project dan gambar terkait: ' . $e->getMessage(),
            ], 500);
        }
    }


    // public function show(Request $request, $id)
    // {
    //     // $request->validate([
    //     //     'akses' => 'required|in:admin'
    //     // ]);


    //     $karyawan = Karyawan::find($id);

    //     if (!$karyawan) {
    //         return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Detail karyawan',
    //         'data'    => $karyawan
    //     ], 200);
    // }


    //Project
    public function addProject(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_project' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'pemberi_kerja' => 'nullable|string',
                'tanggal_dimulai_proyek' => 'nullable|date',
                'tanggal_selesai_proyek' => 'nullable|date|after_or_equal:tanggal_dimulai_proyek',
                'kategori' => 'nullable|string',
                'nilai_kontrak' => 'nullable|integer|min:0'
            ],
            [
                'nama_project.required' => 'Nama proyek wajib diisi.',
                'nama_project.max' => 'Nama proyek tidak boleh lebih dari 255 karakter.',
                'tanggal_dimulai_proyek.date' => 'Tanggal dimulai harus berupa tanggal yang valid.',
                'tanggal_selesai_proyek.date' => 'Tanggal selesai harus berupa tanggal yang valid.',
                'tanggal_selesai_proyek.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal dimulai.',
                'nilai_kontrak.integer' => 'Nilai kontrak harus berupa angka.',
                'nilai_kontrak.min' => 'Nilai kontrak tidak boleh bernilai negatif.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $project = Project::firstOrNew(['name' => $request->nama_project]);
            $project->fill($request->only([
                'deskripsi',
                'pemberi_kerja',
                'tanggal_dimulai_proyek',
                'tanggal_selesai_proyek',
                'kategori',
                'nilai_kontrak',
            ]));
            $project->save();

            return response()->json([
                'message' => 'Project berhasil dibuat',
                'data' => [
                    'project_id' => $project->id,
                    'nama_project' => $project->name,
                    'deskripsi' => $project->deskripsi,
                    'pemberi_kerja' => $project->pemberi_kerja,
                    'tanggal_dimulai_proyek' => $project->tanggal_dimulai_proyek,
                    'tanggal_selesai_proyek' => $project->tanggal_selesai_proyek,
                    'kategori' => $project->kategori,
                    'nilai_kontrak' => $project->nilai_kontrak
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
