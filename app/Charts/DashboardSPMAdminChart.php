<?php

namespace App\Charts;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use App\Models\Backend\SPM\Tahun;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardSPMAdminChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build()
    {
        // Ambil semua data SPM
        $puskesmases = Puskesmas::all(); // Ambil 37 Puskesmas

        // Siapkan array untuk menyimpan persentase pencapaian
        $data = [];

        foreach ($puskesmases as $puskesmas) {
            $kodeSpm = session('chart_spm', 1) . '.A.1';
            $spm = Spm::where('puskesmas_id', $puskesmas->id)
                ->whereHas('subLayanan', function ($query) use ($kodeSpm) {
                    $query->where('kode', '=', $kodeSpm);
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

        $subLayanan = SubLayanan::find(session('chart_spm', 1));

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

    public function buildAll($subLayananId)
    {
        // Ambil semua data SPM untuk tahun yang ditentukan
        $tahunId = session('tahun_spm', 1);
        $puskesmases = Puskesmas::all(); // Ambil semua Puskesmas

        // Siapkan array untuk menyimpan persentase pencapaian
        $data = [];

        // Ambil semua SPM untuk semua Puskesmas dalam satu query
        $spms = Spm::where('tahun_id', $tahunId)
            ->whereHas('subLayanan', function ($query) use ($subLayananId) {
                $query->where('id', $subLayananId);
            })
            ->get();

        // Buat array untuk memudahkan pencarian SPM berdasarkan puskesmas_id
        $spmByPuskesmasId = $spms->keyBy('puskesmas_id');

        foreach ($puskesmases as $puskesmas) {
            $spm = $spmByPuskesmasId->get($puskesmas->id);
            $data[] = [
                'puskesmas' => str_replace('UPT PKM ', '', $puskesmas->nama), // Ambil nama puskesmas
                'pencapaian' => round($spm->pencapaian ?? 0, 2), // Ambil persentase pencapaian
            ];
        }

        // Urutkan data berdasarkan pencapaian dari yang tertinggi ke terendah
        usort($data, function ($a, $b) {
            return $b['pencapaian'] <=> $a['pencapaian'];
        });

        // Siapkan data untuk chart
        $puskesmasNames = array_column($data, 'puskesmas');
        $pencapaianValues = array_column($data, 'pencapaian');

        // Ambil sub layanan
        $subLayanan = SubLayanan::find($subLayananId);

        // Buat chart
        $chart = $this->chart->barChart()
            ->setTitle($subLayanan->kode . '. ' . $subLayanan->uraian)
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
