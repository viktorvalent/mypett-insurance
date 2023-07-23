<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaketAsuransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produk_asuransi')->insert([
            [
                'id'=>1,
                'nama_produk'=>'Paket Gold',
                'kelas_kamar'=>'Kelas Bisnis',
                'limit_kamar'=>'75000000',
                'limit_obat'=>'50000000',
                'satuan_limit_kamar'=>15000000,
                'satuan_limit_obat'=>15000000,
                'satuan_limit_dokter'=>15000000,
                'created_at'=>'2023-01-17 10:28:25',
                'updated_at'=>'2023-01-17 10:28:25'
            ],
            [
                'id'=>2,
                'nama_produk'=>'Paket Silver',
                'kelas_kamar'=>'Kelas Middle',
                'limit_kamar'=>'45000000',
                'limit_obat'=>'30000000',
                'satuan_limit_kamar'=>9000000,
                'satuan_limit_obat'=>9000000,
                'satuan_limit_dokter'=>9000000,
                'created_at'=>'2023-01-17 11:20:25',
                'updated_at'=>'2023-01-17 11:20:25'
            ],
            [
                'id'=>3,
                'nama_produk'=>'Paket Bronze',
                'kelas_kamar'=>'Kelas Ekonomi',
                'limit_kamar'=>'20000000',
                'limit_obat'=>'15000000',
                'satuan_limit_kamar'=>5000000,
                'satuan_limit_obat'=>5000000,
                'satuan_limit_dokter'=>5000000,
                'created_at'=>'2023-01-17 11:28:25',
                'updated_at'=>'2023-01-17 11:28:25'
            ]
        ]);

        DB::table('produk_benefit')->insert([
            [
                'produk_id'=>1,
                'nilai_pertanggungan_min'=>50000000,
                'nilai_pertanggungan_max'=>75000000,
                'santunan_mati_kecelakaan_max'=>75000000,
                'santunan_pencurian_max'=>50,
                'hukum_pihak_ketiga_max'=>37500000,
                'santunan_kremasi_max'=>10000000,
                'santunan_rawat_inap_max'=>1000000,
                'created_at'=>'2023-01-17 10:28:25',
                'updated_at'=>'2023-01-17 10:28:25'
            ],
            [
                'produk_id'=>2,
                'nilai_pertanggungan_min'=>20000000,
                'nilai_pertanggungan_max'=>50000000,
                'santunan_mati_kecelakaan_max'=>50000000,
                'santunan_pencurian_max'=>50,
                'hukum_pihak_ketiga_max'=>25000000,
                'santunan_kremasi_max'=>5000000,
                'santunan_rawat_inap_max'=>1000000,
                'created_at'=>'2023-01-17 11:20:25',
                'updated_at'=>'2023-01-17 11:20:25'
            ],
            [
                'produk_id'=>3,
                'nilai_pertanggungan_min'=>5000000,
                'nilai_pertanggungan_max'=>20000000,
                'santunan_mati_kecelakaan_max'=>20000000,
                'santunan_pencurian_max'=>50,
                'hukum_pihak_ketiga_max'=>10000000,
                'santunan_kremasi_max'=>5000000,
                'santunan_rawat_inap_max'=>1000000,
                'created_at'=>'2023-01-17 11:28:25',
                'updated_at'=>'2023-01-17 11:28:25'
            ]
        ]);

        DB::table('paket_content')->insert([
            [
                'produk_id'=>1,
                'nama'=>'Paket Gold',
                'warna'=>'#ffd700',
                'icon'=>'<i class="bi bi-heptagon"></i>',
                'harga'=>1000000,
                'created_at'=>'2023-01-17 10:28:25',
                'updated_at'=>'2023-01-17 10:28:25'
            ],
            [
                'produk_id'=>2,
                'nama'=>'Paket Silver',
                'warna'=>'#C0C0C0',
                'icon'=>'<i class="bi bi-hexagon"></i>',
                'harga'=>750000,
                'created_at'=>'2023-01-17 11:20:25',
                'updated_at'=>'2023-01-17 11:20:25'
            ],
            [
                'produk_id'=>3,
                'nama'=>'Paket Bronze',
                'warna'=>'#CD7F32',
                'icon'=>'<i class="bi bi-pentagon"></i>',
                'harga'=>500000,
                'created_at'=>'2023-01-17 11:28:25',
                'updated_at'=>'2023-01-17 11:28:25'
            ]
        ]);
    }
}
