<?php

namespace App\Http\Controllers\Backend\SPM;

use Illuminate\Http\Request;
use App\Models\Backend\SPM\Tahun;
use App\Models\Backend\SPM\Layanan;
use App\Http\Controllers\Controller;
use App\Models\Backend\SPM\SubLayanan;

class SubLayananController extends Controller
{
    public function index()
    {
        $title = 'Data Sub Layanan';
        $subLayanans = SubLayanan::all();

        return view('backend.spm.sub_layanan.index', compact('subLayanans', 'title'));
    }

    public function create()
    {
        $layanans = Layanan::all();
        $tahuns = Tahun::all();
        $title = 'Tambah Sub Layanan';
        return view('backend.spm.sub_layanan.create', compact('title', 'layanans', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'tahun_id' => 'required|exists:tahuns,id',
            'kode' => 'required|string',
            'uraian' => 'required|string',
            'satuan' => 'required|string',
        ]);

        SubLayanan::create($validatedData);

        return redirect()->route('master-spm-sub-layanan.index')->with('success', 'Sub Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = 'Edit Sub Layanan';
        $layanans = Layanan::all();
        $tahuns = Tahun::all();
        $subLayanan = SubLayanan::findOrFail($id);

        return view('backend.spm.sub_layanan.edit', compact('subLayanan', 'title', 'layanans', 'tahuns'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'tahun_id' => 'required|exists:tahuns,id',
            'kode' => 'required|string',
            'uraian' => 'required|string',
            'satuan' => 'required|string',
        ]);

        $subLayanan = SubLayanan::findOrFail($id);
        $subLayanan->update($validatedData);

        return redirect()->route('master-spm-sub-layanan.index')->with('success', 'Sub Layanan berhasil diubah.');
    }

    public function destroy($id)
    {
        $subLayanan = SubLayanan::findOrFail($id);
        $subLayanan->delete();

        return redirect()->route('master-spm-sub-layanan.index')->with('success', 'Sub Layanan berhasil dihapus.');
    }
}
