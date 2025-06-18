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
        Schema::create('admin_logins', function (Blueprint $table) {
            $table->id('admin_id'); // ID unik untuk setiap login admin
            // $table->adminID('admin_id');
            $table->string('email');
            $table->timestamp('waktu_login')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('admin_logins');
    }
};
