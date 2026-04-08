<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'fullname' => 'Nguyen Van A' . $i,
                'username' => 'user' . $i,
                'password' => Hash::make('123456'),
                'email' => 'user' . $i . '@gmail.com',
                'role' => 1,
            ]);
        }
    }
}
