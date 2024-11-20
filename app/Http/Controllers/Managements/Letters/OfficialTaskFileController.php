<?php

namespace App\Http\Controllers\Managements\Letters;

use ZipArchive;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Managements\Letters\OfficialTaskFile;
use App\Traits\LogsActivity;

class OfficialTaskFileController extends Controller
{
    use LogsActivity;
    public function __construct()
    {
        $this->middleware('permission:official_task_file-list|official_task_file-create|official_task_file-edit|official_task_file-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:official_task_file-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:official_task_file-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:official_task_file-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:official_task_file-download', ['only' => ['download', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $title = 'Official Task Files';
        $officialTaskFiles = OfficialTaskFile::orderBy('id', 'DESC')->get();

        return view('dashboard.letters.official_task_files.index', compact('officialTaskFiles', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = 'Tambah Official Task File';
        $employees = Employee::all();

        return view('dashboard.letters.official_task_files.create', compact('title', 'employees'));
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
            'letter_type' => 'required|string',
            'letter_number' => 'required|string',
            'letter_reference' => 'required|string',
            'letter_date' => 'required|date',
            'assign' => 'required|string',
            'to_implement' => 'required|string',
            'letter_closing' => 'required|string',
            'letter_creation_date' => 'required|date',
            'signed_by' => 'required|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'required|string',
        ]);

        $validatedData['uuid'] = (string) Str::uuid()->toString();

        $officialTaskFile = OfficialTaskFile::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan official task file dengan nomor: ' . $officialTaskFile->letter_number;
        $this->logActivity('official_task_files', $request->user(), $officialTaskFile->id, $description);

        return redirect()->route('official-task-files.index')
            ->with('success', 'Official Task File berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficialTaskFile $officialTaskFile): View
    {
        $title = 'Edit Official Task File';
        $employees = Employee::all();

        return view('dashboard.letters.official_task_files.edit', compact('title', 'officialTaskFile', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficialTaskFile $officialTaskFile): RedirectResponse
    {
        $validatedData = $request->validate([
            'letter_type' => 'required|string',
            'letter_number' => 'required|string',
            'letter_reference' => 'required|string',
            'letter_date' => 'required|date',
            'assign' => 'required|string',
            'to_implement' => 'required|string',
            'letter_closing' => 'required|string',
            'letter_creation_date' => 'required|date',
            'signed_by' => 'required|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'required|string',
        ]);

        $officialTaskFile->update($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' mengubah official task file dengan nomor: ' . $officialTaskFile->letter_number;
        $this->logActivity('official_task_files', $request->user(), $officialTaskFile->id, $description);

        return redirect()->route('official-task-files.index')
            ->with('success', 'Official Task File berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficialTaskFile $officialTaskFile): RedirectResponse
    {
        $description = 'Pengguna ' . Auth::user()->name . ' menghapus official task file dengan nomor: ' . $officialTaskFile->letter_number;
        $this->logActivity('official_task_files', Auth::user(), $officialTaskFile->id, $description);

        $officialTaskFile->delete();

        return redirect()->route('official-task-files.index')
            ->with('success', 'Official Task File berhasil dihapus.');
    }

    /**
     * Bulk destroy the specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $officialTaskFileIds = explode(',', $request->input('officialTaskFileIds', ''));
        if (!empty($officialTaskFileIds)) {
            foreach ($officialTaskFileIds as $officialTaskFileId) {
                $officialTaskFile = OfficialTaskFile::find($officialTaskFileId);
                if ($officialTaskFile) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus official task file dengan nomor: ' . $officialTaskFile->letter_number;
                    $this->logActivity('official_task_files', Auth::user(), $officialTaskFile->id, $description);
                    $officialTaskFile->delete();
                }
            }

            return redirect()->route('official-task-files.index')->with('success', 'Official Task Files berhasil dihapus');
        }
        return redirect()->route('official-task-files.index')->with('error', 'Official Task File tidak ditemukan.');
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
        $officialTaskFile = OfficialTaskFile::find($id);
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh official task file dengan nomor: ' . $officialTaskFile->letter_number;
        $this->logActivity('official_task_files', Auth::user(), $officialTaskFile->id, $description);

        $zip = new ZipArchive;
        $zipFileName = 'official_task_file_' . $officialTaskFile->letter_number . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $filePath = $officialTaskFile->file_path;
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
