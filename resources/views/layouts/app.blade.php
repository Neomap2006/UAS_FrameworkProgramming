<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">

        {{-- ====== HEADER / NAVBAR ATAS ====== --}}
        @include('layouts.navigation')

        {{-- ====== BODY: Sidebar + Konten Utama ====== --}}
        <div class="flex flex-1">

            {{-- SIDEBAR KIRI --}}
            <aside class="w-64 bg-white border-r shadow-sm overflow-y-auto">
                <nav class="p-4 space-y-1">

                    @if (Auth::check() && Auth::user()->role === 'admin')

                        <a href="{{ route('dashboard') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                            🏠 Dashboard
                        </a>

                        <a href="{{ route('mahasiswa.index') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('mahasiswa.*') ? 'bg-gray-200 font-semibold' : '' }}">
                            👥 Mahasiswa
                        </a>

                        <a href="{{ route('ruangan.index') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('ruangan.*') ? 'bg-gray-200 font-semibold' : '' }}">
                            🏢 Ruangan
                        </a>

                        <a href="{{ route('matkul.index') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('matkul.*') ? 'bg-gray-200 font-semibold' : '' }}">
                            📚 Mata Kuliah
                        </a>

                        <a href="{{ route('dosen.index') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('dosen.*') ? 'bg-gray-200 font-semibold' : '' }}">
                            👨‍🏫 Dosen
                        </a>

                        <a href="{{ route('admin.ekyc.index') }}"
                           class="block px-4 py-2 rounded hover:bg-gray-200 transition {{ request()->routeIs('admin.ekyc.*') ? 'bg-gray-200 font-semibold' : '' }}">
                            ✅ eKYC Registration
                        </a>

                        {{-- ==== LANDING PAGE CMS GROUP ==== --}}
                        <div x-data="{ open: {{ request()->routeIs('admin.landing.*') ? 'true' : 'false' }} }"
                             class="mt-6 border-t pt-4">

                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-200 transition font-medium
                                           {{ request()->routeIs('admin.landing.*') ? 'bg-gray-200' : '' }}">
                                <span>📰 Landing Page CMS</span>
                                <svg x-show="!open" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <svg x-show="open" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition class="mt-2 pl-6 space-y-1">
                                <a href="{{ route('admin.landing.settings.index') }}"
                                   class="block px-4 py-2 rounded hover:bg-indigo-100 transition {{ request()->routeIs('admin.landing.settings.*') ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-700' }}">
                                    ⚙️ Settings
                                </a>

                                <a href="{{ route('admin.landing.navigation.index') }}"
                                   class="block px-4 py-2 rounded hover:bg-indigo-100 transition {{ request()->routeIs('admin.landing.navigation.*') ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-700' }}">
                                    📑 Menu Navigasi
                                </a>

                                <a href="{{ route('admin.landing.programs.index') }}"
                                   class="block px-4 py-2 rounded hover:bg-indigo-100 transition {{ request()->routeIs('admin.landing.programs.*') ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-700' }}">
                                    🎓 Program Studi
                                </a>

                                <a href="{{ route('admin.landing.footer.index') }}"
                                   class="block px-4 py-2 rounded hover:bg-indigo-100 transition {{ request()->routeIs('admin.landing.footer.*') ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-700' }}">
                                    📄 Footer
                                </a>

                                <a href="{{ route('admin.landing.tentang.index') }}"
                                   class="block px-4 py-2 rounded hover:bg-indigo-100 transition {{ request()->routeIs('admin.landing.tentang.*') ? 'bg-indigo-100 text-indigo-700 font-medium' : 'text-gray-700' }}">
                                    📖 Kelola Tentang
                                </a>
                            </div>
                        </div>

                    @endif
                </nav>
            </aside>

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 p-8 bg-gray-50">
                {{-- Flash Message (opsional, kalau pakai session success) --}}
                

                {{-- Konten dari child view --}}
                {{ $slot ?? '' }}
                @yield('content')
            </main>

        </div>
    </div>
</body>
</html>
