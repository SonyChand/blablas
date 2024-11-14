<?php

namespace App\Http\Controllers\Managements\Letters;

use PDF;
use Exception;
use ZipArchive;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\View\View;
use App\Traits\TwilioTrait;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Managements\Letters\Disposition;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Models\Managements\Letters\IncomingLetter;
use Illuminate\Support\Facades\Storage;
use App\Mail\IncomingLetterNotification;
use Illuminate\Foundation\Validation\ValidatesRequests;

class IncomingLetterController extends Controller
{
    use ValidatesRequests, TwilioTrait, LogsActivity;

    function __construct()
    {
        $this->middleware('permission:incoming_letter-list|incoming_letter-create|incoming_letter-edit|incoming_letter-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:incoming_letter-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:incoming_letter-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:incoming_letter-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:incoming_letter-download', ['only' => ['download', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = 'Surat Masuk';
        $letters = IncomingLetter::orderBy('id', 'DESC')->get();

        return view('dashboard.letters.incoming_letters.index', compact('letters', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = 'Tambah Surat Masuk';

        return view('dashboard.letters.incoming_letters.create', compact('title'));
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
            'source_letter' => 'required|array',
            'addressed_to' => 'required|array',
            'letter_number' => 'required|string',
            'letter_date' => 'required|date',
            'subject' => 'required|string',
            'attachment' => 'nullable|string',
            'forwarded_disposition' => 'nullable|array',
            'operator_name' => 'required|string',
            'file_path.*' => 'nullable|mimes:pdf',
        ]);
        $validatedData['uuid'] = (string) Str::uuid()->toString();

        $filePaths = [];
        if ($request->hasFile('file_path')) {
            $directory = 'surat/surat_masuk/' . md5(Str::slug($request->name) . '_' . time());
            $storageDirectory = storage_path('app/public/' . $directory);

            if (!file_exists($storageDirectory)) {
                mkdir($storageDirectory, 0755, true);
            }

            foreach ($request->file('file_path') as $file) {
                $filePath = $directory . '/' . $file->hashName();
                $file->move($storageDirectory, $file->hashName());

                $filePaths[] = $filePath;
            }
        }

        $validatedData['file_path'] = $filePaths;
        $letter = IncomingLetter::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan surat masuk dan disposisi dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('incoming_letters', $request->user(), $letter->id, $description);

        // Tambahkan Disposition
        $dispositionData = [
            'uuid' => (string) Str::uuid(),
            'letter_id' => $letter->id,
            'letter_number' => $letter->letter_number,
            'from' => $request->user()->name,
            'type' => 'incoming',
            'disposition_date' => Carbon::now()->toDateString(),
            'signed_by' => $request->user()->name,
        ];
        Disposition::create($dispositionData);


        // Generate PDF
        $data = [
            'title' => 'Surat Masuk',
            'letter' => $letter
        ];

        Mail::to('sonychandmaulana@gmail.com')->send(new IncomingLetterNotification($request->user(), 'penambahan', $letter->id, null));

        return redirect()->route('incoming-letters.index')
            ->with('success', 'Surat Masuk dan PDF berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = IncomingLetter::find($id);

        return view('dashboard.letters.incoming_letters.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomingLetter $incoming_letter): View
    {
        $title = 'Edit Surat Masuk';

        return view('dashboard.letters.incoming_letters.edit', compact('title', 'incoming_letter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IncomingLetter $incoming_letter): RedirectResponse
    {
        $validatedData = $request->validate([
            'source_letter' => 'required|array',
            'addressed_to' => 'required|array',
            'letter_number' => 'required|string',
            'letter_date' => 'required|date_format:Y-m-d',
            'subject' => 'required|string',
            'attachment' => 'nullable|string',
            'forwarded_disposition' => 'nullable|array',
            'operator_name' => 'required|string',
            'file_path.*' => 'nullable|mimes:pdf',
        ]);

        $filePaths = [];
        $deletePreviousFiles = $request->input('delete_previous_files', false);

        if ($deletePreviousFiles) {
            // Assuming $incoming_letter->file_path contains the paths of previous files
            foreach ($incoming_letter->file_path as $previousFilePath) {
                $fullPath = storage_path('app/public/' . $previousFilePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            // Delete previous file paths from the database
            $incoming_letter->file_path = [];
            $incoming_letter->save();
        } else {
            // If not deleting previous files, retain the existing file paths
            $filePaths = is_array($incoming_letter->file_path) ? $incoming_letter->file_path : [];
        }

        if ($request->hasFile('file_path')) {
            $directory = 'surat/surat_masuk/' . md5(Str::slug($request->name) . '_' . time());
            $storageDirectory = storage_path('app/public/' . $directory);

            if (!file_exists($storageDirectory)) {
                mkdir($storageDirectory, 0755, true);
            }

            foreach ($request->file('file_path') as $file) {
                $filePath = $directory . '/' . $file->hashName();
                $file->move($storageDirectory, $file->hashName());

                $filePaths[] = $filePath;
            }
        }

        // Save new file paths to the database
        $incoming_letter->file_path = $filePaths;


        $validatedData['file_path'] = $filePaths;

        $letter = IncomingLetter::findOrFail($incoming_letter->id);

        // Track changes
        $changes = [];
        // Decode JSON fields for comparison
        $originalData = $letter->toArray();
        $incoming_letter->save();


        // Convert dates to Carbon instances for comparison
        $originalData['letter_date'] = Carbon::parse($originalData['letter_date'])->setTimezone('Asia/Jakarta')->startOfDay();
        $validatedData['letter_date'] = Carbon::parse($validatedData['letter_date'])->startOfDay();


        foreach ($validatedData as $key => $value) {
            if ($originalData[$key] != $value) {
                $changes[] = $key;
            }
        }


        if (empty($changes)) {
            return redirect()->route('incoming-letters.edit', $incoming_letter->id)
                ->with('info', 'Tidak ada perubahan yang dilakukan.');
        }

        // Update the letter
        $letter->update($validatedData);


        // Create activity description
        $description = 'Pengguna ' . $request->user()->name . ' mengubah kolom: ' . implode(', ', $changes) . ' pada surat masuk dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('incoming_letters', $request->user(), $letter->id, $description);
        // Regenerate PDF
        $data = [
            'title' => 'Letter Details',
            'letter' => $letter
        ];

        Mail::to('sonychandmaulana@gmail.com')->send(new IncomingLetterNotification($request->user(), 'perubahan', $letter->id, $originalData));

        return redirect()->route('incoming-letters.index')
            ->with('success', 'Surat Masuk dan PDF berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $letter = IncomingLetter::find($id);
        if ($letter) {
            $filePath =  $letter->file_path;
            foreach ($filePath as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
            $description = 'Pengguna ' . Auth::user()->name  . ' menghapus surat masuk dengan nomor surat: ' . $letter->letter_number;
            $this->logActivity('incoming_letters', Auth::user(), $letter->id, $description);
            $letter->delete();
            return redirect()->route('incoming-letters.index')
                ->with('success', 'Surat masuk berhasil dihapus');
        } else {
            return redirect()->route('incoming-letters.index')
                ->with('error', 'Surat masuk tidak ditemukan.');
        }
    }
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $letterIds = explode(',', $request->input('letterIds', ''));
        if (!empty($letterIds)) {
            foreach ($letterIds as $letterId) {
                $data = IncomingLetter::find($letterId);
                if ($data) {
                    $filePath = $data->file_path;
                    foreach ($filePath as $file) {
                        if ($file && Storage::disk('public')->exists($file)) {
                            Storage::disk('public')->delete($file);
                        }
                    }
                    $description = 'Pengguna ' . Auth::user()->name  . ' menghapus surat masuk dengan nomor surat: ' . $data->letter_number;
                    $this->logActivity('incoming_letters', Auth::user(), $data->id, $description);
                }
            }

            $letterNumbers = IncomingLetter::whereIn('id', $letterIds)->pluck('letter_number')->toArray();
            $message = 'Pengguna ' . Auth::user()->name . ' telah menghapus data-data surat dengan nomor surat: ' . implode(', ', $letterNumbers);

            $sendMessageResult = $this->sendWhatsAppMessageToAdmin($message, null);

            if ($sendMessageResult !== true) {
                return back()->with(['error' => $sendMessageResult]);
            }

            IncomingLetter::whereIn('id', $letterIds)->delete();

            return redirect()->route('incoming-letters.index')->with('success', 'Surat-surat masuk berhasil dihapus');
        }
        return redirect()->route('incoming-letters.index')->with('error', 'Surat masuk tidak ditemukan.');
    }

    public function download(Request $request, $id)
    {
        $letter = IncomingLetter::find($request->id);
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh seluruh file surat masuk dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('incoming_letters', Auth::user(), $letter->id, $description);

        $zip = new ZipArchive;
        $zipFileName = 'surat_masuk_' . $letter->letter_number . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($letter->file_path as $filePath) {
                $fullPath = storage_path('app/public/' . $filePath);
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, basename($filePath));
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    private function compressPdf($inputPath, $outputPath)
    {
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($inputPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            // Reduce the quality of images in the PDF
            $pdf->SetCompression(true);
        }

        $pdf->Output($outputPath, 'F');
    }
}
