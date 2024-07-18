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
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('booked');
            $table->integer('status')->default(0); // 0: tersedia, 1: tidak tersedia, 2: menunggu
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->boolean('booked')->default(false);
            $table->dropColumn('status');
        });
    }
};
