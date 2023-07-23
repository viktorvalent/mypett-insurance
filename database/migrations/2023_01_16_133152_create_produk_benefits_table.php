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
        Schema::create('produk_benefit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk_asuransi');
            $table->integer('nilai_pertanggungan_min');
            $table->integer('nilai_pertanggungan_max');
            $table->integer('santunan_mati_kecelakaan_max');
            $table->integer('santunan_pencurian_max');
            $table->integer('hukum_pihak_ketiga_max');
            $table->integer('santunan_kremasi_max');
            $table->integer('santunan_rawat_inap_max');
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
        Schema::dropIfExists('produk_benefits');
    }
};
