<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RuanganController extends Controller
{
    public function index()
    {
        $data = Ruangan::latest()->get();
        return view('ruangan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|string|max:50|unique:ruangan,kode',
            'nama'      => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);

        Ruangan::create($request->only('kode', 'nama', 'kapasitas'));

        Cache::forget('dashboard_stats');

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        return redirect()->route('ruangan.index');
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        $request->validate([
            'kode'      => 'required|string|max:50|unique:ruangan,kode,' . $ruangan->id,
            'nama'      => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ]);

        $ruangan->update($request->only('kode', 'nama', 'kapasitas'));

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        Cache::forget('dashboard_stats');

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus');
    }
}
