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
        Schema::create('pembelian_produk', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_daftar_asuransi');
            $table->double('biaya_pendaftaran');
            $table->foreignId('member_id')->constrained('member');
            $table->foreignId('produk_id')->constrained('produk_asuransi');
            $table->foreignId('ras_hewan_id')->constrained('master_ras_hewan');
            $table->char('nama_hewan');
            $table->char('nama_pemilik');
            $table->enum('jenis_kelamin_hewan', ['Jantan','Betina']);
            $table->date('tgl_lahir_hewan');
            $table->double('berat_badan_kg');
            $table->string('foto');
            $table->integer('harga_dasar_premi');
            $table->foreignId('status')->constrained('status_set');
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
        Schema::dropIfExists('pembelian_produk');
    }
};
