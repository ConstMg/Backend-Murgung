<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cloudinary_images', function (Blueprint $table) {
            $table->id();
            $table->string('asset_id');
            $table->string('public_id');
            $table->string('asset_folder');
            $table->string('display_name');
            $table->string('url');
            $table->string('secure_url');

            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->unsignedBigInteger('profile_id')->nullable(); // pastikan relasi ke profile (jika ada)
            $table->string('image_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloudinary_images');
    }
};
