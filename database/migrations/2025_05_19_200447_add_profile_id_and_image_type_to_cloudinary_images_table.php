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
        Schema::table('cloudinary_images', function (Blueprint $table) {
            $table->foreignId('profile_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('image_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cloudinary_images', function (Blueprint $table) {
            // Hapus foreign key dulu baru drop kolomnya
            $table->dropForeign(['profile_id']);
            $table->dropColumn('profile_id');
            $table->dropColumn('image_type');
        });
    }
};
