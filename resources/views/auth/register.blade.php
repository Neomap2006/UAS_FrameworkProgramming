<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-8 sm:py-12 px-4 bg-gradient-to-br from-slate-50 via-blue-50/40 to-slate-100">
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center gap-3 group">
                <img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
                     alt="Logo LP3I"
                     class="h-14 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
            </a>
            <h2 class="mt-3 text-xl font-bold text-slate-900">Registrasi Akun Mahasiswa</h2>
            <p class="text-xs text-slate-500">Buat akun untuk memulai pendaftaran & portal akademik</p>
        </div>

        <div class="w-full sm:max-w-md bg-white p-8 rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200/80">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Nama Lengkap
                    </label>
                    <input id="name" class="block w-full py-2.5 px-3 border border-slate-300 rounded-xl text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-100" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Alamat Email
                    </label>
                    <input id="email" class="block w-full py-2.5 px-3 border border-slate-300 rounded-xl text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-100" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Kata Sandi
                    </label>
                    <input id="password" class="block w-full py-2.5 px-3 border border-slate-300 rounded-xl text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                        Konfirmasi Kata Sandi
                    </label>
                    <input id="password_confirmation" class="block w-full py-2.5 px-3 border border-slate-300 rounded-xl text-sm focus:border-blue-600 focus:ring-4 focus:ring-blue-100"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a class="text-xs font-medium text-blue-600 hover:text-blue-800 hover:underline" href="{{ route('login') }}">
                        Sudah punya akun? Masuk
                    </a>

                    <button type="submit" class="py-2.5 px-5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-blue-500/20 transition">
                        Daftar Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
