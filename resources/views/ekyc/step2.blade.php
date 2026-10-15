<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h2 class="text-xl font-semibold mb-4 text-black">E-KYC - Langkah 2: Upload Dokumen</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('ekyc.step2.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-sm text-black">Foto KTP</label>
                <input type="file" name="file_ktp" accept="image/*"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-md">
                @if($data && $data->file_ktp)
                    <p class="text-sm mt-1 text-gray-500">Sudah upload: {{ basename($data->file_ktp) }}</p>
                    <img src="{{ asset('storage/'.$data->file_ktp) }}" class="h-32 rounded mt-2 border">
                @endif
            </div>

            <div>
                <label class="block font-medium text-sm text-black">Selfie dengan KTP</label>
                <input type="file" name="file_selfie" accept="image/*"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-md">
                @if($data && $data->file_selfie)
                    <p class="text-sm mt-1 text-gray-500">Sudah upload: {{ basename($data->file_selfie) }}</p>
                    <img src="{{ asset('storage/'.$data->file_selfie) }}" class="h-32 rounded mt-2 border">
                @endif
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('ekyc.step1') }}" class="text-sm text-blue-600 hover:text-black">
                    ← kembali ke Step 1
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Simpan & Lanjut Step 3 →
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
