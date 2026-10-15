<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        // $data = Mahasiswa::all();
        // return view('mahasiswa.index', compact('data'));

        $data = Mahasiswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('mahasiswa.index', compact('data','kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|unique:mahasiswa,nim',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Mahasiswa::create($request->only('nama','nim','kelas_id'));
        return redirect()->back()->with('success','Data mahasiswa berhasil ditambahkan!');
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

        $mhs->update($request->only('nama','nim','kelas_id'));

        return redirect()->route('mahasiswa.index')->with('success','Data mahasiswa berhasil diupdate!');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();

        return redirect()->route('mahasiswa.index')->with('success','Data berhasil dihapus!');
    }
}
