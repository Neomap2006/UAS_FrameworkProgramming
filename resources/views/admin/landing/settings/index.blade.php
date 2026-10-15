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

                        <table class="table-auto w-full border">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-3 py-2">Key</th>
                                    <th class="px-3 py-2">Value</th>
                                    <th class="px-3 py-2 w-24">Type</th>
                                    <th class="px-3 py-2 w-24">Status</th>
                                    <th class="px-3 py-2 w-24 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($settings as $setting)
                                    <tr class="border-t">
                                        <td class="px-3 py-2 font-medium">{{ $setting->key }}</td>

                                        <td class="px-3 py-2">
                                            @if($setting->type === 'image' || $setting->key === 'hero_image')
                                                <img src="{{ str_contains($setting->value, 'uploads/') ? asset($setting->value) : asset('storage/' . $setting->value) }}" class="h-16 rounded shadow">
                                            @elseif($setting->type === 'json')
                                                <pre class="bg-gray-100 p-2 rounded text-xs">
                                                    {{ json_encode(json_decode($setting->value, true), JSON_PRETTY_PRINT) }}
                                                </pre>
                                            @else
                                                {{ Str::limit($setting->value, 60) }}
                                            @endif
                                        </td>

                                        <td class="px-3 py-2 capitalize">{{ $setting->type }}</td>

                                        <td class="px-3 py-2">
                                            <span class="{{ $setting->status ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $setting->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-2 text-center">
                                            <button
                                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                                                @click="open=true; setting={{ $setting->toJson() }}"
                                            >
                                                Edit
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

        {{-- MODAL --}}
        <div
            x-show="open"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40"
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
