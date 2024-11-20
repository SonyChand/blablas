<?php

namespace App\Http\Controllers\Managements\Letters;

use App\Http\Controllers\Controller;
use App\Models\Managements\Letters\Recommendation;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use ZipArchive;

class RecommendationController extends Controller
{
    use LogsActivity;
    public function __construct()
    {
        $this->middleware('permission:recommendation-list|recommendation-create|recommendation-edit|recommendation-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:recommendation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:recommendation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:recommendation-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:recommendation-download', ['only' => ['download', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $title = 'Rekomendasi';
        $recommendations = Recommendation::orderBy('id', 'DESC')->get();

        return view('dashboard.letters.recommendations.index', compact('recommendations', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = 'Tambah Rekomendasi';

        return view('dashboard.letters.recommendations.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'recommendation_type' => 'required|string',
            'recommendation_number' => 'required|string',
            'basis_of_recommendation' => 'required|string',
            'recommendation_consideration' => 'required|string',
            'recommended_data' => 'required|string',
            'recommendation_purpose' => 'required|string',
            'recommendation_closing' => 'required|string',
            'recommendation_date' => 'required|date',
            'signed_by' => 'required|string',
            'operator_name' => 'required|string',
        ]);

        $validatedData['uuid'] = (string) Str::uuid()->toString();

        $recommendation = Recommendation::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan rekomendasi dengan nomor: ' . $recommendation->recommendation_number;
        $this->logActivity('recommendations', $request->user(), $recommendation->id, $description);

        return redirect()->route('recommendation-letters.index')
            ->with('success', 'Rekomendasi berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recommendation $recommendation): View
    {
        $title = 'Edit Rekomendasi';

        return view('dashboard.letters.recommendations.edit', compact('title', 'recommendation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recommendation $recommendation): RedirectResponse
    {
        $validatedData = $request->validate([
            'recommendation_type' => 'required|string',
            'recommendation_number' => 'required|string',
            'basis_of_recommendation' => 'required|string',
            'recommendation_consideration' => 'required|string',
            'recommended_data' => 'required|string',
            'recommendation_purpose' => 'required|string',
            'recommendation_closing' => 'required|string',
            'recommendation_date' => 'required|date',
            'signed_by' => 'required|string',
            'operator_name' => 'required|string',
        ]);

        $recommendation->update($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' mengubah rekomendasi dengan nomor: ' . $recommendation->recommendation_number;
        $this->logActivity('recommendations', $request->user(), $recommendation->id, $description);

        return redirect()->route('recommendation-letters.index')
            ->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recommendation $recommendation): RedirectResponse
    {
        $description = 'Pengguna ' . Auth::user()->name . ' menghapus rekomendasi dengan nomor: ' . $recommendation->recommendation_number;
        $this->logActivity('recommendations', Auth::user(), $recommendation->id, $description);

        $recommendation->delete();

        return redirect()->route('recommendation-letters.index')
            ->with('success', 'Rekomendasi berhasil dihapus.');
    }

    /**
     * Bulk destroy the specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $recommendationIds = explode(',', $request->input('recommendationIds', ''));
        if (!empty($recommendationIds)) {
            foreach ($recommendationIds as $recommendationId) {
                $recommendation = Recommendation::find($recommendationId);
                if ($recommendation) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus rekomendasi dengan nomor: ' . $recommendation->recommendation_number;
                    $this->logActivity('recommendations', Auth::user(), $recommendation->id, $description);
                    $recommendation->delete();
                }
            }

            return redirect()->route('recommendation-letters.index')->with('success', 'Rekomendasi berhasil dihapus');
        }
        return redirect()->route('recommendation-letters.index')->with('error', 'Rekomendasi tidak ditemukan.');
    }

    /**
     * Download the specified resources as a zip file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        $recommendation = Recommendation::find($id);
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh rekomendasi dengan nomor: ' . $recommendation->recommendation_number;
        $this->logActivity('recommendations', Auth::user(), $recommendation->id, $description);

        $zip = new ZipArchive;
        $zipFileName = 'rekomendasi_' . $recommendation->recommendation_number . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $filePath = $recommendation->file_path;
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                $zip->addFile(storage_path('app/public/' . $filePath), basename($filePath));
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
