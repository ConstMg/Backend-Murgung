<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController
{

    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Cari karyawan berdasarkan email
        $karyawan = Karyawan::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password cocok (HASHING)
        // if ($karyawan && Hash::check($request->password, $karyawan->password)) {
        //NO HASHING

        if ($karyawan && Hash::check($request->password, $karyawan->password)) {

            // Generate token
            $token = $karyawan->createToken('karyawan-token')->plainTextToken;

            // Simpan login ke DB (optional, seperti sebelumnya)
            Login::create([
                'karyawan_id' => $karyawan->id,
                'email'       => $request->email,
                'waktu_login' => now(),
                'created_at'  => now(),
                'updated_at'  => now()
            ]);

            // Kembalikan response sukses dengan token
            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'karyawan' => [
                    'id' => $karyawan->id,
                    'nama' => $karyawan->nama,
                    'email' => $karyawan->email,
                    'role' => $karyawan->role,
                ]
            ]);
        }

        // Jika gagal
        return response()->json([
            'message' => 'Email atau password salah.'
        ], 401);
    }





    public function logout(Request $request)
    {
        // Hapus token bearer yang sedang digunakan
        $request->user()->currentAccessToken()?->delete();

        // Ambil data karyawan dari token (tanpa perlu validasi email manual lagi)
        $karyawan = $request->user();

        // Jika mau tetap hapus log login terakhir (opsional)
        $latestLogin = DB::table('logins')
            ->where('karyawan_id', $karyawan->id)
            ->orderByDesc('id')
            ->first();

        if ($latestLogin) {
            DB::table('logins')->where('id', $latestLogin->id)->delete();
        }

        // Hapus session (kalau masih digunakan)
        session()->forget('role');

        return response()->json([
            'message' => 'Logout berhasil dan token dihapus.'
        ]);
    }
}
