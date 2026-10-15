<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MatkulController extends Controller
{
    public function index()
    {
        $data = Matkul::latest()->get();
        return view('matkul.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:matkul,kode',
            'sks'  => 'required|integer|min:1',
        ]);

        Matkul::create($request->only('nama', 'kode', 'sks'));

        Cache::forget('dashboard_stats');

        return redirect()->route('matkul.index')->with('success', 'Matkul berhasil ditambahkan');
    }

    /**
     * Form edit matkul.
     */
    public function edit($id)
    {
        return redirect()->route('matkul.index');
    }

    /**
     * Update data matkul.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:matkul,kode,' . $id,
            'sks'  => 'required|integer|min:1',
        ]);

        $matkul = Matkul::findOrFail($id);
        $matkul->update($request->only('nama', 'kode', 'sks'));

        return redirect()->route('matkul.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $matkul = Matkul::findOrFail($id);
        $matkul->delete();

        Cache::forget('dashboard_stats');

        return redirect()->route('matkul.index')->with('success', 'Matkul berhasil dihapus');
    }
}
