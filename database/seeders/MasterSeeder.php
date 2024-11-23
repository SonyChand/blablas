<?php

namespace Database\Seeders;

use App\Models\Master\Source;
use Illuminate\Database\Seeder;
use App\Models\Master\MasterSource;
use App\Models\Master\MasterEmployeeRank;
use App\Models\Master\MasterEmployeeType;
use App\Models\Master\MasterEmployeeCollege;
use App\Models\Master\MasterEmployeeWorkUnit;
use App\Models\Master\MasterEmployeeEducation;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Master Employee Types
        $masterEmployeeType = ['PNS', 'PPPK'];

        foreach ($masterEmployeeType as $type) {
            MasterEmployeeType::create(['name' => $type]);
        }

        $masterEmployeeRanks = [
            'Juru Muda - I/a',
            'Juru Muda Tingkat I - I/b',
            'Juru - I/c',
            'Juru Tingkat I - I/d',
            'Pengatur Muda - II/a',
            'Pengatur Muda Tingkat I - II/b',
            'Pengatur - II/c',
            'Pengatur Tingkat I - II/d',
            'Penata Muda - III/a',
            'Penata Muda Tingkat I - III/b',
            'Penata - III/c',
            'Penata Tingkat I - III/d',
            'Pembina - IV/a',
            'Pembina Tingkat I - IV/b',
            'Pembina Muda - IV/c',
            'Pembina Madya - IV/d',
            'Pembina Utama - IV/e',
        ];

        foreach ($masterEmployeeRanks as $rank) {
            MasterEmployeeRank::create(['name' => $rank]);
        }

        $masterEmployeeEducations = [
            'SD',
            'SMP',
            'SMA',
            'SMK',
            'Diploma 3',
            'Diploma 4 / Sarjana',
            'Magister',
            'Doktor',
            'Profesional',
        ];

        foreach ($masterEmployeeEducations as $education) {
            MasterEmployeeEducation::create(['name' => $education]);
        }

        $masterEmployeeColleges = [
            'STMIK Mardira Indonesia',
            'Universitas Indonesia',
            'Institut Teknologi Bandung',
            'Universitas Gadjah Mada',
            'Universitas Airlangga',
            'Institut Pertanian Bogor',
            'Universitas Diponegoro',
            'Universitas Brawijaya',
            'Universitas Hasanuddin',
            'Universitas Negeri Jakarta',
            'Universitas Padjadjaran',
            'STMIK Mardira Indonesia',
            'Universitas Kristen Satya Wacana',
            'Universitas Pelita Harapan',
            'Universitas Mercu Buana',
            'Universitas Trisakti',
            'Harvard University',
            'Stanford University',
            'Massachusetts Institute of Technology',
            'California Institute of Technology',
            'University of Oxford',
            'University of Cambridge',
            'ETH Zurich - Swiss Federal Institute of Technology',
            'University of Chicago',
            'Imperial College London',
            'University College London',
            'National University of Singapore',
            'Tsinghua University',
            'University of Tokyo',
            'University of Toronto',
            'University of Melbourne',
            'Universitas Sebelas Maret',
            'Universitas Sumatera Utara',
            'Universitas Andalas',
            'Universitas Negeri Yogyakarta',
            'Universitas Jenderal Soedirman',
            'Yale University',
            'Columbia University',
            'Princeton University',
            'Johns Hopkins University',
            'University of California, Berkeley'
        ];

        foreach ($masterEmployeeColleges as $college) {
            MasterEmployeeCollege::create(['name' => $college]);
        }

        $masterEmployeeWorkUnits = [
            "Dinkes Kab. Ciamis (Kesmas)",
            "Dinkes Kab. Ciamis (P2P)",
            "Dinkes Kab. Ciamis (SDK)",
            "Dinkes Kab. Ciamis (Sekretariat)",
            "Dinkes Kab. Ciamis (Yankes)",
            "UPTD Farmasi Kab. Ciamis",
            "UPTD Labkesda Kab. Ciamis",
            "UPTD Puskesmas Banjarsari",
            "UPTD Puskesmas Baregbeg",
            "UPTD Puskesmas Ciamis",
            "UPTD Puskesmas Cihaurbeuti",
            "UPTD Puskesmas Sukamulya",
            "UPTD Puskesmas Sindangkasih",
            "UPTD Puskesmas Mandalika Cikoneng",
            "UPTD Puskesmas Imbanagara",
            "UPTD Puskesmas Cijeungjing",
            "UPTD Puskesmas Cisaga",
            "UPTD Puskesmas Kertahayu",
            "UPTD Puskesmas Ciulu",
        ];

        foreach ($masterEmployeeWorkUnits as $workUnit) {
            MasterEmployeeWorkUnit::create(['name' => $workUnit]);
        }

        $masterSources = [
            'Bupati',
            'Dinas Terkait',
            'Lainnya',
            'LSM',
            'Provinsi',
            'Puskesmas',
            'Surat Kabar',
        ];

        foreach ($masterSources as $source) {
            MasterSource::create(['name' => $source]);
        }
    }
}
