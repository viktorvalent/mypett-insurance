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
        Schema::table('konfirmasi_klaim_asuransi', function (Blueprint $table) {
            $table->bigInteger('nominal_bayar_rs')->nullable();
            $table->bigInteger('nominal_bayar_obat')->nullable();
            $table->bigInteger('nominal_bayar_dokter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konfirmasi_klaim_asuransi', function (Blueprint $table) {
            //
        });
    }
};
