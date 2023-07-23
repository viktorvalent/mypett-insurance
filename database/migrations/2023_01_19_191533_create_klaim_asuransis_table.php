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
        Schema::create('klaim_asuransi', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_klaim');
            $table->foreignId('member_id')->constrained('member');
            $table->foreignId('polis_id')->constrained('polis_asuransi');
            $table->foreignId('status_klaim')->constrained('status_set');
            $table->string('history_klaim')->nullable();
            $table->string('foto_bukti_bayar')->nullable();
            $table->string('foto_resep_obat')->nullable();
            $table->string('foto_diagnosa_dokter')->nullable();
            $table->integer('nominal_bayar_rs')->nullable();
            $table->integer('nominal_bayar_dokter')->nullable();
            $table->integer('nominal_bayar_obat')->nullable();
            $table->integer('nominal_disetujui')->nullable();
            $table->string('keterangan_klaim')->nullable();
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
        Schema::dropIfExists('klaim_asuransi');
    }
};
