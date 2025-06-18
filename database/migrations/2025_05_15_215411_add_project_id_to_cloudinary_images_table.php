<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Migration untuk update tabel cloudinary_images
        Schema::table('cloudinary_images', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->after('id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            // Optional: hapus kolom project_name jika tidak dipakai lagi
            $table->dropColumn('project_name');
        });
    }

    public function down()
    {
        Schema::table('cloudinary_images', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
};
