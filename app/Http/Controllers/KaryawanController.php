<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;

class KaryawanController
{
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request)
    {
        // 1. Ambil user yang sedang terautentikasi
        $user = $request->user();

        // 2. Validasi data yang masuk
        // 'sometimes' berarti validasi hanya berjalan jika field tersebut ada dalam request.
        // Ini adalah kunci untuk update parsial.
        $validatedData = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'jk' => ['sometimes', 'string', Rule::in(['Laki-laki', 'Perempuan'])],
            'alamat' => 'sometimes|nullable|string',
            'divisi' => 'sometimes|nullable|string|max:100',
            'penempatan' => 'sometimes|nullable|string|max:100',
            'jabatan' => 'sometimes|nullable|string|max:100',
            // Pastikan email unik, tapi abaikan email milik user itu sendiri
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // 3. Isi model User dengan data yang sudah divalidasi
        // Metode fill() hanya akan mengisi atribut yang ada di dalam array $validatedData.
        $user->fill($validatedData);

        // 4. Simpan perubahan ke database
        $user->save();

        // 5. Kembalikan response sukses beserta data user yang baru
        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request)
    {
        // 1. Ambil user yang sedang login
        $user = $request->user();

        // 2. Validasi input
        $request->validate([
            // 'current_password' adalah rule bawaan Laravel untuk mengecek
            // apakah input cocok dengan password user di database.
            'current_password' => ['required', 'current_password'],

            // 'confirmed' adalah rule untuk memastikan input 'password'
            // cocok dengan 'password_confirmation'.
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 3. Update password dengan yang baru dan di-hash
        $user->password = Hash::make($request->password);

        // 4. Simpan ke database
        $user->save();

        // 5. Kembalikan response sukses
        return response()->json([
            'message' => 'Password berhasil diperbarui!',
        ]);
    }
}
