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
        $this->middleware('permission:spm-list|spm-edit', ['only' => ['index', 'full']]);
        $this->middleware('permission:spm-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:spm-dinkes', ['only' => ['rekap', 'rekapFull']]);
        $this->spmService = $spmService;
    }
    public function index()
    {
        $tahuns = Tahun::all();
        $tahunSpm = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Data SPM';

        if (session('versi_spm', 1) == 1) {
            return view('backend.spm.spm.indexv1', compact('title', 'tahuns', 'tahunSpm'));
        } else {
            return view('backend.spm.spm.indexv2', compact('title', 'tahuns', 'tahunSpm'));
        }
    }
    public function full()
    {
        $layanan1 = SubLayanan::where('layanan_id', 1)->where('versi', session('versi_spm', 1))->get();
        $layanan2 = SubLayanan::where('layanan_id', 2)->where('versi', session('versi_spm', 1))->get();
        $layanan3 = SubLayanan::where('layanan_id', 3)->where('versi', session('versi_spm', 1))->get();

        $tahuns = Tahun::all();
        $tahun = Tahun::where('id', session('tahun_spm', 1))->first();
        $title = 'Data SPM';

        return view('backend.spm.spm.tes', compact('title', 'tahun', 'tahuns', 'layanan1', 'layanan2', 'layanan3'));
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

        return view('backend.spm.spm.rekap.index', compact('title', 'tahuns', 'tahunSpm'));
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

            if (session('versi_spm', 1) == 2) {
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
            } else {
                $validatedData = validator($inputData, [
                    'terlayani' => 'integer|nullable',
                    'total_dilayani' => 'integer|nullable',
                ])->validate();
            }

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

    public function destroy($id)
    {
        $spm = Spm::findOrFail($id);
        $spm->delete();

        return redirect()->route('spm.index')->with('success', 'SPM berhasil dihapus.');
    }

    public function serversidev1(Request $request): JsonResponse
    {
        return $this->spmService->dataTablev1($request);
    }

    public function serversidev2(Request $request): JsonResponse
    {
        return $this->spmService->dataTablev2($request);
    }

    public function rekapServerside(Request $request): JsonResponse
    {
        return $this->spmService->dataTable2($request);
    }

    public function tahunSpm(Request $request)
    {
        $validatedData = $request->validate([
            'versi' => 'required|min:1|max:2',
            'tahun' => 'required|min:1|max:2'
        ]);
        // put to session
        session([
            'versi_spm' => $validatedData['versi'],
            'tahun_spm' => $validatedData['tahun'],
        ]);
        return redirect()->back()->with('success', 'Tahun dan versi SPM berhasil diubah.');
    }
}
