<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 1
        ]);

        User::create([
            'username' => 'Member One',
            'email' => 'member1@gmail.com',
            'password' => Hash::make('member1'),
            'role' => 2
        ]);

        User::create([
            'username' => 'Member Two',
            'email' => 'member2@gmail.com',
            'password' => Hash::make('member2'),
            'role' => 2
        ]);
    }
}
