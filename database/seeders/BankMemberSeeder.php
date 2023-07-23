<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_bank')
            ->insert([
                [
                    'nama'=>'BRI',
                    'kode_bank'=>"002",
                    'deskripsi'=>'Bank Rakyat Indonesia'
                ],
                [
                    'nama'=>'BNI',
                    'kode_bank'=>"009",
                    'deskripsi'=>'Bank Niaga Indonesia'
                ],
                [
                    'nama'=>'BCA',
                    'kode_bank'=>"014",
                    'deskripsi'=>'Bank Central Asia'
                ],
                [
                    'nama'=>'Mandiri',
                    'kode_bank'=>"008",
                    'deskripsi'=>'Bank Mandiri'
                ]
            ]);
    }
}
