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
        // Schema::dropIfExists('profiles');
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->text('main_description');
            $table->text('recent_project_desc');
            $table->text('about_desc');
            $table->string('nama_kantor');
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->string('website_url')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
