<?php

namespace App\Http\Controllers\Backend\SPM;

use App\Http\Controllers\Controller;
use App\Models\Backend\SPM\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahunController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:master-spm-list|master-spm-create|master-spm-edit|master-spm-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:master-spm-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:master-spm-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:master-spm-delete', ['only' => ['destroy', 'bulkDestroy']]);
        $this->middleware('permission:master-spm-download', ['only' => ['download', 'index']]);
    }
    public function index()
    {
        $title = 'Data Tahun';
        $tahuns = Tahun::all();

        return view('backend.spm.tahun.index', compact('tahuns', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Tahun';
        return view('backend.spm.tahun.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|integer|digits:4'
        ]);

        Tahun::create($validatedData);

        return redirect()->route('master-spm-tahun.index')->with('success', 'Tahun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Tahun';
        $tahun = Tahun::findOrFail($id);

        return view('backend.spm.tahun.edit', compact('tahun', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tahun' => 'required|integer|digits:4'
        ]);

        $tahun = Tahun::findOrFail($id);
        $tahun->update($validatedData);

        return redirect()->route('master-spm-tahun.index')->with('success', 'Tahun berhasil diubah.');
    }

    public function destroy($id)
    {
        $tahun = Tahun::findOrFail($id);
        $tahun->delete();

        return redirect()->route('master-spm-tahun.index')->with('success', 'Tahun berhasil dihapus.');
    }
}
