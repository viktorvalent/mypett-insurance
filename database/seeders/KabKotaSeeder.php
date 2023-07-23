<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabKotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_kab_kota')->insert([
            [
                'nama'=>'Jakarta Barat',
                'provinsi_id'=>1,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Jakarta Selatan',
                'provinsi_id'=>1,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Jakarta Timur',
                'provinsi_id'=>1,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Jakarta Utara',
                'provinsi_id'=>1,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Jakarta Pusat',
                'provinsi_id'=>1,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Bekasi',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Bandung',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Bogor',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Ciamis',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Cianjur',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Depok',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Tasikmalaya',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Cirebon',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Cimahi',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Sukabumi',
                'provinsi_id'=>3,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Tanggerang',
                'provinsi_id'=>2,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Serang',
                'provinsi_id'=>2,
                'deskripsi'=>'-'
            ],
            [
                'nama'=>'Cilegon',
                'provinsi_id'=>2,
                'deskripsi'=>'-'
            ]
        ]);
    }
}
