<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Admin',
            'alamat' => 'Krajan 1, Surabaya',
            'phone' => '08123456789',
            'password' => bcrypt('password'),
        ])->assignRole('admin');

        User::create([
            'name' => 'kandang',
            'alamat' => 'Krajan 2, Surabaya',
            'phone' => '08123456788',
            'password' => bcrypt('kandang123'),
        ])->assignRole('kandang');
    }
}
