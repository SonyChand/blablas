<?php

namespace App\Http\Controllers\Managements\Letters;

use App\Models\Managements\Letters\Disposition;
use App\Models\Managements\Letters\IncomingLetter;
use App\Traits\LogsActivity;
use App\Traits\TwilioTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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

    public function edit(Disposition $disposition)
    {
        $letters = IncomingLetter::all();
        $title = 'Edit Disposisi';
        return view('dashboard.letters.dispositions.edit', compact('disposition', 'letters', 'title'));
    }

    public function update(Request $request, Disposition $disposition)
    {
        $validatedData = $request->validate([
            'letter_number' => 'nullable|string',
            'from' => 'nullable|string',
            'disposition_to' => 'nullable|array',
            'notes' => 'nullable|string',
            'disposition_date' => 'nullable|date',
            'signed_by' => 'nullable|string',
        ]);

        $disposition->update($validatedData);

        $description = 'Pengguna ' . Auth::user()->name . ' mengubah disposisi dengan nomor surat: ' . $disposition->letter_number;
        $this->logActivity('dispositions', Auth::user(), $disposition->id, $description);

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
}
