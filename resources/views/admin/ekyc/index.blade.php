<x-app-layout>
    <div class="space-y-6">
        {{-- Header Halaman --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                    <span>📋</span>
                    <span>Daftar E-KYC Calon Mahasiswa</span>
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola verifikasi identitas, data pribadi, dan dokumen calon mahasiswa baru.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-200/60 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Total: {{ $list->total() }} Pendaftar
                </span>
            </div>
        </div>

        {{-- Tabel Data E-KYC --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-slate-700 text-center">
                    <thead class="bg-slate-50/75 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 text-center w-16">No</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Nama Mahasiswa</th>
                            <th scope="col" class="py-3.5 px-4 text-center">NIK</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                            <th scope="col" class="py-3.5 px-4 text-center">Tanggal Pendaftaran</th>
                            <th scope="col" class="py-3.5 px-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($list as $i => $row)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 text-center text-slate-500 font-medium">
                                    {{ $list->firstItem() ? $list->firstItem() + $i : $i + 1 }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-800">
                                    {{ $row->user->name ?? $row->nama ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono text-slate-600 text-xs">
                                    {{ $row->nik ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @php
                                        $st = strtolower($row->status ?? 'draft');
                                    @endphp
                                    @if ($st === 'accepted' || $st === 'ekyc_selesai')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Diterima
                                        </span>
                                    @elseif ($st === 'rejected' || $st === 'ekyc_ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Ditolak
                                        </span>
                                    @elseif ($st === 'submitted')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center text-slate-500 text-xs">
                                    {{ $row->updated_at ? $row->updated_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.ekyc.show', $row->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition font-semibold text-xs border border-blue-200 shadow-xs">
                                        <span>👁️</span>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-sm font-medium">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="text-3xl">📭</span>
                                        <p>Belum ada data pendaftar E-KYC Calon Mahasiswa</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($list->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $list->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
