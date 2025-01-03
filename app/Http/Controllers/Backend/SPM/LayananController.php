<?php

namespace App\Http\Controllers\Backend\SPM;

use App\Http\Controllers\Controller;
use App\Models\Backend\SPM\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
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
        $title = 'Data Layanan';
        $layanans = Layanan::all();

        return view('backend.spm.layanan.index', compact('layanans', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Layanan';
        return view('backend.spm.layanan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode' => 'required|string|max:1',
            'nama' => 'required|string',
            'persentase' => 'required|numeric',
        ]);

        Layanan::create($validatedData);

        return redirect()->route('master-spm-layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Layanan';
        $layanan = Layanan::findOrFail($id);

        return view('backend.spm.layanan.edit', compact('layanan', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode' => 'required|string|max:1',
            'nama' => 'required|string',
            'persentase' => 'required|numeric',
        ]);

        $layanan = Layanan::findOrFail($id);
        $layanan->update($validatedData);

        return redirect()->route('master-spm-layanan.index')->with('success', 'Layanan berhasil diubah.');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('master-spm-layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
