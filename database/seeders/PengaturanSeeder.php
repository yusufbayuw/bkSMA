<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create([
            'nama' => 'Kuota IPA',
            'nilai' => '78',
        ]);
        Pengaturan::create([
            'nama' => 'Kuota IPS',
            'nilai' => '20',
        ]);
    }
}
