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
        Schema::create('lapangans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->text('map')->nullable();
            $table->json('photo');
            $table->string('type');
            $table->text('description');
            $table->text('facilities')->nullable();
            $table->unsignedBigInteger('vendor_id'); // Menambahkan kolom vendor_id
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade'); // Menambahkan foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lapangans');
    }
};
