<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LP3I - Kampus Vokasi Terbaik</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/image/landing/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <!-- NAVBAR -->
    <header class="w-full py-3.5 bg-white shadow-sm fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('storage/image/landing/logo.png') }}"
                     onerror="this.src='{{ asset('image/landing/logo.png') }}'"
                     alt="Logo LP3I"
                     class="h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-105">
                <span class="text-2xl font-extrabold text-blue-600 tracking-tight">LP3I</span>
            </a>

            <!-- Navigation Menu -->
            <nav class="hidden md:flex gap-8 text-gray-700 font-medium">
                @foreach ($navigation as $nav)
                    <a href="{{ $nav->url }}" class="hover:text-blue-600">
                        {{ $nav->label }}
                    </a>
                @endforeach
            </nav>

            <!-- Login / Dashboard Button -->
            <div class="flex gap-3">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 text-blue-600 font-semibold">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="beranda" class="pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 px-4 items-center">

            <!-- Text Content -->
            <div>
                <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-gray-900 mb-6">
                    {!! $landing['hero_title'] ?? 'Kampus Vokasi Terbaik<br />Untuk Masa Depan Karier Anda' !!}
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    {!! $landing['hero_subtitle'] ?? 'Solusi Pendidikan Masa Depan' !!}
                </p>
                <div class="flex gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold text-lg hover:bg-blue-700">
                            Daftar Sekarang
                        </a>
                    @endif
                    <a href="#program" class="px-6 py-3 border border-blue-600 text-blue-600 rounded-lg font-semibold text-lg hover:bg-blue-50">
                        Lihat Program
                    </a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="flex justify-center">
                @php
                    $heroImg = $landing['hero_image'] ?? 'uploads/landing/hero-lp3i.jpg';
                    $heroUrl = str_starts_with($heroImg, 'http')
                        ? $heroImg
                        : (str_starts_with($heroImg, 'uploads/') ? asset($heroImg) : asset('storage/' . $heroImg));
                @endphp
                <img src="{{ $heroUrl }}"
                     alt="Mahasiswa LP3I"
                     class="w-full max-w-2xl object-cover rounded-xl shadow-lg" />
            </div>
        </div>
    </section>

    <!-- PROGRAM PENDIDIKAN -->
    <section id="program" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-3xl font-bold text-gray-900 mb-10">Program Pendidikan</h3>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($programs as $program)
                    <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-lg transition">
                        @php
                            $progImg = $program->icon ?: $program->image;
                        @endphp
                        @if($progImg)
                            @php
                                $progUrl = str_starts_with($progImg, 'http')
                                    ? $progImg
                                    : (str_starts_with($progImg, 'uploads/') ? asset($progImg) : asset('storage/' . $progImg));
                            @endphp
                            <img src="{{ $progUrl }}"
                                 alt="{{ $program->title }}"
                                 class="w-16 h-16 mx-auto mb-4 object-cover rounded-lg">
                        @endif
                        <h4 class="text-xl font-semibold mb-3">{{ $program->title }}</h4>
                        <p class="text-gray-600">{{ $program->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TENTANG LP3I -->
    <section id="tentang" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-10 items-center">
            <!-- Teks Tentang -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-6">
                    {{ $tentang->judul ?? 'Tentang LP3I' }}
                </h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    {!! nl2br(e($tentang->deskripsi ?? 'LP3I adalah lembaga pendidikan vokasi yang telah berdiri lebih dari 30 tahun, berfokus pada pendidikan yang langsung terhubung dengan dunia kerja.')) !!}
                </p>
            </div>

            <!-- Gambar Tentang -->
            <div class="flex justify-center">
                @if($tentang->gambar)
                    @php
                        $tentangImg = $tentang->gambar;
                        $tentangUrl = str_starts_with($tentangImg, 'http')
                            ? $tentangImg
                            : (str_starts_with($tentangImg, 'uploads/') ? asset($tentangImg) : asset('storage/' . $tentangImg));
                    @endphp
                    <img src="{{ $tentangUrl }}"
                         alt="{{ $tentang->judul ?? 'Tentang LP3I' }}"
                         class="rounded-xl shadow-lg max-w-full h-auto object-cover" />
                @else
                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-96 h-72 flex items-center justify-center">
                        <span class="text-gray-500 text-lg">Belum ada gambar</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="kontak" class="bg-blue-600 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-10">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <img src="{{ asset('storage/image/landing/logo.png') }}"
                         onerror="this.src='{{ asset('image/landing/logo.png') }}'"
                         alt="Logo LP3I"
                         class="h-9 w-auto object-contain bg-white/10 p-1 rounded-md">
                    <h4 class="text-xl font-bold tracking-tight">LP3I</h4>
                </div>
                <p class="text-gray-100">Kampus vokasi yang mempersiapkan mahasiswa siap kerja lebih cepat.</p>
            </div>
            <div>
                <h4 class="text-xl font-semibold mb-3">Navigasi</h4>
                <ul class="space-y-2 text-gray-100">
                    @foreach ($footerNav as $itemNav)
                        <li><a href="{{ $itemNav->url }}" class="hover:underline">
                            {{ $itemNav->label }}
                        </a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-semibold mb-3">Hubungi Kami</h4>
                <p class="text-gray-100">Email: info@lp3i.ac.id</p>
                <p class="text-gray-100">Telp: (021) 12345678</p>
            </div>
        </div>

        <div class="text-center text-gray-200 mt-10 text-sm">
            {{ $landing['footer_text'] ?? '© 2025 LP3I College - All Rights Reserved' }}
        </div>
    </footer>

</body>
</html>
