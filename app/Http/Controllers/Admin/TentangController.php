<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class TentangController extends Controller
{
    /**
     * Tampilkan halaman kelola konten Tentang
     */
    public function index()
    {
        $tentang = Tentang::firstOrCreate([], [
            'judul'     => '',
            'deskripsi' => '',
            'gambar'    => null,
        ]);

        return view('admin.landing.tentang.index', compact('tentang'));
    }

    /**
     * Update konten Tentang
     */
    public function update(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // max 2MB
        ]);

        $tentang = Tentang::firstOrFail();

        $tentang->judul     = $request->judul;
        $tentang->deskripsi = $request->deskripsi;

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // Hapus gambar lama kalau ada
            if ($tentang->gambar && file_exists(public_path($tentang->gambar))) {
                unlink(public_path($tentang->gambar));
            }

            // Simpan gambar baru
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/landing'), $filename);

            $tentang->gambar = 'uploads/landing/' . $filename;
        }

        $tentang->save();

        // Bersihkan cache yang terkait
        Cache::forget('landing_settings');
        Cache::forget('landing_tentang');

        return redirect()
            ->route('admin.landing.tentang.index')
            ->with('success', 'Konten Tentang berhasil diperbarui!');
    }
}
