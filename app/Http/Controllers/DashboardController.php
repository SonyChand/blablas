<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backend\SPM\Tahun;
use App\Charts\DashboardSPMAdminChart;
use App\Models\Backend\SPM\SubLayanan;
use App\Charts\DashboardSPMPuskesmasChart;
use App\Models\Managements\Letters\IncomingLetter;
use App\Models\Managements\Letters\OutgoingLetter;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:spm-list|spm-edit|spm-dinkes', ['only' => ['indexSpm', 'chartSpmPuskesmas']]);
        $this->middleware('permission:spm-dinkes', ['only' => ['index', 'chartSpm']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $incomingLettersCount = IncomingLetter::count();
        $outgoingLettersCount = OutgoingLetter::count();

        return view('dashboard.index', compact('incomingLettersCount', 'outgoingLettersCount'));
    }

    public function indexSpm(DashboardSPMPuskesmasChart $chart, DashboardSPMAdminChart $adminChart)
    {
        $title = 'Dashboard StaPMinKes Ciamis';
        $tahuns = Tahun::all();
        if (auth()->user()->roles->first()->id == 1) {
            $subLayanans = SubLayanan::where('layanan_id', 1)->get();
            if (session('chart_spm', 1) == 'all') {
                $charts = [];

                // Loop untuk membangun chart dari 1 hingga 12
                for ($i = 1; $i <= 12; $i++) {
                    $kodeSpm = "{$i}.A.1"; // Membuat kode SPM
                    $charts[] = $adminChart->buildAll($i); // Memanggil fungsi build dengan kode dan ID sub layanan
                }

                return view('dashboard.spm.admin.index', compact('title', 'tahuns', 'subLayanans', 'charts'));
            } else {
                $chart = $adminChart->build();
                return view('dashboard.spm.admin.index', compact('chart', 'title', 'tahuns', 'subLayanans'));
            }
        } else {
            $chart = $chart->build();
            return view('dashboard.spm.index', compact('chart', 'title', 'tahuns'));
        }
    }

    public function chartSpm(Request $request)
    {
        $validatedData = $request->validate([
            'posisi_chart_spm' => 'required|min:1|max:1',
            'chart_spm' => 'required|min:1|max:3',
        ]);
        session([
            'posisi_chart_spm' => $validatedData['posisi_chart_spm'],
            'chart_spm' => $validatedData['chart_spm'],
        ]);
        return redirect()->back()->with('success', 'Indikator dan Posisi Grafik StaPMinKes berhasil diubah.');
    }

    public function chartSpmPuskesmas(Request $request)
    {
        $validatedData = $request->validate([
            'posisi_chart_spm' => 'required|min:1|max:1',
        ]);
        session([
            'posisi_chart_spm' => $validatedData['posisi_chart_spm'],
        ]);
        return redirect()->back()->with('success', 'Posisi Grafik StaPMinKes berhasil diubah.');
    }
}
