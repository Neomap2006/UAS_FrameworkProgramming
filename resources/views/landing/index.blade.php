<x-app-layout>

    {{-- Header Title (opsional, kalau mau ada judul di atas konten) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beranda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi Success - Mirip screenshot kamu (e-KYC Selesai) --}}
            @if(session('success'))
                <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-8 text-center border border-green-200">
                    <p class="text-xl font-semibold mb-4 text-green-700">
                        <svg class="w-8 h-8 inline-block mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- HERO SECTION --}}
            <section id="beranda" class="pt-8 pb-20 bg-gray-50 rounded-lg">
                <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 px-6 items-center">

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

                    <div class="flex justify-center">
                        <img src="{{ asset($landing['hero_image'] ?? 'uploads/landing/hero-lp3i.jpg') }}"
                             alt="Mahasiswa LP3I"
                             class="w-full max-w-2xl object-cover rounded-xl shadow-lg" />
                    </div>
                </div>
            </section>

            {{-- PROGRAM PENDIDIKAN --}}
            <section id="program" class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-6 text-center">
                    <h3 class="text-3xl font-bold text-gray-900 mb-10">Program Pendidikan</h3>

                    <div class="grid md:grid-cols-3 gap-8">
                        @foreach($programs as $program)
                            <div class="bg-gray-50 p-8 rounded-xl shadow-sm hover:shadow-lg transition">
                                @if($program->image)
                                    <img src="{{ asset('storage/'.$program->image) }}"
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

            {{-- TENTANG LP3I --}}
            <section id="tentang" class="py-20 bg-gray-50">
                <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">
                            {{ $tentang->judul ?? 'Tentang LP3I' }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            {!! nl2br(e($tentang->deskripsi ?? 'LP3I adalah lembaga pendidikan vokasi yang telah berdiri lebih dari 30 tahun, berfokus pada pendidikan yang langsung terhubung dengan dunia kerja.')) !!}
                        </p>
                    </div>

                    <div class="flex justify-center">
                        @if($tentang->gambar)
                            <img src="{{ asset($tentang->gambar) }}"
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

            {{-- FOOTER --}}
            <footer id="kontak" class="bg-blue-600 text-white py-10">
                <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10">
                    <div>
                        <h4 class="text-xl font-semibold mb-3">LP3I</h4>
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

        </div>
    </div>

</x-app-layout>
