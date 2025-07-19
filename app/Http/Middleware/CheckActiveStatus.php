<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil data user yang sedang login
        $user = $request->user();

        // Cek apakah user ada dan statusnya tidak sama dengan 1 (aktif)
        // Anda bisa menyesuaikan angka 1 ini jika representasi status aktif Anda berbeda.
        if (!$user || $user->status !== 1) {
            // Jika tidak aktif, kembalikan response error 403 (Forbidden)
            return response()->json(['message' => 'Akses ditolak. Akun Anda tidak aktif.'], 403);
        }

        // Jika status aktif, lanjutkan request ke controller
        return $next($request);
    }
}
