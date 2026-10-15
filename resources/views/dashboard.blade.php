<x-app-layout>
    <div class="space-y-6">

        {{-- WELCOME HERO CARD --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 p-8 text-white shadow-md">
            {{-- Background decorative shapes --}}
            <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-32 -top-12 w-48 h-48 rounded-full bg-blue-500/20 blur-xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-xs text-xs font-semibold mb-3">
                        <span>🎓</span>
                        <span>LP3I College - Dashboard Administrator</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">
                        Selamat Datang kembali, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="mt-2 text-blue-100 max-w-xl text-sm md:text-base leading-relaxed">
                        Kelola data akademik kampus, verifikasi pendaftaran calon mahasiswa (eKYC), serta perbarui konten landing page secara terpusat di sini.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-blue-700 font-semibold text-sm hover:bg-blue-50 transition shadow-sm">
                        <span>Lihat Landing Page</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- STATISTIC CARDS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- 1. MAHASISWA --}}
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Mahasiswa</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMahasiswa ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                        👥
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Data mahasiswa aktif</span>
                    <a href="{{ route('mahasiswa.index') }}" class="font-semibold text-blue-600 hover:text-blue-700">Kelola ➔</a>
                </div>
            </div>

            {{-- 2. DOSEN --}}
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Dosen Pengajar</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalDosen ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl">
                        👨‍🏫
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Staf pengajar aktif</span>
                    <a href="{{ route('dosen.index') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Kelola ➔</a>
                </div>
            </div>

            {{-- 3. MATA KULIAH --}}
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mata Kuliah</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalMatkul ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-2xl">
                        📚
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Kurikulum & SKS</span>
                    <a href="{{ route('matkul.index') }}" class="font-semibold text-violet-600 hover:text-violet-700">Kelola ➔</a>
                </div>
            </div>

            {{-- 4. eKYC REGISTRASI --}}
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendaftar E-KYC</p>
                        <div class="flex items-baseline gap-2 mt-1">
                            <h3 class="text-2xl font-bold text-slate-800">{{ $totalEkyc ?? 0 }}</h3>
                            @if(isset($pendingEkyc) && $pendingEkyc > 0)
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                    {{ $pendingEkyc }} Pending
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                        ✅
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500">Verifikasi berkas</span>
                    <a href="{{ route('admin.ekyc.index') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">Verifikasi ➔</a>
                </div>
            </div>

        </div>

        {{-- QUICK ACTIONS & SHORTCUTS --}}
        <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-xs">
            <h3 class="font-bold text-base text-slate-800 mb-4 flex items-center gap-2">
                <span>⚡</span>
                <span>Menu Pintas Operasional</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('mahasiswa.index') }}"
                   class="group p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-blue-50 hover:border-blue-200 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            👥
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-blue-700">Data Mahasiswa</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Tambah & atur kelas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.ekyc.index') }}"
                   class="group p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-emerald-50 hover:border-emerald-200 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            📋
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-emerald-700">Verifikasi E-KYC</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Approve atau reject berkas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.landing.programs.index') }}"
                   class="group p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            🎓
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-indigo-700">Program Studi</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Update jurusan & banner</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.landing.settings.index') }}"
                   class="group p-4 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-amber-50 hover:border-amber-200 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            ⚙️
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-slate-800 group-hover:text-amber-700">CMS Landing Page</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Atur judul, info & footer</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
