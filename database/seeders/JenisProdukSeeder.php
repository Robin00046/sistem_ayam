<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\JenisProduk::create([
            'nama' => 'Anak Ayam Broiler',
            'harga' => 1500,
        ]);

        \App\Models\JenisProduk::create([
            'nama' => 'Obat',
            'harga' => 250000,
        ]);

        \App\Models\JenisProduk::create([
            'nama' => 'Pakan',
            'harga' => 500000,
        ]);
    }
}
