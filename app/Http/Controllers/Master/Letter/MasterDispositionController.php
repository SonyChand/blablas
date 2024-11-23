<?php

namespace App\Http\Controllers\Master\Letter;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Master\MasterDisposition;
use App\Exports\Master\Letter\MasterDispositionsExport;
use PDF;

class MasterDispositionController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Surat - Master Disposisi';
        $master = MasterDisposition::all();

        return view('dashboard.master.letters.dispositions.index', compact('master', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Master Surat - Tambah Master Disposisi';
        $employees = Employee::all();

        return view('dashboard.master.letters.dispositions.create', compact('title', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'alias' => 'nullable|string'
        ]);

        MasterDisposition::create($validatedData);

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' menambahkan master disposisi');

        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Master Surat - Edit Master Disposisi';
        $master = MasterDisposition::findOrFail($id);
        $employees = Employee::all();

        return view('dashboard.master.letters.dispositions.edit', compact('master', 'title', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'alias' => 'nullable|string'
        ]);

        $master = MasterDisposition::findOrFail($id);
        $master->update($validatedData);

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' mengubah master disposisi');
        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $master = MasterDisposition::findOrFail($id);
        $master->delete();

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' menghapus master disposisi');
        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $uuid = $request->input('ids');

        // Check if $uuid is a string and convert it to an array
        if (is_string($uuid)) {
            $uuid = explode(',', $uuid); // Convert comma-separated string to array
        }

        if (!empty($uuid) && is_array($uuid)) {
            foreach ($uuid as $id) {
                $master = MasterDisposition::findOrFail($id);
                $master->delete();
            }
        }

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' menghapus master disposisi');
        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil dihapus.');
    }

    public function export(Request $request, $format)
    {

        $masters = MasterDisposition::all();

        if ($masters->isEmpty()) {
            return redirect()->back()->with('error', 'Data master disposisi tidak ditemukan.');
        }

        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh data master disposisi dalam format ' . $format;
        $this->logActivity('outgoing_letters', Auth::user(), null, $description);

        $title = 'Master Surat - Master Disposisi';
        if ($format === 'pdf') {
            $pdf = PDF::loadView('dashboard.master.letters.dispositions.exports.master_dispositions_pdf', compact('masters', 'title'));
            return $pdf->download('master-disposisi.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new MasterDispositionsExport($masters), 'master-disposisi.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
