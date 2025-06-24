<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up()
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Menambahkan kolom nama karyawan
            $table->unsignedBigInteger('karyawan_id');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status_presensi', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->default('Hadir'); // Menambahkan kolom status_presensi
            $table->text('deskripsi')->nullable(); // Menambahkan kolom deskripsi
            $table->decimal('latitude', 10, 7)->nullable();   // Lokasi latitude
            $table->decimal('longitude', 10, 7)->nullable();  // Lokasi longitude
            $table->timestamps();
            $table->string('gambar')->nullable();
            // Menambahkan foreign key karyawan_id
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('presensis');
    }
};
