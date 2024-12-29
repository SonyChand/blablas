<?php

namespace App\Http\Controllers\Backend\SPM;

use Illuminate\Http\Request;
use App\Models\Backend\SPM\Spm;
use App\Models\Backend\SPM\Tahun;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\SPM\Puskesmas;
use App\Models\Backend\SPM\SubLayanan;
use App\Http\Services\Backend\SPM\SpmService;
use App\Traits\LogsActivity;

class SpmController extends Controller
{
    use LogsActivity;
    public function __construct(private SpmService $spmService)
    {
        $this->middleware('permission:spm-list|spm-create|spm-edit|spm-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:spm-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:spm-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:spm-delete', ['only' => ['destroy']]);
        $this->middleware('permission:spm-download', ['only' => ['export']]);
        $this->spmService = $spmService;
    }
    public function index()
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Data SPM';
        // $spms = Spm::paginate(200);
        $columns = $this->spmService->columns();

        $columnLabels = $this->spmService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->spmService->columnExclude();

        $columnDetail = $this->spmService->getAttributesWithDetails();

        return view('backend.spm.spm.index', compact('title', 'columns', 'columnLabels', 'excludedColumns', 'columnDetail', 'tahuns', 'tahunSpm'));
    }


    public function create()
    {
        $puskesmas = Puskesmas::all();
        $subLayanans = SubLayanan::all();
        $tahuns = Tahun::all();
        $title = 'Tambah SPM';
        return view('backend.spm.spm.create', compact('title', 'puskesmas', 'subLayanans', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'sub_layanan_id' => 'required|exists:sub_layanans,id',
            'tahun_id' => 'required|exists:tahuns,id',
            'dilayani' => 'required|integer',
            'terlayani' => 'required|integer',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        Spm::create($validatedData);

        return redirect()->route('spm.index')->with('success', 'SPM berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit SPM';
        $spm = Spm::findOrFail($id);

        return view('backend.spm.spm.edit', compact('spm', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'sub_layanan_id' => 'required|exists:sub_layanans,id',
            'tahun_id' => 'required|exists:tahuns,id',
            'dilayani' => 'required|integer',
            'terlayani' => 'required|integer',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        $spm = Spm::findOrFail($id);
        $spm->update($validatedData);

        return redirect()->route('spm.index')->with('success', 'SPM berhasil diubah.');
    }

    public function liveUpdate(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
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
            ]);

            // dd($validatedData);


            // Find the user by ID
            $spm = Spm::findOrFail($request->id);
            $spmOriginal = Spm::findOrFail($request->id);
            $spm->update($validatedData);




            $description = "Nilai SPM " . $spmOriginal->subLayanan->kode . " telah diubah oleh " . Auth::user()->name;
            $this->logActivity('spms', Auth::user(), null, $description);

            // Return a success response
            return response()->json(['message' => 'Nilai SPM Berhasil Diubah...']);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json($error->getMessage(), 500); // Return a 500 status code for server errors
        }
    }

    public function destroy($id)
    {
        $spm = Spm::findOrFail($id);
        $spm->delete();

        return redirect()->route('spm.index')->with('success', 'SPM berhasil dihapus.');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->spmService->dataTable($request);
    }

    public function tahunSpm(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|min:1|max:2'
        ]);
        // put to session
        session([
            'tahun_spm' => $validatedData['tahun'],
        ]);
        return redirect()->route('spm.index')->with('success', 'Tahun SPM berhasil diubah.');
    }
}
