<?php

namespace App\Charts;

use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use App\Models\Backend\SPM\Tahun;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class SPMPuskesmasChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build($kode, $uraian = null)
    {
        // Ambil Puskesmas berdasarkan user yang sedang login
        $puskesmasId = auth()->user()->puskesmas_id;
        $tahunId = session('tahun_spm', 1);

        $kodeEdit = preg_replace('/A/', 'B', $kode);

        // Siapkan array untuk menyimpan data pencapaian per indikator
        $data = [];
        // Ambil data SPM untuk Puskesmas yang sesuai
        $spm = Spm::where('puskesmas_id', $puskesmasId)
            ->whereHas('subLayanan', function ($query) use ($kodeEdit) {
                $query->where('kode', 'like', substr($kodeEdit, 0, 4) . '%');
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

        $labelTarget = 'Jumlah Total yang Harus Dilayani';
        $labelCapaian = 'Jumlah yang Terlayani';
        if ($spm->subLayanan->layanan_id == 3) {
            $labelTarget = 'Alokasi Anggaran (Rp.)';
            $labelCapaian = 'Realisasi (Rp.)';
        }

        // Buat chart
        $chart = $this->chart->barChart()
            ->addData($labelCapaian, $pencapaianValues)
            ->addData($labelTarget, $targetValues)
            ->setGrid(false)
            ->setXAxis($indikatorNames);

        if ($spm->subLayanan->layanan_id == 3) {
            $chart->setTitle('Alokasi dan Realisasi Anggaran Puskesmas Tahun ' . Tahun::find($tahunId)->tahun);
        } else {
            $chart->setTitle('Pencapaian StaPMinKes Puskesmas ' . Tahun::find($tahunId)->tahun)->setSubtitle('Sub Indikator ' . $kode . ' - ' . $uraian);
        }
        if (session('posisi_chart_spm', 1) == 2) {
            $chart->setHeight(1000) // Atur tinggi chart
                ->setHorizontal(true); // Mengatur chart menjadi horizontal
        }

        return $chart;
    }
}
