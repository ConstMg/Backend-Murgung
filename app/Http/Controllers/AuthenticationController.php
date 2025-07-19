<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthenticationController
{

    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        // Validasi input awal
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Konfigurasi Rate Limiter untuk mencegah brute force
        $maxAttempts = 5;
        $decaySeconds = 120; // 2 menit
        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'Terlalu banyak percobaan login. Silakan coba kembali dalam ' . $seconds . ' detik.'
            ], 429); // 429 Too Many Requests
        }

        // Ambil data karyawan berdasarkan email
        $karyawan = Karyawan::where('email', $request->email)->first();

        // Pengecekan kredensial (email & password)
        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            RateLimiter::hit($throttleKey, $decaySeconds);
            $remaining = $maxAttempts - RateLimiter::attempts($throttleKey);
            $message = 'Email atau password yang Anda masukkan salah.';

            if ($remaining > 0) {
                $message .= ' Anda memiliki ' . $remaining . ' kesempatan lagi.';
            } else {
                $message = "Percobaan login Anda sudah habis. Silakan coba lagi nanti!";
            }

            return response()->json(['message' => $message], 401); // 401 Unauthorized
        }

        // ✨ PENGECEKAN STATUS AKUN ✨
        // Tambahkan pengecekan ini setelah memastikan password benar
        if ($karyawan->status == false) {
            // Jangan hit rate limiter di sini agar user tahu akunnya nonaktif
            return response()->json([
                'message' => 'Login gagal. Akun Anda saat ini tidak aktif.'
            ], 403); // 403 Forbidden
        }


        // Jika login berhasil, reset percobaan yang gagal
        RateLimiter::clear($throttleKey);

        // Buat token otentikasi
        $token = $karyawan->createToken('karyawan-token')->plainTextToken;

        // Catat riwayat login
        Login::create([
            'karyawan_id' => $karyawan->id,
            'email'       => $request->email,
            'waktu_login' => now(),
        ]);

        // Kirim respons sukses beserta token dan data karyawan
        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'karyawan' => [
                'id'    => $karyawan->id,
                'nama'  => $karyawan->nama,
                'email' => $karyawan->email,
                'role'  => $karyawan->role,
            ]
        ]);
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

        return response()->json([
            'message' => 'Logout berhasil dan token dihapus.'
        ]);
    }
}
