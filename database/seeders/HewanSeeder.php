<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_jenis_hewan')->insert([
            [
                'id'=>1,
                'nama'=>'Anjing',
                'deskripsi'=>'Jenis Hewan Anjing'
            ],
            [
                'id'=>2,
                'nama'=>'Kucing',
                'deskripsi'=>'Jenis Hewan Kucing'
            ]
        ]);

        DB::table('master_ras_hewan')->insert([
            [
                'jenis_hewan_id'=>1,
                'nama_ras'=>'Husky',
                'harga_hewan'=>20000000,
                'persen_per_umur'=>2,
                'deskripsi'=>'Anjing Ras Husky'
            ],
            [
                'jenis_hewan_id'=>2,
                'nama_ras'=>'Siam',
                'harga_hewan'=>15000000,
                'persen_per_umur'=>1,
                'deskripsi'=>'Kucing Ras Siam'
            ],
            [
                'jenis_hewan_id'=>1,
                'nama_ras'=>'Poodle',
                'harga_hewan'=>10000000,
                'persen_per_umur'=>1,
                'deskripsi'=>'Anjing Ras Poodle'
            ],
            [
                'jenis_hewan_id'=>2,
                'nama_ras'=>'Ragdoll',
                'harga_hewan'=>15000000,
                'persen_per_umur'=>2,
                'deskripsi'=>'Kucing Ras Ragdoll'
            ]
        ]);
    }
}
