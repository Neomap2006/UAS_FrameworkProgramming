<?php

namespace App\Http\Controllers;

use App\Models\LandingProgram;
use App\Models\LandingSetting;
use App\Models\LandingNavLink;
use App\Models\LandingFooterLink;
use App\Models\Tentang;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $landing = Cache::remember('landing_settings', 3600, function () {
            return LandingSetting::pluck('value', 'key')->toArray();
        });

        $programs = Cache::remember('landing_programs', 3600, function () {
            return LandingProgram::where('status', 1)
                ->orderBy('position')
                ->get();
        });

        $navigation = Cache::remember('landing_navigation', 3600, function () {
            return LandingNavLink::where('status', 1)
                ->orderBy('position')
                ->get();
        });

        $footer = Cache::remember('landing_footer', 3600, function () {
            return LandingFooterLink::where('status', 1)
                ->whereNotNull('group')
                ->orderBy('position')
                ->get();
        });

        $footerNav = Cache::remember('landing_footer_nav', 3600, function () {
            return LandingFooterLink::where('group', 'nav')
                ->where('status', 1)
                ->orderBy('position')
                ->get();
        });

        $tentang = Cache::remember('landing_tentang', 3600, function () {
            return Tentang::first() ?? (object) [
                'judul' => 'Tentang LP3I',
                'deskripsi' => 'LP3I adalah lembaga pendidikan vokasi yang fokus pada pendidikan relevan dengan dunia kerja.',
                'gambar' => null,
            ];
        });

        return view('welcome', compact('landing', 'programs', 'navigation', 'footer', 'footerNav', 'tentang'));
    }
}
