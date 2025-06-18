<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameKaryawanToPenggunaAndAddRoleColumn extends Migration
{
    public function up()
    {
        // Ubah nama tabel dari karyawan ke pengguna


        // Tambahkan kolom role ke tabel pengguna
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('role')->default('karyawan')->after('email'); // sesuaikan posisi jika mau
        });
    }

    public function down()
    {
        // Hapus kolom role
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('role');
        });

    }
}
