<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingFooterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingFooterController extends Controller
{
    /**
     * Display a listing of the footer links.
     */
    public function index()
    {
        $links = LandingFooterLink::orderBy('position')->get();
        return view('admin.landing.footer.index', compact('links'));
    }

    /**
     * Show form to create a new footer link.
     */
    public function create()
    {
        return view('admin.landing.footer.create');
    }

    /**
     * Store new footer link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'position' => 'nullable|integer|min:1',
            'status' => 'required|boolean',
        ]);

        DB::transaction(function() use ($request) {

            // Jika posisi tidak diisi, otomatis max+1
            $newPos = $request->position ?? (LandingFooterLink::max('position') + 1);

            // Geser semua link yang posisinya >= newPos turun
            LandingFooterLink::where('position', '>=', $newPos)
                ->increment('position');

            // Tambah link baru
            LandingFooterLink::create([
                'label' => $request->label,
                'url' => $request->url,
                'position' => $newPos,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.landing.footer.index')
            ->with('success', 'Footer link added.');
    }

    /**
     * Show form to edit a footer link.
     */
    public function edit($id)
    {
        $footer = LandingFooterLink::findOrFail($id);
        return view('admin.landing.footer.edit', compact('footer'));
    }

    /**
     * Update footer link.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'position' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        DB::transaction(function() use ($request, $id) {
            $footer = LandingFooterLink::findOrFail($id);
            $oldPos = $footer->position;
            $newPos = $request->position;

            // 1. Jika posisi berubah
            if ($oldPos != $newPos) {
                if ($newPos > $oldPos) {
                    // Geser semua link yang posisinya di antara oldPos+1 dan newPos turun
                    LandingFooterLink::whereBetween('position', [$oldPos + 1, $newPos])
                        ->decrement('position');
                } else {
                    // Geser semua link yang posisinya di antara newPos dan oldPos-1 naik
                    LandingFooterLink::whereBetween('position', [$newPos, $oldPos - 1])
                        ->increment('position');
                }
            }

            // 2. Update link dengan data baru
            $footer->update([
                'label' => $request->label,
                'url' => $request->url,
                'position' => $newPos,
                'status' => $request->status,
            ]);
        });

        return redirect()->route('admin.landing.footer.index')
            ->with('success', 'Footer link updated.');
    }

    /**
     * Delete footer link.
     */
    public function destroy($id)
    {
        $footer = LandingFooterLink::findOrFail($id);
        $footer->delete();
        return redirect()->route('admin.landing.footer.index')
            ->with('success', 'Footer link deleted.');
    }

    /**
     * Update sorting order (AJAX optional).
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:landing_footer_links,id',
            'order.*.position' => 'required|integer|min:1',
        ]);

        foreach ($request->order as $order) {
            LandingFooterLink::where('id', $order['id'])
                ->update(['position' => $order['position']]);
        }
        return response()->json(['message' => 'Urutan footer berhasil diperbaharui.']);
    }

    /**
     * Toggle active/inactive status (optional).
     */
    public function toggleStatus($id)
    {
        $footer = LandingFooterLink::findOrFail($id);
        $footer->status = !$footer->status;
        $footer->save();

        return redirect()->route('admin.landing.footer.index')
            ->with('success', 'Footer status updated.');
    }
}
