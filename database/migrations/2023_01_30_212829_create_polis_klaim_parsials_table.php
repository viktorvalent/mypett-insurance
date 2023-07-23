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
        Schema::create('polis_klaim_parsials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('polis_id')->constrained('polis_asuransi');
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');
            $table->bigInteger('limit_klaim');
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
        Schema::dropIfExists('polis_klaim_parsials');
    }
};
