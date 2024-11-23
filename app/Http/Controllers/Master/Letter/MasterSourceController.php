<?php

namespace App\Http\Controllers\Master\Letter;

use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Master\MasterSource;
use App\Http\Controllers\Controller;
use App\Models\Managements\Employee;
use Illuminate\Support\Facades\Auth;

class MasterSourceController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Surat - Master Disposisi';
        $master = MasterSource::all();

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

        MasterSource::create($validatedData);

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' menambahkan master disposisi');

        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Master Surat - Edit Master Disposisi';
        $master = MasterSource::findOrFail($id);
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

        $master = MasterSource::findOrFail($id);
        $master->update($validatedData);

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' mengubah master disposisi');
        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $master = MasterSource::findOrFail($id);
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
                $master = MasterSource::findOrFail($id);
                $master->delete();
            }
        }

        $this->logActivity('master_dispositions', Auth::user(), null, 'Pengguna ' . Auth::user()->name . ' menghapus master disposisi');
        return redirect()->route('master-letter-dispositions.index')->with('success', 'Master Disposisi berhasil dihapus.');
    }
}
