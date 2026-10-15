<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error (jika ada validasi gagal) --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-800 border border-red-200">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6">

                    <h2 class="font-semibold text-2xl mb-6 text-gray-900">
                        Kelola Konten Tentang
                    </h2>

                    <!-- Tabel Preview Konten Tentang -->
                    <div class="mb-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gambar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        1
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                        {{ $tentang->judul ?: 'Belum ada judul' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-md">
                                        <div class="line-clamp-3">
                                            @if($tentang->deskripsi)
                                                {{ Str::limit(strip_tags($tentang->deskripsi), 150) }}
                                            @else
                                                <span class="text-gray-400 italic">Belum ada deskripsi</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($tentang->gambar)
                                            <img src="{{ str_starts_with($tentang->gambar, 'uploads/') ? asset($tentang->gambar) : asset('storage/' . $tentang->gambar) }}"
                                                alt="Gambar Tentang"
                                                class="h-16 w-16 object-cover rounded">
                                        @else
                                            <span class="text-gray-400 italic">Belum ada gambar</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Form Edit Konten Tentang -->
                    <h3 class="font-semibold text-xl mb-6 text-gray-800">
                        Edit Konten Tentang
                    </h3>

                    <form action="{{ route('admin.landing.tentang.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Judul -->
                            <div>
                                <label class="block font-medium text-sm mb-2 text-gray-700">
                                    Judul Tentang
                                </label>
                                <input type="text" name="judul"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black bg-white"
                                        value="{{ old('judul', $tentang->judul) }}" required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label class="block font-medium text-sm mb-2 text-gray-700">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="10"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black bg-white"
                                    required>{{ old('deskripsi', $tentang->deskripsi) }}</textarea>
                        </div>

                        <!-- Gambar Saat Ini -->
                        <div class="mb-6">
                            <label class="block font-medium text-sm mb-2 text-gray-700">
                                Gambar Saat Ini
                            </label>
                            @if($tentang->gambar)
                                <div class="max-w-md">
                                    <img src="{{ str_starts_with($tentang->gambar, 'uploads/') ? asset($tentang->gambar) : asset('storage/' . $tentang->gambar) }}"
                                         alt="Gambar Tentang"
                                         class="rounded-lg shadow-md max-h-96 object-cover">
                                    <p class="text-sm text-gray-600 mt-2">
                                        File: {{ basename($tentang->gambar) }}
                                    </p>
                                </div>
                            @else
                                <p class="text-gray-500 italic">
                                    Belum ada gambar yang diunggah.
                                </p>
                            @endif
                        </div>

                        <!-- Upload Gambar Baru -->
                        <div class="mb-8">
                            <label class="block font-medium text-sm mb-2 text-gray-700">
                                Ganti Gambar (opsional)
                            </label>
                            <input type="file" name="gambar" accept="image/jpeg,image/jpg,image/png"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, JPEG, PNG
                            </p>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
