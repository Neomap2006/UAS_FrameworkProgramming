<x-guest-layout>
    <div class="min-h-screen grid lg:grid-cols-12 bg-white selection:bg-blue-600 selection:text-white">

        {{-- ======================================================== --}}
        {{-- KOLOM KIRI: BRANDING & HERO BANNER (Desktop Only)       --}}
        {{-- ======================================================== --}}
        <div class="hidden lg:flex lg:col-span-5 xl:col-span-5 relative flex-col justify-between p-12 bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-950 text-white overflow-hidden">
            
            {{-- Decorative Ambient Glow Elements --}}
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

            {{-- Top Link: Kembali ke Beranda --}}
            <div class="relative z-10">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 text-sm font-medium text-blue-200/80 hover:text-white transition group py-1.5 px-3 rounded-lg hover:bg-white/10 backdrop-blur-xs">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            {{-- Middle: Logo, Heading & Feature Badges --}}
            <div class="relative z-10 my-auto py-8">
                {{-- Logo Container --}}
                <div class="inline-flex items-center gap-3.5 p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-xl mb-8">
                    <img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
                         alt="Logo LP3I"
                         class="h-12 w-auto object-contain">
                    <div class="pr-2">
                        <div class="text-xs uppercase tracking-widest text-blue-300 font-bold">LP3I College</div>
                        <div class="text-base font-extrabold text-white tracking-tight">Portal Akademik</div>
                    </div>
                </div>

                <h1 class="text-3xl xl:text-4xl font-extrabold tracking-tight leading-tight text-white mb-4">
                    Sistem Terpadu Akademik & eKYC Kampus
                </h1>
                <p class="text-slate-300 text-sm xl:text-base leading-relaxed mb-8">
                    Satu pintu akses terpercaya untuk mengelola perkuliahan, data mahasiswa, dosen, serta verifikasi identitas pendaftaran calon mahasiswa baru.
                </p>

                {{-- Feature Highlights --}}
                <div class="space-y-3.5">
                    <div class="flex items-center gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="w-9 h-9 rounded-lg bg-blue-500/20 text-blue-300 flex items-center justify-center font-bold shrink-0">
                            🎓
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Manajemen Akademik Terintegrasi</div>
                            <div class="text-xs text-slate-300">Pengelolaan jadwal, ruangan, matkul, dan dosen secara real-time.</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="w-9 h-9 rounded-lg bg-indigo-500/20 text-indigo-300 flex items-center justify-center font-bold shrink-0">
                            ⚡
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Verifikasi eKYC Digital</div>
                            <div class="text-xs text-slate-300">Validasi identitas pendaftar baru yang cepat, akurat, dan transparan.</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center font-bold shrink-0">
                            🛡️
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">Keamanan Akses Terjamin</div>
                            <div class="text-xs text-slate-300">Dilindungi enkripsi data modern dan autentikasi tersentralisasi.</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Footer Note --}}
            <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-400">
                <span>"Tepat & Cepat Kerja"</span>
                <span>© {{ date('Y') }} LP3I College</span>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- KOLOM KANAN: FORMULIR LOGIN                             --}}
        {{-- ======================================================== --}}
        <div class="lg:col-span-7 xl:col-span-7 flex flex-col justify-between p-6 sm:p-12 lg:p-16 bg-gradient-to-b from-slate-50/50 via-white to-slate-50/70">
            
            {{-- Mobile-only Top Bar with Back Link & Logo --}}
            <div class="flex lg:hidden items-center justify-between mb-8 pb-4 border-b border-slate-200">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
                         alt="Logo LP3I"
                         class="h-9 w-auto object-contain">
                    <span class="text-lg font-bold text-blue-600">LP3I</span>
                </a>

                <a href="{{ url('/') }}" class="text-xs font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1">
                    <span>← Ke Beranda</span>
                </a>
            </div>

            {{-- Centered Form Container --}}
            <div class="max-w-md w-full mx-auto my-auto py-6">

                {{-- Header Title --}}
                <div class="mb-8">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 mb-3 shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                        Portal Akses Masuk
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Selamat Datang Kembali
                    </h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Silakan masukkan kredensial akun Anda untuk mengakses dashboard akademik.
                    </p>
                </div>

                {{-- Session Status Notification --}}
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2.5 shadow-2xs">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                {{-- Form Login --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPass: false }">
                    @csrf

                    {{-- Field: Email Address --}}
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative rounded-xl shadow-2xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                                </svg>
                            </div>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   autocomplete="username"
                                   placeholder="nama@lp3i.ac.id"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border {{ $errors->has('email') ? 'border-rose-400 ring-2 ring-rose-100' : 'border-slate-300' }} rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                        </div>
                        @if ($errors->has('email'))
                            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('email') }}</span>
                            </p>
                        @endif
                    </div>

                    {{-- Field: Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline transition">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative rounded-xl shadow-2xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password"
                                   :type="showPass ? 'text' : 'password'"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full pl-11 pr-11 py-3 bg-white border {{ $errors->has('password') ? 'border-rose-400 ring-2 ring-rose-100' : 'border-slate-300' }} rounded-xl text-slate-800 placeholder-slate-400 text-sm focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                            
                            {{-- Toggle Show/Hide Password Button --}}
                            <button type="button"
                                    @click="showPass = !showPass"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition">
                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('password') }}</span>
                            </p>
                        @endif
                    </div>

                    {{-- Remember Me Checkbox --}}
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                            <span class="ml-2.5 text-xs sm:text-sm text-slate-600 font-medium">
                                Ingat saya di perangkat ini
                            </span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-3.5 px-4 rounded-xl font-semibold text-sm text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/35 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 group cursor-pointer">
                            <span>Masuk ke Portal</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                {{-- Registration Callout --}}
                @if (Route::has('register'))
                    <div class="mt-8 pt-6 border-t border-slate-200/80 text-center">
                        <p class="text-sm text-slate-600">
                            Calon Mahasiswa belum memiliki akun?
                        </p>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-1.5 mt-2 font-bold text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                            <span>Daftar Akun Baru Sekarang</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif

                {{-- Security Badge --}}
                <div class="mt-6 flex items-center justify-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span>Dilindungi enkripsi SSL 256-bit standar industri</span>
                </div>

            </div>

            {{-- Footer Note on Right Column --}}
            <div class="text-center text-xs text-slate-400 pt-4">
                Butuh bantuan login? Hubungi Administrator melalui <a href="mailto:info@lp3i.ac.id" class="text-blue-600 hover:underline font-medium">info@lp3i.ac.id</a>
            </div>

        </div>

    </div>
</x-guest-layout>
