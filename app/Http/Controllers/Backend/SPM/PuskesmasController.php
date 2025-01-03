<?php

namespace App\Http\Controllers\Backend\SPM;

use App\Http\Controllers\Controller;
use App\Models\Backend\SPM\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
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
        $title = 'Data Puskesmas';
        $puskesmas = Puskesmas::all();

        return view('backend.spm.puskesmas.index', compact('puskesmas', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Puskesmas';
        return view('backend.spm.puskesmas.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'nullable|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        Puskesmas::create($validatedData);

        return redirect()->route('master-spm-puskesmas.index')->with('success', 'Puskesmas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Puskesmas';
        $puskesmas = Puskesmas::findOrFail($id);

        return view('backend.spm.puskesmas.edit', compact('puskesmas', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode' => 'nullable|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $puskesmas = Puskesmas::findOrFail($id);
        $puskesmas->update($validatedData);

        return redirect()->route('master-spm-puskesmas.index')->with('success', 'Puskesmas berhasil diubah.');
    }

    public function destroy($id)
    {
        $puskesmas = Puskesmas::findOrFail($id);
        $puskesmas->delete();

        return redirect()->route('master-spm-puskesmas.index')->with('success', 'Puskesmas berhasil dihapus.');
    }
}
