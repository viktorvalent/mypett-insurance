<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')
            ->insert([
                [
                    'id'=>1,
                    'nama_role'=>'Admin'
                ],
                [
                    'id'=>2,
                    'nama_role'=>'Member'
                ]
            ]);
    }
}
