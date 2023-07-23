<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_provinsi')->insert([
            [
                'id'=>1,
                'nama'=>'DKI Jakarta',
                'deskripsi'=>'-'
            ],
            [
                'id'=>2,
                'nama'=>'Banten',
                'deskripsi'=>'-'
            ],
            [
                'id'=>3,
                'nama'=>'Jawa Barat',
                'deskripsi'=>'-'
            ],
        ]);
    }
}
