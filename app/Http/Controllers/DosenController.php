<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DosenController extends Controller
{
    /**
     * Tampilkan daftar dosen.
     */
    public function index()
    {
        $data = Dosen::latest()->get();
        return view('dosen.index', compact('data'));
    }

    /**
     * Simpan dosen baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'nid'         => 'required|string|max:50|unique:dosen,nid',
            'alamat'      => 'nullable|string|max:255',
            'mata_kuliah' => 'nullable|string|max:100',
            'mataKuliah'  => 'nullable|string|max:100',
        ]);

        $mataKuliah = $request->input('mata_kuliah', $request->input('mataKuliah'));

        Dosen::create([
            'nama'        => $request->nama,
            'nid'         => $request->nid,
            'alamat'      => $request->alamat,
            'mata_kuliah' => $mataKuliah,
        ]);

        Cache::forget('dashboard_stats');

        return redirect()->route('dosen.index')
                        ->with('success', 'Dosen berhasil ditambahkan.');
    }

    /**
     * Form edit dosen.
     */
    public function edit($id)
    {
        return redirect()->route('dosen.index');
    }

    /**
     * Update data dosen.
     */
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:100',
            'nid'         => 'required|string|max:50|unique:dosen,nid,' . $dosen->id,
            'alamat'      => 'nullable|string|max:255',
            'mata_kuliah' => 'nullable|string|max:100',
            'mataKuliah'  => 'nullable|string|max:100',
        ]);

        $mataKuliah = $request->input('mata_kuliah', $request->input('mataKuliah'));

        $dosen->update([
            'nama'        => $request->nama,
            'nid'         => $request->nid,
            'alamat'      => $request->alamat,
            'mata_kuliah' => $mataKuliah,
        ]);

        return redirect()->route('dosen.index')
                        ->with('success', 'Data dosen berhasil diupdate.');
    }

    /**
     * Hapus dosen.
     */
    public function destroy($id)
    {
        Dosen::destroy($id);

        Cache::forget('dashboard_stats');

        return redirect()->route('dosen.index')
                        ->with('success', 'Dosen berhasil dihapus.');
    }
}
