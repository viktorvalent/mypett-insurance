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
        Schema::create('master_ras_hewan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_hewan_id')->constrained('master_jenis_hewan');
            $table->char('nama_ras');
            $table->bigInteger('harga_hewan');
            $table->integer('persen_per_umur');
            $table->string('deskripsi')->nullable();
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
        Schema::dropIfExists('master_ras_hewan');
    }
};
