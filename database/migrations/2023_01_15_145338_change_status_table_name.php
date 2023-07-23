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
        Schema::table('status_pembelian_setting', function (Blueprint $table) {
            //
        });

        Schema::rename('status_pembelian_setting', 'status_set');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_pembelian_setting', function (Blueprint $table) {
            //
        });
    }
};
