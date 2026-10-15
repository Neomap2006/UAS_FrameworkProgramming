<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSetting;
use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LandingSettingController extends Controller
{
    /**
     * Tampilkan daftar general landing settings (hero, footer text, dll.)
     */
    public function index()
    {
        $settings = LandingSetting::orderBy('key')->get();

        return view('admin.landing.settings.index', compact('settings'));
    }

    /**
     * Simpan setting baru (general)
     */
    public function store(Request $request)
    {
        $request->validate([
            'key'    => 'required|string|unique:landing_settings,key',
            'type'   => 'required|in:text,image,json',
            'status' => 'required|boolean',
            'value'  => 'nullable',
        ]);

        $value = $request->value;

        if ($request->type === 'image' && $request->hasFile('value')) {
            $value = $request->file('value')->store('landing', 'public');
        }

        LandingSetting::create([
            'key'    => $request->key,
            'type'   => $request->type,
            'value'  => $value,
            'status' => $request->status,
        ]);

        Cache::forget('landing_settings');

        return redirect()->back()->with('success', 'Setting berhasil disimpan');
    }

    /**
     * Update setting general (hero, footer, dll.)
     */
    public function update(Request $request, $id)
    {
        $setting = LandingSetting::findOrFail($id);

        $request->validate([
            'type'   => 'required|in:text,image,json',
            'status' => 'required|boolean',
        ]);

        if ($request->type === 'image') {
            if ($request->hasFile('value')) {
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                $setting->value = $request->file('value')->store('landing', 'public');
            }
        } else {
            $setting->value = $request->value;
        }

        $setting->type   = $request->type;
        $setting->status = $request->status;
        $setting->save();

        Cache::forget('landing_settings');

        return redirect()->back()->with('success', 'Setting berhasil diupdate');
    }


}
