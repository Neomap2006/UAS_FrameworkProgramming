<x-app-layout>

    <div x-data="{ open:false, setting:null }">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Landing Page Settings
            </h2>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="mb-4 p-4 rounded bg-green-200 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">Landing Settings</h3>

                            {{-- **Tambah Button** --}}
                            <button
                                @click="setting={key:'',value:'',type:'text',status:1}; open=true"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            >
                                + Tambah Setting
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-2xs">
                            <table class="table-auto w-full text-left">
                                <thead class="bg-slate-100 text-slate-700 text-xs uppercase font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 text-center">Key</th>
                                        <th class="px-4 py-3 text-center">Value</th>
                                        <th class="px-4 py-3 w-28 text-center">Type</th>
                                        <th class="px-4 py-3 w-28 text-center">Status</th>
                                        <th class="px-4 py-3 w-28 text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-100 bg-white text-slate-700 text-sm">
                                    @foreach($settings as $setting)
                                        <tr class="hover:bg-slate-50/75 transition-colors">
                                            <td class="px-4 py-3 text-center font-semibold text-slate-900">{{ $setting->key }}</td>

                                            <td class="px-4 py-3 text-center text-slate-600">
                                                @if($setting->type === 'image' || $setting->key === 'hero_image')
                                                    <img src="{{ str_contains($setting->value, 'uploads/') ? asset($setting->value) : asset('storage/' . $setting->value) }}" class="h-14 rounded-lg shadow-xs border border-slate-200">
                                                @elseif($setting->type === 'json')
                                                    <pre class="bg-slate-50 p-2.5 rounded-lg text-xs text-slate-800 border border-slate-200 font-mono">
{{ json_encode(json_decode($setting->value, true), JSON_PRETTY_PRINT) }}
                                                    </pre>
                                                @else
                                                    {{ Str::limit($setting->value, 60) }}
                                                @endif
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200 capitalize">
                                                    {{ $setting->type }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $setting->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                                    {{ $setting->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 text-center">
                                                <button
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-800 border border-amber-200 transition-all duration-150 shadow-2xs"
                                                    @click="open=true; setting={{ $setting->toJson() }}"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL --}}
        <div
            x-show="open"
            x-cloak
            style="display: none;"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
            x-transition >
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md shadow-2xl" @click.away="open=false">


                <h2 class="text-xl font-semibold mb-4"
                    x-text="setting.id ? 'Edit Setting' : 'Tambah Setting'"></h2>

                <form method="POST" :action="setting.id ? '/admin/landing/settings/' + setting.id : '{{ route('admin.landing.settings.store') }}'"
                      enctype="multipart/form-data">

                    @csrf
                    <template x-if="setting.id">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Key</label>
                        <input type="text" name="key"
                               class="w-full border rounded px-3 py-2"
                               x-model="setting.key">
                    </div>

                    <!-- ====== -->

                    <div class="mb-4">
                        <label class="block font-medium mb-2">Tipe</label>

                        <div class="flex gap-5">

                            <!-- RADIO TEXT -->
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="type" value="text"
                                    x-model="setting.type"
                                    class="peer hidden">
                                <div class="border rounded p-3 w-28 text-center peer-checked:border-blue-500">
                                    📌
                                    <span class="text-sm font-semibold">Text</span>
                                </div>
                            </label>

                            <!-- RADIO IMAGE -->
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="type" value="image"
                                    x-model="setting.type"
                                    class="peer hidden">
                                <div class="border rounded p-3 w-28 text-center peer-checked:border-blue-500">
                                    📌
                                    <span class="text-sm font-semibold">Image</span>
                                </div>
                            </label>

                            <!-- RADIO CTA (opsional) -->
                            <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="type" value="cta"
                                    x-model="setting.type"
                                    class="peer hidden">
                                <div class="border rounded p-3 w-28 text-center peer-checked:border-blue-500">
                                    📌
                                    <span class="text-sm font-semibold">CTA</span>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- ===== -->
                    <template x-if="setting.type === 'image'">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Upload Image</label>
                            <input type="file" name="value" class="w-full border rounded px-3 py-2">

                            <div class="mt-3" x-show="setting.value">
                                <img :src="setting.value.includes('uploads/') ? '/uploads/landing/' + setting.value.split('/').pop() : '/storage/' + setting.value" class="h-24 rounded shadow">
                            </div>
                        </div>
                    </template>

                    <template x-if="setting.type !== 'image'">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Value</label>
                            <textarea name="value" rows="5"
                                class="w-full border rounded px-3 py-2"
                                x-text="setting.value"></textarea>
                        </div>
                    </template>
                    <input type="hidden" name="status" value=0>
                    <div class="flex justify-end gap-3 mt-5">
                        <button type="button" @click="open=false"
                                class="px-4 py-2 bg-gray-500 text-white rounded">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</x-app-layout>
