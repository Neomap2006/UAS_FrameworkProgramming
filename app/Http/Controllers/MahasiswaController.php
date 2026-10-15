<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Eager load relasi kelas dengan pemilihan kolom spesifik
        $data = Mahasiswa::with(['kelas:id,nama_kelas'])->latest()->get();

        // Cache master data kelas selama 1 jam
        $kelas = Cache::remember('master_kelas_list', 3600, function () {
            return Kelas::select('id', 'nama_kelas')->get();
        });

        return view('mahasiswa.index', compact('data', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|unique:mahasiswa,nim',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Mahasiswa::create($request->only('nama', 'nim', 'kelas_id'));

        // Invalidate dashboard stats cache
        Cache::forget('dashboard_stats');

        return redirect()->back()->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    // ✅ Edit (Redirect ke index karena menggunakan Modal Edit)
    public function edit($id)
    {
        return redirect()->route('mahasiswa.index');
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|unique:mahasiswa,nim,' . $mhs->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $mhs->update($request->only('nama', 'nim', 'kelas_id'));

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diupdate!');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();

        // Invalidate dashboard stats cache
        Cache::forget('dashboard_stats');

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus!');
    }
}
