<?php

namespace Database\Seeders;

use App\Models\Backend\SPM\Spm;
use Illuminate\Database\Seeder;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;

class SpmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puskesmasList = Puskesmas::all();
        $subLayananList = SubLayanan::all();
        $tahunList = Tahun::all();

        $spmData = []; // Array untuk menyimpan data yang akan diinsert

        foreach ($puskesmasList as $puskesmas) {
            foreach ($subLayananList as $subLayanan) {
                foreach ($tahunList as $tahun) {
                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                        $spmData[] = [
                            'puskesmas_id' => $puskesmas->id,
                            'sub_layanan_id' => $subLayanan->id,
                            'tahun_id' => $tahun->id,
                            'dilayani' => 0,
                            'terlayani' => 0,
                            'bulan' => $bulan,
                            'created_at' => now(), // Tambahkan timestamp
                            'updated_at' => now(), // Tambahkan timestamp
                        ];

                        // Jika jumlah data mencapai 1000, lakukan batch insert
                        if (count($spmData) >= 1000) {
                            Spm::insert($spmData);
                            $spmData = []; // Reset array
                        }
                    }
                }
            }
        }

        // Insert sisa data yang mungkin belum terinsert
        if (!empty($spmData)) {
            Spm::insert($spmData);
        }
    }
}
