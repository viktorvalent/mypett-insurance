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
        Schema::create('polis_asuransi', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polis');
            $table->foreignId('pembelian_id')->constrained('pembelian_produk');
            $table->date('tgl_polis_mulai');
            $table->date('tgl_polis_dibuat');
            $table->integer('jangka_waktu')->default(1);
            $table->integer('biaya_polis')->nullable();
            $table->date('tgl_bayar_polis')->nullable();
            $table->enum('status_polis', ['Aktif','Lewat Waktu'])->default('Aktif');
            $table->string('path');
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
        Schema::dropIfExists('polis_asuransi');
    }
};
