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
        Schema::create('klaim_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polis_id')->constrained('polis_asuransi');
            $table->date('tgl_klaim_disetujui');
            $table->bigInteger('total_klaim_disetujui');
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
        Schema::dropIfExists('klaim_records');
    }
};
