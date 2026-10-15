<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LP3I College') }} - Portal Akademik</title>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col"
         x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false' }"
         x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebarOpen', val))">

        {{-- ====== HEADER / NAVBAR ATAS ====== --}}
        @include('layouts.navigation')

        {{-- ====== BODY: Sidebar + Konten Utama ====== --}}
        <div class="flex flex-1 relative overflow-x-hidden">

            {{-- Mobile Backdrop Overlay --}}
            <div x-show="sidebarOpen"
                 x-cloak
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-20 md:hidden transition-opacity"
                 style="display: none;"></div>

            {{-- SIDEBAR KIRI --}}
            <aside :class="sidebarOpen ? 'ml-0' : '-ml-64'"
                   class="w-64 bg-white border-r border-slate-200 shadow-xs flex flex-col justify-between overflow-y-auto shrink-0 z-30 transition-all duration-300 ease-in-out">
                <nav class="p-4 space-y-6">

                    @if (Auth::check() && Auth::user()->role === 'admin')

                        {{-- GROUP 1: MENU UTAMA --}}
                        <div>
                            <div class="px-3 mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Menu Akademik
                            </div>

                            <div class="space-y-1">
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span class="text-lg">🏠</span>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('mahasiswa.index') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('mahasiswa.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span class="text-lg">👥</span>
                                    <span>Mahasiswa</span>
                                </a>

                                <a href="{{ route('ruangan.index') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('ruangan.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span class="text-lg">🏢</span>
                                    <span>Ruangan</span>
                                </a>

                                <a href="{{ route('matkul.index') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('matkul.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span class="text-lg">📚</span>
                                    <span>Mata Kuliah</span>
                                </a>

                                <a href="{{ route('dosen.index') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('dosen.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span class="text-lg">👨‍🏫</span>
                                    <span>Dosen</span>
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 2: VERIFIKASI PMB --}}
                        <div>
                            <div class="px-3 mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Pendaftaran & eKYC
                            </div>

                            <div class="space-y-1">
                                <a href="{{ route('admin.ekyc.index') }}"
                                   class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all duration-150 {{ request()->routeIs('admin.ekyc.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg">✅</span>
                                        <span>eKYC Mahasiswa</span>
                                    </div>
                                    @php
                                        $pendingCount = \App\Models\EkycRegistration::where('status', 'submitted')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ request()->routeIs('admin.ekyc.*') ? 'bg-white text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $pendingCount }}
                                        </span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        {{-- GROUP 3: LANDING PAGE CMS --}}
                        <div x-data="{ open: {{ request()->routeIs('admin.landing.*') ? 'true' : 'false' }} }"
                             class="pt-2">

                            <div class="px-3 mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Landing Page CMS
                            </div>

                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition font-medium {{ request()->routeIs('admin.landing.*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600' }}">
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">📰</span>
                                    <span>Kelola Website</span>
                                </div>
                                <svg :class="open ? 'rotate-180' : ''" class="h-4 w-4 text-slate-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-cloak x-transition class="mt-1 pl-4 space-y-1">
                                <a href="{{ route('admin.landing.settings.index') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.landing.settings.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span>⚙️</span>
                                    <span>Pengaturan Hero</span>
                                </a>

                                <a href="{{ route('admin.landing.navigation.index') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.landing.navigation.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span>📑</span>
                                    <span>Menu Navigasi</span>
                                </a>

                                <a href="{{ route('admin.landing.programs.index') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.landing.programs.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span>🎓</span>
                                    <span>Program Studi</span>
                                </a>

                                <a href="{{ route('admin.landing.footer.index') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.landing.footer.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span>📄</span>
                                    <span>Footer Links</span>
                                </a>

                                <a href="{{ route('admin.landing.tentang.index') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition {{ request()->routeIs('admin.landing.tentang.*') ? 'bg-blue-600 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600 font-medium' }}">
                                    <span>📖</span>
                                    <span>Profil Tentang</span>
                                </a>
                            </div>
                        </div>

                    @else
                        {{-- Menu untuk Calon Mahasiswa / User Biasa --}}
                        <div>
                            <div class="px-3 mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Pendaftaran
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('ekyc.step1') }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-semibold shadow-xs">
                                    <span>📝</span>
                                    <span>Formulir eKYC</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </nav>

                {{-- SIDEBAR FOOTER / INFO --}}
                <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-xs text-slate-500 font-medium">Sistem Berjalan Aktif</span>
                    </div>
                </div>
            </aside>

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 p-6 lg:p-8 bg-slate-50 overflow-x-hidden">
                {{-- Flash Message Success --}}
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs transition-all">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">✅</span>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-emerald-600 hover:text-emerald-800 text-xl font-bold p-1 rounded-lg hover:bg-emerald-100/50 cursor-pointer" title="Tutup">&times;</button>
                    </div>
                @endif

                {{-- Flash Message Error --}}
                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs transition-all">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">⚠️</span>
                            <span class="font-medium text-sm">{{ session('error') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-800 text-xl font-bold p-1 rounded-lg hover:bg-rose-100/50 cursor-pointer" title="Tutup">&times;</button>
                    </div>
                @endif

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs transition-all">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <span class="text-xl">⚠️</span>
                                <div>
                                    <h4 class="font-semibold text-sm mb-1">Terjadi kesalahan input:</h4>
                                    <ul class="list-disc pl-5 space-y-0.5 text-xs font-medium">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" @click="show = false" class="text-rose-600 hover:text-rose-800 text-xl font-bold p-1 rounded-lg hover:bg-rose-100/50 cursor-pointer" title="Tutup">&times;</button>
                        </div>
                    </div>
                @endif

                {{-- Konten dari child view --}}
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>
    </div>
</body>
</html>
