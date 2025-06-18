<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException; // Import ValidationException
use Exception; // Import Exception class

class EmailController
{
    /**
     * @unauthenticated
     */

    public function sendMainPage(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'from_email' => 'required|email', // Email pengguna yang ingin contact
                'subject' => 'required|string',
                'message' => 'required|string|max:5000', // Batasi panjang pesan
            ]);

            // Alamat email perusahaan, ditentukan di backend
            $companyEmail = env('MAIL_TO_ADDRESS', 'khairunsyah8935@gmail.com');
            // Jika Anda ingin mengaturnya sebagai variabel lingkungan di .env
            // atau langsung hardcode jika memang tidak akan berubah
            $userName = $request->name;
            $userEmail = $request->from_email; // Email pengguna
            $subject = $request->subject;
            $userMessage = $request->message;

            Mail::raw(
                "Pesan dari: " . $userName . "\n" .
                    "Subjek Asli: " . $subject . "\n\n" .
                    "Isi Pesan:\n" . $userMessage,
                function ($message) use ($companyEmail, $subject, $userEmail) {
                    $message->to($companyEmail) // Email tujuan: perusahaan (diambil dari backend)
                        ->subject("Kontak Web: " . $subject) // Tambahkan prefix agar mudah dikenali
                        ->replyTo($userEmail); // PENTING: Atur Reply-To ke email pengguna
                    // Optional: Anda bisa juga mengatur 'from' secara eksplisit jika perlu
                    // $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                }
            );

            return response()->json(['status' => 'success', 'message' => 'Email kontak berhasil dikirim!']);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data input tidak valid.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) { // Gunakan Exception secara eksplisit
            // Tangani error umum saat pengiriman email
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim email. Silakan coba lagi nanti.',
                'debug' => $e->getMessage() // Hapus di production
            ], 500);
        }
    }
}
