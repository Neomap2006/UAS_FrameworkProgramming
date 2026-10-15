<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Programs') }}
        </h2>
    </x-slot>

    <div x-data="programPage()" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- NOTIFIKASI SUCCESS - Hanya 1, sesuai screenshot kamu --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Add --}}
            <div class="mb-6">
                <button @click="openCreateModal()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Program
                </button>
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="font-semibold text-lg mb-4">Daftar Programs</h3>

                    <table class="table-auto w-full border">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-center w-20">Gambar</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Icon</th>
                                <th class="px-4 py-2 text-center w-24">Pos</th>
                                <th class="px-4 py-2 text-center w-24">Status</th>
                                <th class="px-4 py-2 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            @foreach($programs as $program)
                                <tr>
                                    <td class="border px-4 py-2 text-center text-white">
                                        @if($program->image)
                                            <img src="{{ str_starts_with($program->image, 'uploads/') ? asset($program->image) : asset('storage/'.$program->image) }}" class="h-12 mx-auto rounded">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-white">{{ $program->title }}</td>
                                    <td class="border px-4 py-2 text-center text-white">
                                        @if($program->icon)
                                            <img src="{{ str_starts_with($program->icon, 'uploads/') ? asset($program->icon) : asset('storage/' . $program->icon) }}"
                                                 class="h-12 mx-auto rounded shadow" alt="Icon {{ $program->title }}">
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center text-white">{{ $program->position }}</td>

                                    <td class="border px-4 py-2 text-center">
                                        <span class="px-2 py-1 rounded text-white {{ $program->status ? 'bg-green-600' : 'bg-red-600' }}">
                                            {{ $program->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <td class="border px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="openEditModal({{ $program }})"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-all shadow-2xs">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                <span>Edit</span>
                                            </button>

                                            <form action="{{ route('admin.landing.programs.destroy', $program->id) }}"
                                                  method="POST" class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Hapus program ini?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-rose-600 hover:bg-rose-700 text-white transition-all shadow-2xs">
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

        {{-- CREATE MODAL --}}
        <div x-show="showCreate"
             class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
             x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-h-screen overflow-y-auto">

                <h2 class="text-xl font-semibold mb-4">Tambah Program</h2>

                <form method="POST" action="{{ route('admin.landing.programs.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1">Title</label>
                        <input type="text" name="title" class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea name="description" class="border-gray-300 rounded-md w-full"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1">Icon</label>
                        <input type="file" name="icon" accept="image/*" class="border-gray-300 rounded-md w-full">
                    </div>

                    <div>
                        <label class="block mb-1">Position</label>
                        <input type="number" name="position" value="0" class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">Image</label>
                        <input type="file" name="image" class="border-gray-300 rounded-md w-full">
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

        {{-- EDIT MODAL --}}
        <div x-show="showEdit"
             class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
             x-transition>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96 max-h-screen overflow-y-auto">

                <h2 class="text-xl font-semibold mb-4">Edit Program</h2>

                <form method="POST"
                      :action="'/admin/landing/programs/' + editData.id"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1">Title</label>
                        <input type="text" name="title" x-model="editData.title" class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">Description</label>
                        <textarea name="description" x-model="editData.description" class="border-gray-300 rounded-md w-full"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1">Icon (ganti jika perlu)</label>
                        <input type="file" name="icon" accept="image/*" class="border-gray-300 rounded-md w-full">
                        <template x-if="editData.icon">
                            <img :src="editData.icon && editData.icon.startsWith('uploads/') ? '/' + editData.icon : '/storage/' + editData.icon" class="mt-2 h-20 rounded">
                        </template>
                    </div>

                    <div>
                        <label class="block mb-1">Position</label>
                        <input type="number" name="position" x-model="editData.position" class="border-gray-300 rounded-md w-full" required>
                    </div>

                    <div>
                        <label class="block mb-1">Image (ganti jika perlu)</label>
                        <input type="file" name="image" class="border-gray-300 rounded-md w-full">
                        <template x-if="editData.image">
                            <img :src="editData.image && editData.image.startsWith('uploads/') ? '/' + editData.image : '/storage/' + editData.image" class="mt-2 h-20 rounded">
                        </template>
                    </div>

                    <div>
                        <label class="block mb-1">Status</label>
                        <select name="status" x-model="editData.status" class="border-gray-300 rounded-md w-full">
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

    {{-- Alpine controller --}}
    <script>
        function programPage() {
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
                        title: item.title,
                        description: item.description,
                        icon: item.icon,
                        position: item.position,
                        status: item.status,
                        image: item.image ?? ''
                    };
                    this.showEdit = true;
                }
            };
        }
    </script>

</x-app-layout>
