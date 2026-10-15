<x-app-layout>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow mt-8">
        <h2 class="text-xl font-semibold mb-4">📋 Daftar eKYC Calon Mahasiswa</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2 text-center">#</th>
                    <th class="border p-2 text-center">Nama</th>
                    <th class="border p-2 text-center">NIK</th>
                    <th class="border p-2 text-center">Status</th>
                    <th class="border p-2 text-center">Tanggal</th>
                    <th class="border p-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list as $i => $row)
                    <tr>
                        <td class="border p-2 text-center">{{ $i + 1 }}</td>
                        <td class="border p-2 text-center font-medium">{{ $row->user->name ?? '-' }}</td>
                        <td class="border p-2 text-center font-mono">{{ $row->nik ?? '-' }}</td>
                        <td class="border p-2 text-center">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                {{ $row->status == 'ekyc_selesai' ? 'bg-green-500' : ($row->status == 'ekyc_ditolak' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ ucfirst(str_replace('_', ' ', $row->status ?? 'belum')) }}
                            </span>
                        </td>
                        <td class="border p-2 text-center">{{ $row->updated_at->format('d M Y H:i') }}</td>
                        <td class="border p-2 text-center">
                            <a href="{{ route('admin.ekyc.show', $row->id) }}" class="text-blue-600 hover:underline font-semibold">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-3 text-center text-gray-500">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $list->links() }}</div>
    </div>
</x-app-layout>
