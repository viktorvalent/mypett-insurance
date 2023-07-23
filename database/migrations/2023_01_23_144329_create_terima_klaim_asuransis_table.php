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
        Schema::create('terima_klaim_asuransi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klaim_id')->constrained('klaim_asuransi');
            $table->string('bukti_bayar_klaim');
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
        Schema::dropIfExists('terima_klaim_asuransi');
    }
};
