<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\SPM\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layananData = [
            [
                'kode' => 'A',
                'nama' => 'PERSENTASE PENCAPAIAN PENERIMA LAYANAN DASAR (80%)',
            ],
            [
                'kode' => 'B',
                'nama' => 'PERSENTASE PENCAPAIAN MUTU MINIMAL LAYANAN DASAR (20%)',
            ],
            [
                'kode' => 'C',
                'nama' => 'ALOKASI ANGGARAN DAN REALISASI',
            ]
        ];
        foreach ($layananData as $layanan) {
            Layanan::create($layanan);
        }
    }
}
