<?php

namespace App\Charts;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use App\Models\Backend\SPM\Tahun;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardSPMPuskesmasChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build()
    {
        // Ambil Puskesmas berdasarkan user yang sedang login
        $puskesmasId = auth()->user()->puskesmas_id;
        $tahunId = session('tahun_spm', 1);

        // Siapkan array untuk menyimpan data pencapaian per indikator
        $data = [];
        // Ambil data SPM untuk Puskesmas yang sesuai
        $spm = Spm::where('puskesmas_id', $puskesmasId)
            ->whereHas('subLayanan', function ($query) {
                $query->where('layanan_id', 1);
            })
            ->where('tahun_id', $tahunId)
            ->get();

        if ($spm) {
            foreach ($spm as $spm) {
                $totalTerlayani = (
                    $spm->terlayani_januari +
                    $spm->terlayani_februari +
                    $spm->terlayani_maret +
                    $spm->terlayani_april +
                    $spm->terlayani_mei +
                    $spm->terlayani_juni +
                    $spm->terlayani_juli +
                    $spm->terlayani_agustus +
                    $spm->terlayani_september +
                    $spm->terlayani_oktober +
                    $spm->terlayani_november +
                    $spm->terlayani_desember
                );

                // Simpan data pencapaian dan target
                $data[] = [
                    'indikator' => $spm->subLayanan->kode,
                    'pencapaian' => round($totalTerlayani, 2),
                    'target' => round($spm->total_dilayani ?? 0, 2),
                ];
            }
        }

        // Siapkan data untuk chart
        $indikatorNames = array_column($data, 'indikator');
        $pencapaianValues = array_column($data, 'pencapaian');
        $targetValues = array_column($data, 'target');

        // Buat chart
        $chart = $this->chart->barChart()
            ->setTitle('Pencapaian StaPMinKes Puskesmas ' . Tahun::find($tahunId)->tahun)
            ->setSubtitle('Indikator 1.A.1 sampai 12.A.1')
            ->addData('Jumlah yang Terlayani', $pencapaianValues)
            ->addData('Jumlah Total yang Harus Dilayani', $targetValues)
            ->setGrid(false)
            ->setXAxis($indikatorNames);

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
