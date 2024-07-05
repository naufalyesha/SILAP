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
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
        $table->unsignedBigInteger('lapangan_id')->constrained('lapangans')->onDelete('cascade');
        $table->text('deskripsi');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
