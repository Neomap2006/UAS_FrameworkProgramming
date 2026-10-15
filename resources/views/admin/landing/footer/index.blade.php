<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Footer Links') }}
        </h2>
    </x-slot>

    <div x-data="footerPage()" class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol Tambah --}}
            <div class="mb-6">
                <button @click="openCreateModal()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Link
                </button>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="font-semibold text-lg mb-4">Daftar Footer Links</h3>

                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-2xs">
                        <table class="table-auto w-full text-left">
                            <thead class="bg-slate-100 text-slate-700 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-4 py-3 w-16 text-center">Pos</th>
                                    <th class="px-4 py-3 text-center">Label</th>
                                    <th class="px-4 py-3 text-center">URL</th>
                                    <th class="px-4 py-3 text-center w-28">Status</th>
                                    <th class="px-4 py-3 text-center w-44">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white text-slate-700 text-sm">
                                @foreach($links as $item)
                                    <tr class="hover:bg-slate-50/75 transition-colors">
                                        <td class="px-4 py-3 text-center font-semibold text-slate-700">{{ $item->position }}</td>
                                        <td class="px-4 py-3 text-center font-semibold text-slate-900">{{ $item->label }}</td>
                                        <td class="px-4 py-3 text-center font-mono text-xs text-slate-600">{{ $item->url }}</td>

                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                                {{ $item->status ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- EDIT BUTTON --}}
                                                <button @click="openEditModal({{ $item }})"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-800 border border-amber-200 transition-all duration-150 shadow-2xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>

                                                {{-- DELETE --}}
                                                <form action="{{ route('admin.landing.footer.destroy', $item->id) }}"
                                                      method="POST" class="inline-block">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Hapus link ini?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 hover:text-rose-800 border border-rose-200 transition-all duration-150 shadow-2xs">
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

        </div>

        {{-- ---------------------------------------------------- --}}
        {{-- MODAL CREATE --}}
        {{-- ---------------------------------------------------- --}}
        <div x-show="showCreate"
             x-cloak
             style="display: none;"
             class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
             x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">

                <h2 class="text-xl font-semibold mb-4">Tambah Footer Link</h2>

                <form method="POST" action="{{ route('admin.landing.footer.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1">Label</label>
                        <input type="text" name="label" class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">URL</label>
                        <input type="text" name="url" class="border-gray-300 rounded-md w-full">
                    </div>

                    <div>
                        <label class="block mb-1">Status</label>
                        <select name="status" class="border-gray-300 rounded-md w-full">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="showCreate=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>

        {{-- ---------------------------------------------------- --}}
        {{-- MODAL EDIT --}}
        {{-- ---------------------------------------------------- --}}
        <div x-show="showEdit"
             x-cloak
             style="display: none;"
             class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
             x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">

                <h2 class="text-xl font-semibold mb-4">Edit Footer Link</h2>

                <form method="POST"
                      :action="'/admin/landing/footer/' + editData.id"
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1">Label</label>
                        <input type="text"
                               name="label"
                               x-model="editData.label"
                               class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">URL</label>
                        <input type="text"
                               name="url"
                               x-model="editData.url"
                               class="border-gray-300 rounded-md w-full">
                    </div>

                    <div>
                        <label class="block mb-1">Status</label>
                        <select name="status"
                                x-model.number="editData.status"
                                class="border-gray-300 rounded-md w-full">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                                @click="showEdit=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded">
                            Batal
                        </button>

                        <button type="submit"
                                class="px-4 py-2 bg-yellow-600 text-white rounded">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- ---------------------------------------------------- --}}
    {{-- ALPINE.JS CONTROLLER --}}
    {{-- ---------------------------------------------------- --}}
    <script>
        function footerPage() {
            return {
                showCreate: false,
                showEdit: false,
                editData: {},

                openCreateModal() {
                    this.showCreate = true;
                },

                openEditModal(item) {
                    this.editData = {
                        id: item.id,
                        label: item.label,
                        url: item.url,
                        status: Number(item.status)
                    };
                    this.showEdit = true;
                }
            };
        }
    </script>

</x-app-layout>