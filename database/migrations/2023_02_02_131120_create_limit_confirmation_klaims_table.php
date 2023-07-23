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
        Schema::create('limit_confirmation_klaim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klaim_id')->constrained('klaim_asuransi');
            $table->bigInteger('nominal_pengajuan');
            $table->bigInteger('nominal_limit');
            $table->bigInteger('nominal_ditawarkan')->nullable();
            $table->text('alasan');
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
        Schema::dropIfExists('limit_confirmation_klaim');
    }
};
