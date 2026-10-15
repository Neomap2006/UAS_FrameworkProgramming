<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12"
         x-data="{ 
            editModalOpen: false, 
            editData: { id: '', nid: '', nama: '', alamat: '', mata_kuliah: '' }, 
            editUrl: '',
            openEditModal(item) {
                this.editData = {
                    id: item.id,
                    nid: item.nid || '',
                    nama: item.nama || '',
                    alamat: item.alamat || '',
                    mata_kuliah: item.mata_kuliah || item.mataKuliah || ''
                };
                this.editUrl = '/dosen/' + item.id;
                this.editModalOpen = true;
            }
         }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- Form Tambah Dosen --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">Tambah Dosen</h3>
                    <form method="POST" action="{{ route('dosen.store') }}" class="space-y-4">
                        @csrf
                        <input type="text" name="nid" placeholder="NID Dosen" required
                               class="border-gray-300 rounded-md w-full">
                        <input type="text" name="nama" placeholder="Nama Dosen" required
                               class="border-gray-300 rounded-md w-full">
                        <input type="text" name="alamat" placeholder="Alamat"
                               class="border-gray-300 rounded-md w-full">
                        <input type="text" name="mata_kuliah" placeholder="Mata Kuliah"
                               class="border-gray-300 rounded-md w-full">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

            {{-- List Dosen --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="font-semibold text-lg mb-4">List Dosen</h3>
                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 w-16 text-center">No</th>
                                <th class="px-4 py-2">NID</th>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Alamat</th>
                                <th class="px-4 py-2">Mata Kuliah</th>
                                <th class="px-4 py-2 w-40 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2 font-mono font-semibold text-blue-600">{{ $item->nid }}</td>
                                    <td class="border px-4 py-2 font-medium">{{ $item->nama }}</td>
                                    <td class="border px-4 py-2 text-slate-600">{{ $item->alamat ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $item->mata_kuliah ?? $item->mataKuliah ?? '-' }}</td>
                                    <td class="border px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Trigger Modal Edit --}}
                                            <button type="button"
                                                    @click="openEditModal({{ json_encode($item) }})"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-800 border border-amber-200 transition-all duration-150 shadow-2xs cursor-pointer">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span>Edit</span>
                                            </button>

                                            <form action="{{ route('dosen.destroy', $item->id) }}"
                                                  method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 hover:text-rose-800 border border-rose-200 transition-all duration-150 shadow-2xs cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- MODAL POPUP EDIT DOSEN --}}
        <div x-show="editModalOpen"
             x-cloak
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs transition-opacity"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg shadow-2xl border border-slate-100 dark:border-gray-700 overflow-hidden"
                 @click.away="editModalOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                {{-- Header Modal --}}
                <div class="px-6 py-4 border-b border-slate-100 dark:border-gray-700 flex items-center justify-between bg-slate-50/70 dark:bg-gray-800/70">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-lg">
                            ✏️
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-gray-100">Edit Data Dosen</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400">Perbarui data dosen langsung tanpa pindah halaman</p>
                        </div>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-gray-300 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Form Modal --}}
                <form method="POST" :action="editUrl" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-gray-300 mb-1.5">NID Dosen</label>
                        <input type="text" name="nid" x-model="editData.nid" required
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition"
                               placeholder="Contoh: 888">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-gray-300 mb-1.5">Nama Dosen</label>
                        <input type="text" name="nama" x-model="editData.nama" required
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition"
                               placeholder="Contoh: Anas Fajar, S.kom.">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-gray-300 mb-1.5">Alamat</label>
                        <textarea name="alamat" x-model="editData.alamat" rows="2"
                                  class="w-full px-3.5 py-2.5 text-sm border border-slate-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition"
                                  placeholder="Contoh: Karawang"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-gray-300 mb-1.5">Mata Kuliah Diampu</label>
                        <input type="text" name="mata_kuliah" x-model="editData.mata_kuliah"
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition"
                               placeholder="Contoh: Framework Programming">
                    </div>

                    {{-- Footer Modal Action --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-gray-700">
                        <button type="button" @click="editModalOpen = false"
                                class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-xl transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md shadow-blue-500/20 transition flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
