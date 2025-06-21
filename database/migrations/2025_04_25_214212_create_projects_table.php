<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            // $table->id();
            // $table->string('name')->unique();
            // $table->text('deskripsi')->nullable(); // Menambahkan kolom deskripsi
            // $table->string('pemberi_kerja')->nullable(); // Menambahkan kolom pemberi_kerja
            // $table->timestamps();

            $table->id();
            $table->string('name')->unique(); // nama_proyek
            $table->text('deskripsi')->nullable();
            $table->string('pemberi_kerja')->nullable();
            $table->date('tanggal_dimulai_proyek')->nullable();
            $table->date('tanggal_selesai_proyek')->nullable();
            $table->string('kategori')->nullable();
            $table->unsignedBigInteger('nilai_kontrak')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
