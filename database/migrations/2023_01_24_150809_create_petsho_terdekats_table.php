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
        Schema::create('petshop_terdekat', function (Blueprint $table) {
            $table->id();
            $table->char('nama_petshop',255);
            $table->string('keterangan_petshop')->nullable();
            $table->foreignId('kab_kota_id')->constrained('master_kab_kota');
            $table->text('alamat');
            $table->text('gmaps_iframe');
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
        Schema::dropIfExists('petshop_terdekat');
    }
};
