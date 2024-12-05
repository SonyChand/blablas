<?php

namespace App\Http\Controllers\Managements\Letters;

use App\Traits\TwilioTrait;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Managements\Letters\Disposition;
use App\Models\Managements\Letters\IncomingLetter;
use PDF;

class DispositionController extends Controller
{
    use LogsActivity, TwilioTrait;

    public function index()
    {
        $dispositions = Disposition::all();
        return view('dashboard.letters.dispositions.index', compact('dispositions'));
    }

    public function create()
    {
        $letters = IncomingLetter::all();
        return view('dashboard.letters.dispositions.create', compact('letters'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'letter_id' => 'required|exists:incoming_letters,id',
            'letter_number' => 'required|string',
            'from' => 'required|string',
            'type' => 'required|string',
            'disposition_to' => 'required|string',
            'notes' => 'nullable|string',
            'disposition_date' => 'required|date',
            'signed_by' => 'nullable|string',
        ]);

        $validatedData['uuid'] = (string) Str::uuid();

        $disposition = Disposition::create($validatedData);

        $description = 'Pengguna ' . Auth::user()->name . ' menambahkan disposisi dengan nomor surat: ' . $disposition->letter_number;
        $this->logActivity('dispositions', Auth::user(), $disposition->id, $description);


        return redirect()->route('incoming-letters.index')->with('success', 'Disposisi berhasil ditambahkan.');
    }

    public function show(Disposition $disposition)
    {
        return view('dashboard.letters.dispositions.show', compact('disposition'));
    }

    public function edit($id)
    {
        $letters = IncomingLetter::find($id);
        $title = 'Edit Disposisi';
        $disposition = Disposition::where('letter_id', $id)->first();
        $employees = Employee::all();
        return view('dashboard.letters.dispositions.edit', compact('disposition', 'letters', 'title', 'employees'));
    }

    public function update(Request $request, Disposition $disposition)
    {
        $validatedData = $request->validate([
            'letter_nature' => 'nullable|string',
            'agenda_number' => 'nullable|string',
            'disposition_to' => 'nullable|array',
            'notes' => 'nullable|string',
            'disposition_date' => 'nullable|date',
            'signed_by' => 'required|string',
        ]);

        $disposition->update($validatedData);

        $description = 'Pengguna ' . Auth::user()->name . ' mengubah disposisi dengan nomor surat: ' . $disposition->letter_number;
        $this->logActivity('dispositions', Auth::user(), $disposition->id, $description);

        $data = [
            'title' => 'Letter Details',
            'disposition' => $disposition,
        ];

        $pdf = PDF::loadView('dashboard.letters.dispositions.pdf', $data)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        // Save PDF to storage
        $dispositionTypeSlug = str_replace(' ', '_', strtolower($disposition->letter_type));
        $pdfPath = 'surat/surat_masuk/disposisi/' . $dispositionTypeSlug . '/' . $disposition->letter_number . '-' . $disposition->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        return redirect()->route('incoming-letters.index')->with('success', 'Disposisi dengan nomor surat: ' . $disposition->letter_number . ' berhasil diperbarui.');
    }

    public function destroy(Disposition $disposition)
    {
        $description = 'Pengguna ' . Auth::user()->name . ' menghapus disposisi dengan nomor surat: ' . $disposition->letter_number;
        $this->logActivity('dispositions', Auth::user(), $disposition->id, $description);

        $message = 'Disposisi telah dihapus dengan nomor surat: ' . $disposition->letter_number;
        $this->sendWhatsAppMessageToAdmin($message, null);

        $disposition->delete();

        return redirect()->route('incoming-letters.index')->with('success', 'Disposisi berhasil dihapus.');
    }

    public function download($id)
    {
        $letter = IncomingLetter::find($id);
        $disposition = Disposition::where('letter_id', $id)->first();
        $letterTypeSlug = str_replace(' ', '_', strtolower($disposition->letter_type));
        $pdfPath = 'surat/surat_masuk/disposisi/' . $letterTypeSlug . '/' . $letter->letter_number . '-' . $disposition->id . '.pdf';
        $description = 'Pengguna ' . Auth::user()->name  . ' mengunduh disposisi dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('dispositions', Auth::user(), $letter->id, $description);
        return Storage::disk('public')->download($pdfPath);
    }
}
