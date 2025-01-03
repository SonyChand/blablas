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
                    $spmData[] = [
                        'puskesmas_id' => $puskesmas->id,
                        'sub_layanan_id' => $subLayanan->id,
                        'tahun_id' => $tahun->id,
                        'terlayani_januari' => 0,
                        'terlayani_februari' => 0,
                        'terlayani_maret' => 0,
                        'terlayani_april' => 0,
                        'terlayani_mei' => 0,
                        'terlayani_juni' => 0,
                        'terlayani_juli' => 0,
                        'terlayani_agustus' => 0,
                        'terlayani_september' => 0,
                        'terlayani_oktober' => 0,
                        'terlayani_november' => 0,
                        'terlayani_desember' => 0,
                        'terlayani' => 0,
                        'total_dilayani' => 0,
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

        // Insert sisa data yang mungkin belum terinsert
        if (!empty($spmData)) {
            Spm::insert($spmData);
        }
    }
}
