<?php

namespace App\Http\Controllers\Letters;

use PDF;
use Illuminate\View\View;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Models\Letters\OutgoingLetter;
use Illuminate\Support\Facades\Storage;
use App\Mail\OutgoingLetterNotification;
use Illuminate\Foundation\Validation\ValidatesRequests;

class OutgoingLetterController extends Controller
{
    use ValidatesRequests;
    use LogsActivity;

    function __construct()
    {
        $this->middleware('permission:outgoing_letter-list|outgoing_letter-create|outgoing_letter-edit|outgoing_letter-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:outgoing_letter-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:outgoing_letter-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:outgoing_letter-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:outgoing_letter-download', ['only' => ['download', 'index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $title = 'Surat Keluar';
        $letters = OutgoingLetter::orderBy('letter_date', 'DESC')->get();

        return view('dashboard.letters.outgoing_letters.index', compact('letters', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $title = 'Tambah Surat Keluar';

        return view('dashboard.letters.outgoing_letters.create', compact('title'));
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
            'letter_nature' => 'required|string',
            'letter_subject' => 'required|string',
            'letter_date' => 'required|date',
            'letter_destination_json' => 'required|json',
            'to' => 'required|string',
            'letter_body' => 'required|string',
            'letter_closing' => 'required|string',
            'sign_name' => 'required|string',
            'sign_nip' => 'required|string',
            'sign_position' => 'required|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'required|string',
        ]);

        // Convert JSON fields back to JSON strings
        $validatedData['letter_destination'] = $validatedData['letter_destination_json'];

        // Remove the temporary JSON fields
        unset($validatedData['letter_destination_json']);

        $letter = OutgoingLetter::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan surat keluar - surat ' . $validatedData['letter_type'] . ' dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('outgoing_letters', $request->user(), $letter->id, $description);


        // Generate PDF
        $data = [
            'title' => 'Surat Keluar',
            'letter' => $letter
        ];

        $pdf = PDF::loadView('dashboard.letters.outgoing_letters.pdf.' . $letter->letter_type, $data)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        // Save PDF to storage
        $letterTypeSlug = str_replace(' ', '_', strtolower($letter->letter_type));
        $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $letter->letter_number . '-' . $letter->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Mail::to('sonychandmaulana@gmail.com')->send(new OutgoingLetterNotification($request->user(), 'penambahan', $letter->id, null));

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Surat Keluar dan PDF berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = OutgoingLetter::find($id);

        return view('dashboard.letters.outgoing_letters.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($letterId): View
    {
        $title = 'Edit Surat Keluar';
        $letter = OutgoingLetter::find($letterId);

        return view('dashboard.letters.outgoing_letters.edit', compact('title', 'letter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'letter_type' => 'required|string',
            'letter_number' => 'required|string',
            'letter_nature' => 'required|string',
            'letter_subject' => 'required|string',
            'letter_date' => 'required|date',
            'letter_destination_json' => 'required|json',
            'to' => 'required|string',
            'letter_body' => 'required|string',
            'letter_closing' => 'required|string',
            'sign_name' => 'required|string',
            'sign_nip' => 'required|string',
            'sign_position' => 'required|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'required|string',
        ]);



        // Convert JSON fields back to JSON strings
        $validatedData['letter_destination'] = $validatedData['letter_destination_json'];

        // Remove the temporary JSON fields
        unset($validatedData['letter_destination_json']);

        $letter = OutgoingLetter::findOrFail($id);

        // Track changes
        $changes = [];

        // Decode JSON fields for comparison
        $originalData = $letter->toArray();
        $originalData['letter_destination'] = json_decode($originalData['letter_destination'], true);

        foreach ($validatedData as $key => $value) {
            // Decode JSON fields in validated data for comparison
            if (in_array($key, ['letter_destination'])) {
                $value = json_decode($value, true);
            }

            if ($originalData[$key] != $value) {
                $changes[] = $key;
            }
        }

        if (empty($changes)) {
            return redirect()->route('outgoing-letters.edit', $id)
                ->with('info', 'Tidak ada perubahan yang dilakukan.');
        }

        // Update the letter
        $letter->update($validatedData);


        // Create activity description
        $description = 'Pengguna ' . $request->user()->name . ' mengubah kolom: ' . implode(', ', $changes) . ' pada surat keluar dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('outgoing_letters', $request->user(), $letter->id, $description);
        // Regenerate PDF
        $data = [
            'title' => 'Letter Details',
            'letter' => $letter
        ];

        $pdf = PDF::loadView('dashboard.letters.outgoing_letters.pdf.' . $letter->letter_type, $data)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        // Save PDF to storage
        $letterTypeSlug = str_replace(' ', '_', strtolower($letter->letter_type));
        $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $letter->letter_number . '-' . $letter->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        Mail::to('sonychandmaulana@gmail.com')->send(new OutgoingLetterNotification($request->user(), 'perubahan', $letter->id, $originalData));

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Surat Keluar dan PDF berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $letter = OutgoingLetter::find($id);
        if ($letter) {
            $letterTypeSlug = str_replace(' ', '_', strtolower($letter->letter_type));
            $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $letter->letter_number . '-' . $letter->id . '.pdf';
            if (Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }
            $description = 'Pengguna ' . Auth::user()->name  . ' menghapus surat keluar dengan nomor surat: ' . $letter->letter_number;
            $this->logActivity('outgoing_letters', Auth::user(), $letter->id, $description);
            $letter->delete();
            return redirect()->route('outgoing-letters.index')
                ->with('success', 'Surat keluar berhasil dihapus');
        } else {
            return redirect()->route('outgoing-letters.index')
                ->with('error', 'Surat keluar tidak ditemukan.');
        }
    }
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $letterIds = explode(',', $request->input('letterIds', ''));
        if (!empty($letterIds)) {
            foreach ($letterIds as $letterId) {
                $data = OutgoingLetter::find($letterId);
                if ($data) {
                    $letterTypeSlug = str_replace(' ', '_', strtolower($data->letter_type));
                    $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $data->letter_number . '-' . $data->id . '.pdf';
                    if (Storage::disk('public')->exists($pdfPath)) {
                        Storage::disk('public')->delete($pdfPath);
                    }
                    $description = 'Pengguna ' . Auth::user()->name  . ' menghapus surat keluar dengan nomor surat: ' . $data->letter_number;
                    $this->logActivity('outgoing_letters', Auth::user(), $data->id, $description);
                }
                $pdfPath = 'surat/surat_keluar/' . $data->letter_number . '-' . $data->id . '.pdf';
                Storage::disk('public')->delete($pdfPath);
            }
            OutgoingLetter::whereIn('id', $letterIds)->delete();
            return redirect()->route('outgoing-letters.index')->with('success', 'Surat-surat keluar berhasil dihapus');
        }
        return redirect()->route('outgoing-letters.index')->with('error', 'Surat keluar tidak ditemukan.');
    }

    public function download($id)
    {
        $letter = OutgoingLetter::find($id);
        $letterTypeSlug = str_replace(' ', '_', strtolower($letter->letter_type));
        $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $letter->letter_number . '-' . $letter->id . '.pdf';
        $description = 'Pengguna ' . Auth::user()->name  . ' mengunduh surat keluar dengan nomor surat: ' . $letter->letter_number;
        $this->logActivity('outgoing_letters', Auth::user(), $letter->id, $description);
        return Storage::disk('public')->download($pdfPath);
    }
}
