<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_set')->insert([
            [
                'id'=>1,
                'status'=>'AWAITING'
            ],
            [
                'id'=>2,
                'status'=>'REJECTED'
            ],
            [
                'id'=>3,
                'status'=>'ACCEPTED'
            ],
            [
                'id'=>4,
                'status'=>'NEED REVISION'
            ],
            [
                'id'=>5,
                'status'=>'LIMIT CONFIRMATION'
            ],
            [
                'id'=>6,
                'status'=>'PARTIAL CONFIRMATION'
            ],
            [
                'id'=>7,
                'status'=>'PARTIAL APPROVED'
            ]
        ]);
    }
}
