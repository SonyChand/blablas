<?php

namespace App\Charts;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SPMPuskesmasRekapChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build($id)
    {
        // Ambil semua data SPM
        $puskesmases = Puskesmas::all(); // Ambil 37 Puskesmas

        // Siapkan array untuk menyimpan persentase pencapaian
        $data = [];

        $subLayanan = SubLayanan::find($id);

        foreach ($puskesmases as $puskesmas) {
            $spm = Spm::where('puskesmas_id', $puskesmas->id)
                ->whereHas('subLayanan', function ($query) use ($subLayanan) {
                    $query->where('id', $subLayanan->id);
                })
                ->where('tahun_id', session('tahun_spm', 1))
                ->first();
            $data[] = [
                'puskesmas' => str_replace('UPT PKM ', '', $puskesmas->nama), // Ambil nama puskesmas
                'pencapaian' => round($spm->pencapaian, 2) ?? 0, // Ambil persentase pencapaian
            ];
        }

        // Urutkan data berdasarkan pencapaian dari yang tertinggi ke terendah
        usort($data, function ($a, $b) {
            return $b['pencapaian'] <=> $a['pencapaian'];
        });

        // Siapkan data untuk chart
        $puskesmasNames = array_column($data, 'puskesmas');
        $pencapaianValues = array_column($data, 'pencapaian');

        // Tentukan warna untuk pencapaian

        // Buat chart
        $chart = $this->chart->barChart()
            ->setTitle('Persentase Pencapaian Puskesmas ' . Tahun::find(session('tahun_spm', 1))->tahun)
            ->setSubtitle($subLayanan->kode . '. ' . $subLayanan->uraian)
            ->addData('Pencapaian', $pencapaianValues)
            ->setGrid(false)
            ->setXAxis($puskesmasNames);


        if (session('posisi_chart_spm', 1) == 2) {
            $chart->setHeight(1000) // Atur tinggi chart
                ->setHorizontal(true); // Mengatur chart menjadi horizontal
        }

        return $chart;
    }
}
