<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EkycRegistration;
use App\Models\MasterAlamat;
use App\Models\LandingProgram;
use App\Models\Tentang; // ← Tambahkan ini jika belum ada
use App\Models\LandingSetting;
use App\Models\LandingFooterLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class EkycController extends Controller
{
    /**
     * STEP 1: DATA PRIBADI
     */
    public function step1()
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())
        ->first();
        // ->where('status', 'draft')

        // simpan session agar bisa lanjut ke steep berikutnya
        if ($ekyc) {
            session(['ekyc_id' => $ekyc->id]);
        }

        return view('ekyc.step1', compact('ekyc'));
    }

    public function storeStep1(Request $request)
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())->first();

        if ($ekyc && $ekyc->status === 'submitted') {
            return redirect()->route('ekyc.step2');
        }

        // Cari atau buat berdasarkan user_id dan ekyc_id dari session
        $ekycId = session('ekyc_id');
        $existingEkyc = EkycRegistration::where('user_id', Auth::id())->first();

        $validationRules = [
            'nama'  => 'required|string|max:100',
            'nik'           => 'required|string|max:20|digits:16',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
        ];

        // Tambahkan validasi unique untuk NIK, kecuali untuk record yang sedang diupdate
        if ($existingEkyc && $existingEkyc->id) {
            $validationRules['nik'] .= '|unique:ekyc_registrations,nik,' . $existingEkyc->id;
        } else {
            $validationRules['nik'] .= '|unique:ekyc_registrations,nik';
        }

        $request->validate($validationRules);

        if ($ekycId) {
            $ekyc = EkycRegistration::where('id', $ekycId)
                ->where('user_id', Auth::id())
                ->first();

            if ($ekyc) {
                $ekyc->update([
                    'nama'  => $request->nama,
                    'nik'           => $request->nik,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat'        => $request->alamat,
                    'status'        => 'draft',
                ]);
            } else {
                $ekyc = EkycRegistration::create([
                    'user_id'       => Auth::id(),
                    'nama'          => $request->nama,
                    'nik'           => $request->nik,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat'        => $request->alamat,
                    'status'        => 'draft',
                ]);
            }
        } else {
            $ekyc = EkycRegistration::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                ],
                [
                    'nama'          => $request->nama,
                    'nik'           => $request->nik,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat'        => $request->alamat,
                    'status'        => 'draft',
                ]
            );
        }

        session(['ekyc_id' => $ekyc->id]);

        return redirect()
            ->route('ekyc.step2')
            ->with('success', 'Data pribadi berhasil disimpan. Lanjut ke langkah berikutnya ➜');
    }

    /**
     * STEP 2: UPLOAD KTP & SELFIE
     */
    public function step2()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        // Jika belum ada data dari step1, redirect ke step1
        if (!$data) {
            return redirect()->route('ekyc.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        return view('ekyc.step2', compact('data'));
    }

    public function storeStep2(Request $request)
    {
        $ekyc = EkycRegistration::where('user_id', Auth::id())->first();

        // Jika belum ada data dari step1, redirect ke step1
        if (!$ekyc) {
            return redirect()->route('ekyc.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        if ($ekyc->status === 'submitted') {
            return redirect()->route('ekyc.step3');
        }

        $validated = $request->validate([
            'file_ktp'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_selfie' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update file jika diupload
        if ($request->hasFile('file_ktp')) {
            // Hapus file lama jika ada
            if ($ekyc->file_ktp && Storage::disk('public')->exists($ekyc->file_ktp)) {
                Storage::disk('public')->delete($ekyc->file_ktp);
            }
            $validated['file_ktp'] = $request->file('file_ktp')->store('ekyc', 'public');
        }

        if ($request->hasFile('file_selfie')) {
            // Hapus file lama jika ada
            if ($ekyc->file_selfie && Storage::disk('public')->exists($ekyc->file_selfie)) {
                Storage::disk('public')->delete($ekyc->file_selfie);
            }
            $validated['file_selfie'] = $request->file('file_selfie')->store('ekyc', 'public');
        }

        $ekyc->update($validated);

        return redirect()
            ->route('ekyc.step3')
            ->with('success', 'Foto KTP dan selfie berhasil disimpan.');
    }

    /**
     * STEP 3: DATA PENDIDIKAN
     */
    public function step3()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        // Jika belum ada data dari step sebelumnya, redirect ke step1
        if (!$data) {
            return redirect()->route('ekyc.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        return view('ekyc.step3', compact('data'));
    }

    public function storeStep3(Request $request)
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        // Jika belum ada data dari step sebelumnya, redirect ke step1
        if (!$data) {
            return redirect()->route('ekyc.step1')
                ->with('error', 'Silakan lengkapi data pribadi terlebih dahulu.');
        }

        if ($data->status === 'submitted') {
            return redirect()->route('ekyc.step4');
        }

        $request->validate([
            'asal_sd'     => 'nullable|string|max:255',
            'asal_smp'    => 'nullable|string|max:255',
            'asal_sma'    => 'nullable|string|max:255',
            'file_kk'     => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ijazah' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Update data pendidikan
        $data->asal_sd  = $request->asal_sd;
        $data->asal_smp = $request->asal_smp;
        $data->asal_sma = $request->asal_sma;

        // Update file jika diupload
        if ($request->hasFile('file_kk')) {
            // Hapus file lama jika ada
            if ($data->file_kk && Storage::disk('public')->exists($data->file_kk)) {
                Storage::disk('public')->delete($data->file_kk);
            }
            $data->file_kk = $request->file('file_kk')->store('ekyc', 'public');
        }

        if ($request->hasFile('file_ijazah')) {
            // Hapus file lama jika ada
            if ($data->file_ijazah && Storage::disk('public')->exists($data->file_ijazah)) {
                Storage::disk('public')->delete($data->file_ijazah);
            }
            $data->file_ijazah = $request->file('file_ijazah')->store('ekyc', 'public');
        }

        $data->save();

        return redirect()
            ->route('ekyc.step4')
            ->with('success', 'Data pendidikan berhasil disimpan.');
    }

    /**
     * STEP 4: DATA DOMISILI
     */
    public function step4()
    {
        $alamatList = MasterAlamat::all();
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        $provinsiList  = MasterAlamat::select('provinsi')->distinct()->pluck('provinsi');
        $kotaList      = [];
        $kecamatanList = [];

        if ($data && $data->provinsi) {
            $kotaList = MasterAlamat::where('provinsi', $data->provinsi)
                ->select('kota')->distinct()->pluck('kota');
        }

        if ($data && $data->kota) {
            $kecamatanList = MasterAlamat::where('kota', $data->kota)
                ->select('kecamatan')->distinct()->pluck('kecamatan');
        }

        return view('ekyc.step4', compact(
            'data',
            'alamatList',
            'provinsiList',
            'kotaList',
            'kecamatanList'
        ));
    }

    public function storeStep4(Request $request)
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        if ($data && $data->status === 'submitted') {
            return redirect()->route('ekyc.step5');
        }

        $request->validate([
            'alamat_domisili'   => 'nullable|string|max:255',
            'provinsi'          => 'nullable|string|max:100',
            'kota'              => 'nullable|string|max:100',
            'kecamatan'         => 'nullable|string|max:100',
            'kode_pos'          => 'nullable|string|max:10',
            'nama_ibu_kandung'  => 'nullable|string|max:100',
            'referensi_sumber'  => 'nullable|string|max:100',
        ]);

        if (!$data) {
            return redirect()->route('ekyc.step1')->with('error', 'Data E-KYC Tidak Ditemukan');
        }

        // Simpan data alamat & informasi pendaftaran
        // Konversi string kosong menjadi null untuk field nullable
        $updateData = [
            'alamat_domisili'  => $request->alamat_domisili ? trim($request->alamat_domisili) : null,
            'provinsi'         => $request->provinsi ?: null,
            'kota'             => $request->kota ?: null,
            'kecamatan'        => $request->kecamatan ?: null,
            'kode_pos'         => $request->kode_pos ?: null,
            'nama_ibu_kandung' => $request->nama_ibu_kandung ?: null,
            'referensi_sumber' => $request->referensi_sumber ?: null,
            'status'           => 'submitted',
        ];

        // Konversi string kosong menjadi null
        foreach ($updateData as $key => $value) {
            if ($value === '') {
                $updateData[$key] = null;
            }
        }

        // Update data menggunakan fill() untuk memastikan semua field di fillable tersimpan
        $data->fill($updateData);

        // Simpan perubahan
        $saved = $data->save();

        if (!$saved) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data. Silakan coba lagi.')
                ->withInput();
        }

        // redirect ke halaman sukses (step 5)
        return redirect()->route('ekyc.step5')->with('success', 'E-KYC berhasil diselesaikan. Terima kasih!');
    }

    /**
     * STEP 5: KONFIRMASI / SELESAI
     */
    public function step5()
    {
        $data = EkycRegistration::where('user_id', Auth::id())->first();

        if (!$data) {
            return redirect()->route('ekyc.step1')->with('error', 'Data E-KYC Tidak Ditemukan');
        }

        // pastikan hanya user dengan status selesai yang bisa melihat halaman ini
        if ($data->status !== 'submitted') {
            return redirect()->route('ekyc.step4')->with('error', 'Lengkapi Data Terlebih Dahulu Sebelum Menyelesaikan E-KYC');
        }

        return view('ekyc.step5', compact('data'));
    }
}
