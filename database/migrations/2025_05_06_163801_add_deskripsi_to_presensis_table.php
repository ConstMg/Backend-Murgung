<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->text('deskripsi')->nullable(); // Menambahkan kolom deskripsi
        });
    }

    public function down()
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn('deskripsi'); // Menghapus kolom deskripsi jika rollback
        });
    }
};
