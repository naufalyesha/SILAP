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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['customer', 'vendor', 'admin'])->default('customer');
            $table->string('nama');
            $table->string('alamat');
            $table->string('kota')->nullable();
            $table->string('phone');
            $table->string('google_map_link')->nullable();
            $table->boolean('banned')->default(false);
            $table->text('ban_reason')->nullable();
            $table->string('profile_photo')->default('image/profile.jpg'); 
            $table->rememberToken();
            $table->timestamps();
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
