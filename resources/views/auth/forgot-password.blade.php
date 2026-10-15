<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-8 sm:py-12 px-4 bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-100">
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center gap-3 group">
                <img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
                     alt="Logo LP3I"
                     class="h-14 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
            </a>
            <h2 class="mt-3 text-xl font-bold text-slate-900">Pemulihan Kata Sandi</h2>
            <p class="text-xs text-slate-500">Kirim link reset ke alamat email Anda</p>
        </div>

        <div class="w-full sm:max-w-md bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200/80">
            <div class="mb-5 text-sm text-slate-600 leading-relaxed">
                Lupa kata sandi akun Anda? Masukkan alamat email yang terdaftar dan kami akan mengirimkan link untuk mengatur ulang kata sandi baru.
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Alamat Email
                    </label>
                    <input id="email" class="block w-full py-2.5 px-3 border border-slate-300 rounded-xl text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-100" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('login') }}" class="text-xs font-medium text-slate-600 hover:text-blue-600">
                        ← Kembali ke Login
                    </a>

                    <button type="submit" class="py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-blue-500/20 transition">
                        Kirim Link Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
