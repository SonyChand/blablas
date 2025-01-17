<?php

namespace App\Http\Controllers\Backend\SPM;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Backend\SPM\Spm;
use App\Charts\SPMPuskesmasChart;
use App\Models\Backend\SPM\Tahun;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\SPM\Puskesmas;
use App\Charts\SPMPuskesmasRekapChart;
use App\Models\Backend\SPM\PeriodeSPM;
use App\Models\Backend\SPM\SubLayanan;
use App\Http\Services\Backend\Spm\SpmService;

class SpmController extends Controller
{
    use LogsActivity;
    public function __construct(private SpmService $spmService)
    {
        $this->middleware('permission:spm-list|spm-edit', ['only' => ['index', 'full']]);
        $this->middleware('permission:spm-edit', ['only' => ['edit', 'update', 'liveUpdate', 'fullStore', 'tahunSpm']]);
        $this->middleware('permission:spm-dinkes', ['only' => ['rekap', 'rekapFull', 'rekapServerside', 'periodeSpm']]);
        $this->spmService = $spmService;
    }
    public function index()
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'StaPMinKes Ciamis Tahun ' . $tahunSpm->tahun;
        $periodeSpm = PeriodeSPM::where('tahun_id', session('tahun_spm', 1))->first();

        return view('backend.spm.spm.index', compact('title', 'tahuns', 'tahunSpm', 'periodeSpm'));
    }


    public function full()
    {
        $layanan1 = SubLayanan::where('layanan_id', 1)->get();
        $layanan2 = SubLayanan::where('layanan_id', 2)->get();
        $layanan3 = SubLayanan::where('layanan_id', 3)->get();

        $tahuns = Tahun::all();
        $tahun = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Data SPM';

        return view('backend.spm.spm.full', compact('title', 'tahun', 'tahuns', 'layanan1', 'layanan2', 'layanan3'));
    }

    public function detail(SPMPuskesmasChart $chart, $id)
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Detail Indikator StaPMinKes Ciamis Tahun ' . $tahunSpm->tahun;
        $periodeSpm = PeriodeSPM::where('tahun_id', session('tahun_spm', 1))->first();

        $spmDetail = Spm::findOrFail($id);
        $cutCode = preg_replace('/A/', 'B', $spmDetail->subLayanan->kode);
        $spms = Spm::where('tahun_id', $tahunSpm->id)
            ->where('puskesmas_id', $spmDetail->puskesmas_id)
            ->whereHas('subLayanan', function ($query) use ($cutCode) {
                $query->where('kode', 'like', substr($cutCode, 0, 4) . '%');
            })
            ->get();
        $chart = $chart->build($spmDetail->subLayanan->kode, $spmDetail->subLayanan->uraian);

        return view('backend.spm.spm.detail.index', compact('title', 'tahuns', 'tahunSpm', 'periodeSpm', 'spmDetail', 'chart', 'spms'));
    }

    public function detailRekap(SPMPuskesmasRekapChart $chart, $id)
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Detail Indikator StaPMinKes Ciamis Tahun ' . $tahunSpm->tahun;
        $periodeSpm = PeriodeSPM::where('tahun_id', session('tahun_spm', 1))->first();

        $spmDetail = Spm::findOrFail($id);
        $cutCode = preg_replace('/A/', 'B', $spmDetail->subLayanan->kode);
        $spms = Spm::where('tahun_id', $tahunSpm->id)
            ->where('puskesmas_id', $spmDetail->puskesmas_id)
            ->whereHas('subLayanan', function ($query) use ($cutCode) {
                $query->where('kode', 'like', substr($cutCode, 0, 4) . '%');
            })
            ->get();
        $chart = $chart->build($id);

        return view('backend.spm.spm.detail.rekap.index', compact('title', 'tahuns', 'tahunSpm', 'periodeSpm', 'spmDetail', 'chart', 'spms'));
    }

    public function fullStore(Request $request)
    {
        dd($request->all());
    }

    public function rekap()
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Data SPM';
        $puskesmases = Puskesmas::all();

        return view('backend.spm.spm.rekap.indexv1', compact('title', 'tahuns', 'tahunSpm', 'puskesmases'));
    }



    public function liveUpdate(Request $request)
    {
        try {
            // Preprocess the input data to remove dots and commas
            $inputData = $request->all();
            foreach ($inputData as $key => $value) {
                if (is_string($value)) {
                    // Remove dots and commas from the input
                    $inputData[$key] = str_replace(['.', ','], '', $value);
                }
            }

            // dd($inputData);

            $validatedData = validator($inputData, [
                'terlayani_januari' => 'integer|nullable',
                'terlayani_februari' => 'integer|nullable',
                'terlayani_maret' => 'integer|nullable',
                'terlayani_april' => 'integer|nullable',
                'terlayani_mei' => 'integer|nullable',
                'terlayani_juni' => 'integer|nullable',
                'terlayani_juli' => 'integer|nullable',
                'terlayani_agustus' => 'integer|nullable',
                'terlayani_september' => 'integer|nullable',
                'terlayani_oktober' => 'integer|nullable',
                'terlayani_november' => 'integer|nullable',
                'terlayani_desember' => 'integer|nullable',
                'total_dilayani' => 'integer|nullable',
            ])->validate();
            // dd($inputData);

            // Validate the incoming request data


            // Find the SPM record by ID
            $spm = Spm::findOrFail($request->id);
            $spmOriginal = $spm->getOriginal(); // Get the original values before the update

            // Compare original values with validated data
            $hasChanges = false;
            foreach ($validatedData as $key => $value) {
                if ($spmOriginal[$key] != $value) {
                    $hasChanges = true;
                    break;
                }
            }

            if ($hasChanges) {
                $spm->update($validatedData);

                $description = "Nilai SPM " . $spm->subLayanan->kode . " telah diubah oleh " . Auth::user()->name;
                $this->logActivity('spms', Auth::user(), null, $description);

                // Return a success response
                return response()->json(['message' => 'Nilai SPM Berhasil Diubah...']);
            } else {
                // Return a message indicating no changes were made
                return response()->json(['message' => 'Tidak ada perubahan'], 200);
            }
        } catch (\Exception $error) {
            // Return an error response
            return response()->json(['error' => $error->getMessage()], 500); // Return a 500 status code for server errors
        }
    }

    public function getSubLayanan($id)
    {
        $indukSubLayanan = SubLayanan::where('id', $id)->first();
        $keyCode = preg_replace('/A/', 'B', $indukSubLayanan->kode);
        $keyCode = preg_replace('/(\d+\.\w+)(\.\d+)?/', '$1', $keyCode) . '.%';
        // dd($keyCode);
        $tesBos = Spm::where('tahun_id', session('tahun_spm', 1))
            ->where('puskesmas_id', Auth()->user()->puskesmas_id)
            ->whereHas('subLayanan', function ($query) use ($keyCode) {
                $query->where('kode', 'like', $keyCode);
            })
            ->with('subLayanan:id,kode,uraian,satuan,catatan')
            ->orderBy('sub_layanan_id', 'asc')
            ->get();
        $tesBos = $tesBos->map(function ($item) {
            return [
                'id' => $item->id,
                'sub_layanan_id' => $item->sub_layanan_id,
                'kode' => $item->subLayanan->kode,
                'uraian' => $item->subLayanan->uraian,
                'satuan' => $item->subLayanan->satuan,
                'catatan' => $item->subLayanan->catatan,
                'terlayani_januari' => $item->terlayani_januari,
                'terlayani_februari' => $item->terlayani_februari,
                'terlayani_maret' => $item->terlayani_maret,
                'terlayani_april' => $item->terlayani_april,
                'terlayani_mei' => $item->terlayani_mei,
                'terlayani_juni' => $item->terlayani_juni,
                'terlayani_juli' => $item->terlayani_juli,
                'terlayani_agustus' => $item->terlayani_agustus,
                'terlayani_september' => $item->terlayani_september,
                'terlayani_oktober' => $item->terlayani_oktober,
                'terlayani_november' => $item->terlayani_november,
                'terlayani_desember' => $item->terlayani_desember,
                'total_dilayani' => $item->total_dilayani,
                'total_terlayani' => $item->total_terlayani, // Access the computed attribute
                'belum_terlayani' => $item->belum_terlayani,
                'total_pencapaian' => round($item->pencapaian, 2) . '%',
                // Add other fields as necessary
            ];
        });
        $response = [
            'uraian' => $indukSubLayanan->uraian,
            'subLayanan' => $tesBos
        ];

        // Return the response as JSON
        return response()->json($response);
    }

    public function getSubLayananRekap($id)
    {
        $indukSubLayanan = SubLayanan::where('id', $id)->first();
        $keyCode = preg_replace('/A/', 'B', $indukSubLayanan->kode);
        $keyCode = preg_replace('/(\d+\.\w+)(\.\d+)?/', '$1', $keyCode) . '.%';
        $tesBos = Spm::where('tahun_id', session('tahun_spm', 1))
            ->where('puskesmas_id', session('rekapPuskesmas', 1) == 'all' ? 1 : session('rekapPuskesmas', 1))
            ->whereHas('subLayanan', function ($query) use ($keyCode) {
                $query->where('kode', 'like', $keyCode);
            })
            ->with('subLayanan:id,kode,uraian,satuan,catatan')
            ->orderBy('sub_layanan_id', 'asc')
            ->get();

        $totalDilayani = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(total_dilayani) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalJanuari = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_januari) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalFebruari = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_februari) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalMaret = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_maret) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalApril = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_april) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalMei = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_mei) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalJuni = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_juni) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalJuli = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_juli) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalAgustus = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_agustus) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalSeptember = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_september) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalOktober = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_oktober) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalNovember = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_november) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');
        $totalDesember = Spm::where('tahun_id', session('tahun_spm', 1))
            ->select('sub_layanan_id', DB::raw('SUM(terlayani_desember) as total'))
            ->groupBy('sub_layanan_id')
            ->pluck('total', 'sub_layanan_id');


        $tesBos = $tesBos->map(function ($item) use ($totalDilayani, $totalJanuari, $totalFebruari, $totalMaret, $totalApril, $totalMei, $totalJuni, $totalJuli, $totalAgustus, $totalSeptember, $totalOktober, $totalNovember, $totalDesember) {
            $totalTerlayani = number_format(($totalJanuari[$item->sub_layanan_id] + $totalFebruari[$item->sub_layanan_id] + $totalMaret[$item->sub_layanan_id] + $totalApril[$item->sub_layanan_id] + $totalMei[$item->sub_layanan_id] + $totalJuni[$item->sub_layanan_id] + $totalJuli[$item->sub_layanan_id] + $totalAgustus[$item->sub_layanan_id] + $totalSeptember[$item->sub_layanan_id] + $totalOktober[$item->sub_layanan_id] + $totalNovember[$item->sub_layanan_id] + $totalDesember[$item->sub_layanan_id]), 0, ',', '.') ?? 0;
            $totalPencapaian = number_format((($totalTerlayani ?? 0 / $totalDilayani[$item->sub_layanan_id] ?? 0) * 100), 0, ',', '.') ?? 0;
            $belumTerlayani = number_format(($totalDilayani[$item->sub_layanan_id] - $totalTerlayani), 0, ',', '.') ?? 0;
            if (session('rekapPuskesmas', 1) != 'all') {
                return [
                    'id' => $item->id,
                    'sub_layanan_id' => $item->sub_layanan_id,
                    'kode' => $item->subLayanan->kode,
                    'uraian' => $item->subLayanan->uraian,
                    'satuan' => $item->subLayanan->satuan,
                    'catatan' => $item->subLayanan->catatan,
                    'terlayani_januari' => $item->terlayani_januari,
                    'terlayani_februari' => $item->terlayani_februari,
                    'terlayani_maret' => $item->terlayani_maret,
                    'terlayani_april' => $item->terlayani_april,
                    'terlayani_mei' => $item->terlayani_mei,
                    'terlayani_juni' => $item->terlayani_juni,
                    'terlayani_juli' => $item->terlayani_juli,
                    'terlayani_agustus' => $item->terlayani_agustus,
                    'terlayani_september' => $item->terlayani_september,
                    'terlayani_oktober' => $item->terlayani_oktober,
                    'terlayani_november' => $item->terlayani_november,
                    'terlayani_desember' => $item->terlayani_desember,
                    'total_dilayani' => $item->total_dilayani,
                    'total_terlayani' => $item->total_terlayani, // Access the computed attribute
                    'belum_terlayani' => $item->belum_terlayani,
                    'total_pencapaian' => $item->pencapaian ?? 0 . '%',
                    // Add other fields as necessary
                ];
            } else {
                return [
                    'id' => $item->id,
                    'sub_layanan_id' => $item->sub_layanan_id,
                    'kode' => $item->subLayanan->kode,
                    'uraian' => $item->subLayanan->uraian,
                    'satuan' => $item->subLayanan->satuan,
                    'catatan' => $item->subLayanan->catatan,
                    'terlayani_januari' => $totalJanuari[$item->sub_layanan_id],
                    'terlayani_februari' => $totalFebruari[$item->sub_layanan_id],
                    'terlayani_maret' => $totalMaret[$item->sub_layanan_id],
                    'terlayani_april' => $totalApril[$item->sub_layanan_id],
                    'terlayani_mei' => $totalMei[$item->sub_layanan_id],
                    'terlayani_juni' => $totalJuni[$item->sub_layanan_id],
                    'terlayani_juli' => $totalJuli[$item->sub_layanan_id],
                    'terlayani_agustus' => $totalAgustus[$item->sub_layanan_id],
                    'terlayani_september' => $totalSeptember[$item->sub_layanan_id],
                    'terlayani_oktober' => $totalOktober[$item->sub_layanan_id],
                    'terlayani_november' => $totalNovember[$item->sub_layanan_id],
                    'terlayani_desember' => $totalDesember[$item->sub_layanan_id],
                    'total_dilayani' => number_format($totalDilayani[$item->sub_layanan_id], 0, ',', '.') ?? 0,
                    'total_terlayani' => $totalTerlayani, // Access the computed attribute
                    'belum_terlayani' => $belumTerlayani,
                    'total_pencapaian' => $totalPencapaian ?? 0 . '%',
                ];
            }
        });

        $response = [
            'uraian' => $indukSubLayanan->uraian,
            'subLayanan' => $tesBos
        ];


        // Return the response as JSON
        return response()->json($response);
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->spmService->dataTable($request);
    }

    public function serversideAnggaran(Request $request): JsonResponse
    {
        return $this->spmService->dataTableAnggaran($request);
    }


    public function rekapServerside(Request $request): JsonResponse
    {
        if (session('rekapPuskesmas', 'all') != 'all') {
            return $this->spmService->dataTable($request);
        } else {
            return $this->spmService->dataTableRekap($request);
        }
    }

    public function rekapServersideAnggaran(Request $request): JsonResponse
    {
        if (session('rekapPuskesmas', 'all') != 'all') {
            return $this->spmService->dataTableAnggaran($request);
        } else {
            return $this->spmService->dataTableRekapAnggaran($request);
        }
    }


    public function tahunSpm(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|min:1|max:2'
        ]);
        session([
            'tahun_spm' => $validatedData['tahun'],
        ]);
        return redirect()->back()->with('success', 'Tahun SPM berhasil diubah.');
    }

    public function tahunSpmRekap(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|min:1|max:2',
            'rekapPuskesmas' => 'required'
        ]);
        session([
            'tahun_spm' => $validatedData['tahun'],
            'rekapPuskesmas' => $validatedData['rekapPuskesmas'],
        ]);
        return redirect()->back()->with('success', 'Puskesmas dan Tahun SPM berhasil diubah.');
    }

    public function periodeSpm(Request $request)
    {
        $validatedData = $request->validate([
            'periode_awal' => 'required|min:1|max:2',
            'periode_akhir' => 'required|min:1|max:2',
        ]);
        $cekData = PeriodeSPM::where('tahun_id', session('tahun_spm', 1))->first();
        if ($cekData) {
            $cekData->update([
                'periode_awal' => $validatedData['periode_awal'],
                'periode_akhir' => $validatedData['periode_akhir'],
            ]);
            return redirect()->back()->with('success', 'Periode SPM berhasil diubah.');
        } else {
            PeriodeSPM::create([
                'tahun_id' => session('tahun_spm', 1),
                'periode_awal' => $validatedData['periode_awal'],
                'periode_akhir' => $validatedData['periode_akhir'],
            ]);
            return redirect()->back()->with('success', 'Periode SPM berhasil ditambahkan.');
        }
    }
}
