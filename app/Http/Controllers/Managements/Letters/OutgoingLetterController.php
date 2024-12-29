<?php

namespace App\Http\Controllers\Managements\Letters;

use PDF;
use Illuminate\View\View;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Mail\OutgoingLetterNotification;
use App\Exports\Letters\OutgoingLettersExport;
use App\Models\Managements\Letters\OutgoingLetter;
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
    public function create(Request $request): View
    {
        $type = $request->query('type');
        $title = 'Tambah Surat Keluar';
        $employees = Employee::all();

        return view('dashboard.letters.outgoing_letters.create', compact('title', 'employees', 'type'));
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
            'letter_number' => 'nullable|string',
            'letter_nature' => 'nullable|string',
            'letter_subject' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'letter_destination' => 'nullable|array',
            'to' => 'nullable|string',
            'letter_body' => 'nullable|string',
            'event_date_start' => 'nullable|string',
            'event_date_end' => 'nullable|string',
            'event_time_start' => 'nullable|string',
            'event_time_end' => 'nullable|string',
            'event_location' => 'nullable|string',
            'event_agenda' => 'nullable|string',
            'letter_closing' => 'nullable|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'nullable|string',
            'file_path' => 'nullable|array',
            'signed_by' => 'required',
        ]);


        $outgoingLetter = OutgoingLetter::create($validatedData);

        $description = 'Pengguna ' . $request->user()->name . ' menambahkan surat keluar dengan nomor: ' . $outgoingLetter->letter_number;
        $this->logActivity('outgoing_letters', $request->user(), $outgoingLetter->id, $description);

        // Generate PDF
        $data = [
            'title' => 'Surat Keluar',
            'letter' => $outgoingLetter
        ];

        $pdf = PDF::loadView('dashboard.letters.outgoing_letters.pdf.' . $outgoingLetter->letter_type, $data)
            ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        // Save PDF to storage
        $letterTypeSlug = str_replace(' ', '_', strtolower($outgoingLetter->letter_type));
        $pdfPath = 'surat/surat_keluar/' . $letterTypeSlug . '/' . $outgoingLetter->letter_number . '-' . $outgoingLetter->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());


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
        $employees = Employee::all();

        return view('dashboard.letters.outgoing_letters.edit', compact('title', 'letter', 'employees'));
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
            'letter_number' => 'nullable|string',
            'letter_nature' => 'nullable|string',
            'letter_subject' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'letter_destination' => 'nullable|array',
            'to' => 'nullable|string',
            'letter_body' => 'nullable|string',
            'event_date_start' => 'nullable|string',
            'event_date_end' => 'nullable|string',
            'event_time_start' => 'nullable|string',
            'event_time_end' => 'nullable|string',
            'event_location' => 'nullable|string',
            'event_agenda' => 'nullable|string',
            'letter_closing' => 'nullable|string',
            'attachment' => 'nullable|string',
            'operator_name' => 'nullable|string',
            'file_path' => 'nullable|array',
            'signed_by' => 'required|exists:employees,id',
        ]);



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

    public function export(Request $request, $format)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $letterType = $request->input('letter_type');
        $orderBy = $request->input('order_by');

        $query = OutgoingLetter::whereBetween('letter_date', [$startDate, $endDate])
            ->where('letter_type', $letterType);

        if ($orderBy === 'letter_number_asc') {
            $query->orderBy('letter_number', 'asc');
        } elseif ($orderBy === 'letter_number_desc') {
            $query->orderBy('letter_number', 'desc');
        } elseif ($orderBy === 'letter_date_asc') {
            $query->orderBy('letter_date', 'asc');
        } elseif ($orderBy === 'letter_date_desc') {
            $query->orderBy('letter_date', 'desc');
        }

        $letters = $query->get();


        if ($letters->isEmpty()) {
            return redirect()->back()->with('error', 'Data surat keluar tidak ditemukan.');
        }

        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh data surat keluar dalam format ' . $format;
        $this->logActivity('outgoing_letters', Auth::user(), null, $description);
        if ($format === 'pdf') {
            $pdf = PDF::loadView('dashboard.letters.outgoing_letters.exports.outgoing_letters_pdf', compact('letters'));
            return $pdf->download('surat-keluar.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new OutgoingLettersExport($letters), 'surat-keluar.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
