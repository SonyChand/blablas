<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\SPM\Tahun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TahunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataTahun = [
            ['tahun' => '2021'],
            ['tahun' => '2022'],
            ['tahun' => '2023'],
            ['tahun' => '2024'],
            ['tahun' => '2025'],
            ['tahun' => '2026'],
        ];
        foreach ($dataTahun as $tahun) {
            Tahun::create($tahun);
        }
    }
}
