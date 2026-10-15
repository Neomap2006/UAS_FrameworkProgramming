<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LandingProgramController extends Controller
{
    /**
     * Display a listing of the programs.
     */
    public function index()
    {
        $programs = LandingProgram::orderBy('position')->get();

        return view('admin.landing.program.index', compact('programs'));
    }

    /**
     * Store a newly created program in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:255',
            'position'    => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'description', 'icon', 'position']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('Program Pendidikan', 'public');
        }

        LandingProgram::create($data);
        Cache::forget('landing_programs');

        return redirect()
            ->route('admin.landing.programs.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Update the specified program in storage.
     */
    public function update(Request $request, $id)
    {
        $program = LandingProgram::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'position'    => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'description', 'position']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('icon')) {
            // Hapus icon lama jika ada
            if ($program->icon && Storage::disk('public')->exists($program->icon)) {
                Storage::disk('public')->delete($program->icon);
            }

            $data['icon'] = $request->file('icon')->store('Program Pendidikan', 'public');
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }

            $data['image'] = $request->file('image')->store('Program Pendidikan', 'public');
        }

        $program->update($data);
        Cache::forget('landing_programs');

        return redirect()
            ->route('admin.landing.programs.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified program from storage.
     */
    public function destroy($id)
    {
        $program = LandingProgram::findOrFail($id);

        // Hapus gambar jika ada
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();
        Cache::forget('landing_programs');

        return back()->with('success', 'Program berhasil dihapus.');
    }
}
