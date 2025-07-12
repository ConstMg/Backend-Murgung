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
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);

        $maxAttempts = 5;
        $decaySeconds = 120;

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'Terlalu banyak percobaan login. Silakan coba kembali dalam ' . $seconds . ' detik.'
            ], 429);
        }

        $karyawan = Karyawan::where('email', $request->email)->first();

        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            RateLimiter::hit($throttleKey, $decaySeconds);
            $remaining = $maxAttempts - RateLimiter::attempts($throttleKey);

            $message = 'Login gagal, silakan coba lagi.';
            if ($remaining > 0) {
                $message .= ' Anda memiliki ' . $remaining . ' kesempatan lagi.';
                return response()->json([
                    'message' => $message
                ], 402);
            }

            return response()->json([
                'message' => "Percobaan anda sudah habis silahkan coba lagi nanti!"
            ], 402);
        }

        // Login sukses, reset percobaan
        RateLimiter::clear($throttleKey);

        $token = $karyawan->createToken('karyawan-token')->plainTextToken;

        Login::create([
            'karyawan_id' => $karyawan->id,
            'email'       => $request->email,
            'waktu_login' => now(),
            'created_at'  => now(),
            'updated_at'  => now()
        ]);

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
