<?php

namespace App\Http\Services\Backend\Spm;

use Exception;
use App\Models\Backend\SPM\Spm;
use Faker\Core\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class SpmService
{
    protected $tableName = 'spms';
    public function dataTablev2($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Spm::where('tahun_id', session('tahun_spm') ?? 1)
                    ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                    ->whereHas('subLayanan', function ($query) {
                        $query->where('versi', session('versi_spm', 1));
                    })
                    ->count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Spm::where('tahun_id', session('tahun_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan,catatan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani_januari', 'terlayani_februari', 'terlayani_maret', 'terlayani_april', 'terlayani_mei', 'terlayani_juni', 'terlayani_juli', 'terlayani_agustus', 'terlayani_september', 'terlayani_oktober', 'terlayani_november', 'terlayani_desember', 'total_dilayani']);
                } else {
                    $data = Spm::filter($request->search['value'])
                        ->latest()
                        ->where('tahun_id', session('tahun_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan,catatan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani_januari', 'terlayani_februari', 'terlayani_maret', 'terlayani_april', 'terlayani_mei', 'terlayani_juni', 'terlayani_juli', 'terlayani_agustus', 'terlayani_september', 'terlayani_oktober', 'terlayani_november', 'terlayani_desember', 'total_dilayani']);

                    $totalFiltered = $data->count();
                }
                return DataTables::of($data)
                    ->setOffset($start)
                    ->editColumn('sub_layanan_id', function ($data) {
                        // Mendapatkan uraian dari subLayanan
                        $uraian = '<div>' . $data->subLayanan->uraian . '</div>';

                        // Memeriksa versi SPM dan catatan
                        if (session('versi_spm', 1) == 2 && $data->subLayanan->catatan) {
                            $catatan = $data->subLayanan->catatan ?? '';
                            $uraian = '<div>' . $data->subLayanan->uraian . '<br><span style="font-weight:900"><small><i>(' . $catatan . ')</i></small></div></span></div>';
                        }

                        return $uraian;
                    })
                    ->addColumn('sub_id', function ($data) use (&$i) {
                        $id = '
                        <span hidden>' . $data->subLayanan->id . '</span>
                        <div class="text-center">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                        ';
                        return $id;
                    })
                    ->addColumn('kode', function ($data) {
                        $kode = '
                        <div class="text-center">' . $data->subLayanan->kode . '</div>';
                        return $kode;
                    })
                    ->addColumn('satuan', function ($data) {
                        $satuan = '
                        <div class="text-center">' . $data->subLayanan->satuan . '</div>';
                        return $satuan;
                    })
                    ->addColumn('total_dilayani', function ($data) {
                        $total_dilayani = '
                        <div class="text-center">' . number_format($data->total_dilayani, 0, ',', '.') . '</div>';
                        return $total_dilayani;
                    })
                    ->addColumn('januari', function ($data) {
                        $januari = '
                        <div class="text-center">' . number_format($data->terlayani_januari, 0, ',', '.') . '</div>';
                        return $januari;
                    })
                    ->addColumn('februari', function ($data) {
                        $februari = '
                        <div class="text-center">' . number_format($data->terlayani_februari, 0, ',', '.') . '</div>';
                        return $februari;
                    })
                    ->addColumn('maret', function ($data) {
                        $maret = '
                        <div class="text-center">' . number_format($data->terlayani_maret, 0, ',', '.') . '</div>';
                        return $maret;
                    })
                    ->addColumn('april', function ($data) {
                        $april = '
                        <div class="text-center">' . number_format($data->terlayani_april, 0, ',', '.') . '</div>';
                        return $april;
                    })
                    ->addColumn('mei', function ($data) {
                        $mei = '
                        <div class="text-center">' . number_format($data->terlayani_mei, 0, ',', '.') . '</div>';
                        return $mei;
                    })

                    ->addColumn('juni', function ($data) {
                        $juni = '
                        <div class="text-center">' . number_format($data->terlayani_juni, 0, ',', '.') . '</div>';
                        return $juni;
                    })
                    ->addColumn('juli', function ($data) {
                        $juli = '
                        <div class="text-center">' . number_format($data->terlayani_juli, 0, ',', '.') . '</div>';
                        return $juli;
                    })
                    ->addColumn('agustus', function ($data) {
                        $agustus = '
                        <div class="text-center">' . number_format($data->terlayani_agustus, 0, ',', '.') . '</div>';
                        return $agustus;
                    })
                    ->addColumn('september', function ($data) {
                        $september = '
                        <div class="text-center">' . number_format($data->terlayani_september, 0, ',', '.') . '</div>';
                        return $september;
                    })
                    ->addColumn('oktober', function ($data) {
                        $oktober = '
                        <div class="text-center">' . number_format($data->terlayani_oktober, 0, ',', '.') . '</div>';
                        return $oktober;
                    })
                    ->addColumn('november', function ($data) {
                        $november = '
                        <div class="text-center">' . number_format($data->terlayani_november, 0, ',', '.') . '</div>';
                        return $november;
                    })
                    ->addColumn('desember', function ($data) {
                        $desember = '
                        <div class="text-center">' . number_format($data->terlayani_desember, 0, ',', '.') . '</div>';
                        return $desember;
                    })
                    ->addColumn('total_terlayani', function ($data) {
                        $total_terlayani = '
                        <div class="text-center">' . number_format($data->total_terlayani, 0, ',', '.') . '</div>';
                        return $total_terlayani;
                    })
                    ->addColumn('belum_terlayani', function ($data) {
                        $belum_terlayani = '
                        <div class="text-center">' . number_format($data->belum_terlayani, 0, ',', '.') . '</div>';
                        return $belum_terlayani;
                    })
                    ->addColumn('total_pencapaian', function ($data) {
                        $total_pencapaian = '
                        <div class="text-center">' . round($data->pencapaian, 2) . '%</div>';
                        return $total_pencapaian;
                    })
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                ';
                        return $actionBtn;
                    })
                    ->rawColumns(['sub_layanan_id', 'sub_id', 'action', 'kode', 'satuan', 'total_dilayani', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'total_terlayani', 'belum_terlayani', 'total_pencapaian'])
                    ->with([
                        'recordsTotal' => $totalData,
                        'recordsFiltered' => $totalFiltered,
                        'start' => $start
                    ])
                    ->make();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function dataTablev1($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Spm::where('tahun_id', session('tahun_spm') ?? 1)
                    ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                    ->whereHas('subLayanan', function ($query) {
                        $query->where('versi', session('versi_spm', 1));
                    })
                    ->count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Spm::where('tahun_id', session('tahun_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan,catatan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani', 'total_dilayani']);
                } else {
                    $data = Spm::filter($request->search['value'])
                        ->latest()
                        ->where('tahun_id', session('tahun_spm', 1))
                        ->where('puskesmas_id', Auth()->user()->puskesmas_id)
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan,catatan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani', 'total_dilayani']);

                    $totalFiltered = $data->count();
                }
                return DataTables::of($data)
                    ->setOffset($start)
                    ->editColumn('sub_layanan_id', function ($data) {
                        // Mendapatkan uraian dari subLayanan
                        $uraian = '<div>' . $data->subLayanan->uraian . '</div>';
                        return $uraian;
                    })
                    ->addColumn('sub_id', function ($data) {
                        $id = '
                        <span hidden>' . $data->subLayanan->id . '</span>
                        <div class="text-center">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                        ';
                        return $id;
                    })
                    ->addColumn('kode', function ($data) {
                        $kode = '
                        <div class="text-center">' . $data->subLayanan->kode . '</div>';
                        return $kode;
                    })
                    ->addColumn('satuan', function ($data) {
                        $satuan = '
                        <div class="text-center">' . $data->subLayanan->satuan . '</div>';
                        return $satuan;
                    })
                    ->addColumn('total_dilayani', function ($data) {
                        $total_dilayani = '
                        <div class="text-center">' . number_format($data->total_dilayani, 0, ',', '.') . '</div>';
                        return $total_dilayani;
                    })
                    ->addColumn('total_terlayani', function ($data) {
                        $total_terlayani = '
                        <div class="text-center">' . number_format($data->terlayani, 0, ',', '.') . '</div>';
                        return $total_terlayani;
                    })
                    ->addColumn('belum_terlayani', function ($data) {
                        $belum_terlayani = '
                        <div class="text-center">' . number_format($data->belum_terlayani_v1, 0, ',', '.') . '</div>';
                        return $belum_terlayani;
                    })
                    ->addColumn('total_pencapaian', function ($data) {
                        $total_pencapaian = '
                        <div class="text-center">' . round($data->pencapaian_v1, 2) . '%</div>';
                        return $total_pencapaian;
                    })
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button" class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                ';
                        return $actionBtn;
                    })
                    ->rawColumns(['sub_layanan_id', 'sub_id', 'action', 'kode', 'satuan', 'total_dilayani', 'total_terlayani', 'belum_terlayani', 'total_pencapaian'])
                    ->with([
                        'recordsTotal' => $totalData,
                        'recordsFiltered' => $totalFiltered,
                        'start' => $start
                    ])
                    ->make();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function dataTable2($request)
    {
        if ($request->ajax()) {
            try {
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

                $totalData = Spm::where('tahun_id', session('tahun_spm') ?? 1)
                    ->where('puskesmas_id', 1)
                    ->whereHas('subLayanan', function ($query) {
                        $query->where('versi', session('versi_spm', 1));
                    })
                    ->count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Spm::where('tahun_id', session('tahun_spm', 1))
                        ->where('puskesmas_id', 1)
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani_januari', 'terlayani_februari', 'terlayani_maret', 'terlayani_april', 'terlayani_mei', 'terlayani_juni', 'terlayani_juli', 'terlayani_agustus', 'terlayani_september', 'terlayani_oktober', 'terlayani_november', 'terlayani_desember', 'total_dilayani']);
                } else {
                    $data = Spm::filter($request->search['value'])
                        ->latest()
                        ->where('puskesmas_id', 1)
                        ->where('tahun_id', session('tahun_spm', 1))
                        ->whereHas('subLayanan', function ($query) {
                            $query->where('versi', session('versi_spm', 1));
                        })
                        ->with('subLayanan:id,kode,uraian,satuan')
                        ->skip($start)
                        ->take($limit)
                        ->orderBy('sub_layanan_id', 'desc')
                        ->get(['id', 'sub_layanan_id', 'terlayani_januari', 'terlayani_februari', 'terlayani_maret', 'terlayani_april', 'terlayani_mei', 'terlayani_juni', 'terlayani_juli', 'terlayani_agustus', 'terlayani_september', 'terlayani_oktober', 'terlayani_november', 'terlayani_desember', 'total_dilayani']);

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->setOffset($start)
                    ->editColumn('sub_layanan_id', function ($data) {
                        return $data->subLayanan->uraian;
                    })
                    ->addColumn('sub_id', function ($data) {
                        $id = '
                        <div class="text-center">' . $data->subLayanan->id . '</div>';
                        return $id;
                    })
                    ->addColumn('kode', function ($data) {
                        $kode = '
                        <div class="text-center">' . $data->subLayanan->kode . '</div>';
                        return $kode;
                    })
                    ->addColumn('satuan', function ($data) {
                        $satuan = '
                        <div class="text-center">' . $data->subLayanan->satuan . '</div>';
                        return $satuan;
                    })
                    ->addColumn('total_dilayani', function ($data) use ($totalDilayani) {
                        $total_dilayani = '
                        <div class="text-center">' . number_format($totalDilayani[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $total_dilayani;
                    })
                    ->addColumn('januari', function ($data) use ($totalJanuari) {
                        $januari = '
                        <div class="text-center">' . number_format($totalJanuari[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $januari;
                    })
                    ->addColumn('februari', function ($data) use ($totalFebruari) {
                        $februari = '
                        <div class="text-center">' . number_format($totalFebruari[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $februari;
                    })
                    ->addColumn('maret', function ($data) use ($totalMaret) {
                        $maret = '
                        <div class="text-center">' . number_format($totalMaret[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $maret;
                    })
                    ->addColumn('april', function ($data) use ($totalApril) {
                        $april = '
                        <div class="text-center">' . number_format($totalApril[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $april;
                    })
                    ->addColumn('mei', function ($data) use ($totalMei) {
                        $mei = '
                        <div class="text-center">' . number_format($totalMei[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $mei;
                    })
                    ->addColumn('juni', function ($data) use ($totalJuni) {
                        $juni = '
                        <div class="text-center">' . number_format($totalJuni[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $juni;
                    })
                    ->addColumn('juli', function ($data) use ($totalJuli) {
                        $juli = '
                        <div class="text-center">' . number_format($totalJuli[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $juli;
                    })
                    ->addColumn('agustus', function ($data) use ($totalAgustus) {
                        $agustus = '
                        <div class="text-center">' . number_format($totalAgustus[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $agustus;
                    })
                    ->addColumn('september', function ($data) use ($totalSeptember) {
                        $september = '
                        <div class="text-center">' . number_format($totalSeptember[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $september;
                    })
                    ->addColumn('oktober', function ($data) use ($totalOktober) {
                        $oktober = '
                        <div class="text-center">' . number_format($totalOktober[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $oktober;
                    })
                    ->addColumn('november', function ($data) use ($totalNovember) {
                        $november = '
                        <div class="text-center">' . number_format($totalNovember[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $november;
                    })
                    ->addColumn('desember', function ($data) use ($totalDesember) {
                        $desember = '
                        <div class="text-center">' . number_format($totalDesember[$data->sub_layanan_id], 0, ',', '.') . '</div>';
                        return $desember;
                    })
                    ->addColumn('total_terlayani', function ($data) use ($totalJanuari, $totalFebruari, $totalMaret, $totalApril, $totalMei, $totalJuni, $totalJuli, $totalAgustus, $totalSeptember, $totalOktober, $totalNovember, $totalDesember) {
                        $totalT = ($totalJanuari[$data->sub_layanan_id] ?? 0) + ($totalFebruari[$data->sub_layanan_id] ?? 0) + ($totalMaret[$data->sub_layanan_id] ?? 0) + ($totalApril[$data->sub_layanan_id] ?? 0) + ($totalMei[$data->sub_layanan_id] ?? 0) + ($totalJuni[$data->sub_layanan_id] ?? 0) + ($totalJuli[$data->sub_layanan_id] ?? 0) + ($totalAgustus[$data->sub_layanan_id] ?? 0) + ($totalSeptember[$data->sub_layanan_id] ?? 0) + ($totalOktober[$data->sub_layanan_id] ?? 0) + ($totalNovember[$data->sub_layanan_id] ?? 0) + ($totalDesember[$data->sub_layanan_id] ?? 0);
                        $total_terlayani = '
                        <div class="text-center">' . number_format($totalT, 0, ',', '.') . '</div>';
                        return $total_terlayani;
                    })
                    ->addColumn('belum_terlayani', function ($data) use ($totalDilayani, $totalJanuari, $totalFebruari, $totalMaret, $totalApril, $totalMei, $totalJuni, $totalJuli, $totalAgustus, $totalSeptember, $totalOktober, $totalNovember, $totalDesember) {
                        $totalD = $totalDilayani[$data->sub_layanan_id] ?? 0;
                        $totalT = ($totalJanuari[$data->sub_layanan_id] ?? 0) + ($totalFebruari[$data->sub_layanan_id] ?? 0) + ($totalMaret[$data->sub_layanan_id] ?? 0) + ($totalApril[$data->sub_layanan_id] ?? 0) + ($totalMei[$data->sub_layanan_id] ?? 0) + ($totalJuni[$data->sub_layanan_id] ?? 0) + ($totalJuli[$data->sub_layanan_id] ?? 0) + ($totalAgustus[$data->sub_layanan_id] ?? 0) + ($totalSeptember[$data->sub_layanan_id] ?? 0) + ($totalOktober[$data->sub_layanan_id] ?? 0) + ($totalNovember[$data->sub_layanan_id] ?? 0) + ($totalDesember[$data->sub_layanan_id] ?? 0);
                        return '<div class="text-center">' . number_format($totalD - $totalT, 0, ',', '.') . '</div >';
                    })
                    ->addColumn('total_pencapaian', function ($data) use ($totalDilayani, $totalJanuari, $totalFebruari, $totalMaret, $totalApril, $totalMei, $totalJuni, $totalJuli, $totalAgustus, $totalSeptember, $totalOktober, $totalNovember, $totalDesember) {
                        $totalD = $totalDilayani[$data->sub_layanan_id] ?? 0;
                        $totalT = ($totalJanuari[$data->sub_layanan_id] ?? 0) + ($totalFebruari[$data->sub_layanan_id] ?? 0) + ($totalMaret[$data->sub_layanan_id] ?? 0) + ($totalApril[$data->sub_layanan_id] ?? 0) + ($totalMei[$data->sub_layanan_id] ?? 0) + ($totalJuni[$data->sub_layanan_id] ?? 0) + ($totalJuli[$data->sub_layanan_id] ?? 0) + ($totalAgustus[$data->sub_layanan_id] ?? 0) + ($totalSeptember[$data->sub_layanan_id] ?? 0) + ($totalOktober[$data->sub_layanan_id] ?? 0) + ($totalNovember[$data->sub_layanan_id] ?? 0) + ($totalDesember[$data->sub_layanan_id] ?? 0);
                        $pencapaian = $totalD > 0 ? round(($totalT / $totalD) * 100, 2) : 0;
                        return '<div class="text-center">' . $pencapaian . '%</div>';
                    })
                    ->rawColumns(['sub_layanan_id', 'sub_id', 'kode', 'satuan', 'total_dilayani', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'total_terlayani', 'belum_terlayani', 'total_pencapaian'])
                    ->with([
                        'recordsTotal' => $totalData,
                        'recordsFiltered' => $totalFiltered,
                        'start' => $start
                    ])
                    ->make();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }


    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return Spm::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $spm = Spm::create($data);

        return $spm;
    }

    public function update(array $data, string $id)
    {
        $spm = Spm::where('id', $id)->firstOrFail();
        $spm->update($data);

        return $spm;
    }

    public function forceDelete(string $id)
    {
        $getSPM = $this->getFirstBy('id', $id);
        // Storage::disk('public')->delete('images/' . $getSPM->image);
        $getSPM->forceDelete();

        return $getSPM;
    }

    public function columnLabels()
    {
        return [
            'sub_layanan_id' => 'Uraian',
        ];
    }

    public function columnExclude()
    {
        return ['id', 'tahun_id', 'dilayani', 'terlayani', 'pencapaian', 'bulan', 'updated_by', 'created_at', 'updated_at'];
    }

    public function columnTypes()
    {
        return [
            'sub_layanan_id' => 'sub_layanans',
        ];
    }

    public function columns()
    {
        return array_diff(Schema::getColumnListing((new Spm())->getTable()), $this->columnExclude());
    }


    public function getAttributesWithDetails()
    {
        // Get the columns from the table, excluding specific columns
        $columns = Schema::getColumnListing($this->tableName);
        $excludedColumns = $this->columnExclude();
        $filteredColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // Define your labels and data types
        $labels = $this->columnLabels();

        $dataTypes = $this->columnTypes();

        // Create an array with keys, their corresponding labels, data types, and required status
        $attributesWithDetails = [];
        foreach ($filteredColumns as $column) {
            if (array_key_exists($column, $labels) && array_key_exists($column, $dataTypes)) {
                // Check if the column is nullable
                if (app()->make('db')->connection()->getDriverName() === 'sqlite') {
                    // Get column info for SQLite
                    $columnsInfo = app()->make('db')->select("PRAGMA table_info($this->tableName)");
                    $columnInfo = collect($columnsInfo)->firstWhere('name', $column);
                    $isNullable = $columnInfo->notnull == 0; // notnull is 0 if the column is nullable
                } else {
                    // Use information_schema for other databases
                    $result = app()->make('db')->select("SELECT is_nullable FROM information_schema.columns WHERE table_name = ? AND column_name = ?", [$this->tableName, $column]);

                    if (empty($result)) {
                        throw new Exception("No results found for the specified table and column.");
                    }

                    $isNullable = $result[0]->IS_NULLABLE === 'YES';
                }

                $attributesWithDetails[$column] = [
                    'label' => $labels[$column],
                    'type' => $dataTypes[$column],
                    'required' => !$isNullable, // Required if not nullable
                ];
            }
        }

        return $attributesWithDetails;
    }
}
