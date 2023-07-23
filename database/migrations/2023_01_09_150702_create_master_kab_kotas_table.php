<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kab_kota', function (Blueprint $table) {
            $table->id();
            $table->char('nama',255);
            $table->string('deskripsi')->nullable();
            $table->foreignId('provinsi_id')->constrained('master_provinsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_kab_kota');
    }
};
