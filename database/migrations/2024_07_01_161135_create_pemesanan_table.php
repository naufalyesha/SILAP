<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lapangan_id');
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('status_pembayaran');
            $table->integer('total_harga')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lapangan_id')->references('id')->on('lapangans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemesanans');
    }
};
