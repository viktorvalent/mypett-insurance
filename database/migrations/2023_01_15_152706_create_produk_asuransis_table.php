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
        Schema::create('produk_asuransi', function (Blueprint $table) {
            $table->id();
            $table->char('nama_produk');
            $table->char('kelas_kamar');
            $table->char('limit_kamar');
            $table->char('limit_obat');
            $table->integer('satuan_limit_kamar');
            $table->integer('satuan_limit_obat');
            $table->integer('satuan_limit_dokter');
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
        Schema::dropIfExists('produk_asuransi');
    }
};
