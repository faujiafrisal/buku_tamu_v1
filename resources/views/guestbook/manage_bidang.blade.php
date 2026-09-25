@extends('layouts.app')

@section('title', 'Kelola Opsi Form Bidang - Buku Tamu MPP Kota Samarinda')

@section('content')
<main class="w-full max-w-4xl gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-5 sm:p-7 relative overflow-hidden transition-all">
    
    <!-- Top Accent Bar -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 via-blue-900 to-amber-500"></div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-widest text-amber-500 uppercase bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20">
                    Pengaturan Formulir
                </span>
                <span class="text-xs text-slate-400 dark:text-slate-500">•</span>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-1">
                    <i class="fa-solid fa-sliders text-amber-500"></i> Dynamic Options
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-2 flex items-center gap-2">
                <i class="fa-solid fa-building-circle-check text-blue-600 dark:text-blue-400"></i> Kelola Opsi Bidang yang Dituju
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Tambah atau hapus pilihan bidang / instansi yang muncul di formulir kunjungan pengunjung secara langsung.
            </p>
        </div>

        <!-- Navigation Tabs & Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Navigation Tabs -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-900 p-1 rounded-xl border border-slate-200 dark:border-slate-800">
                <a href="{{ route('guestbook.admin') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('guestbook.history') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left"></i> Histori
                </a>
                <a href="{{ route('guestbook.bidang.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-900 text-amber-400 shadow-sm transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders text-amber-400"></i> Opsi Bidang
                </a>
                <a href="{{ route('guestbook.questions.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-shapes"></i> Box Formulir
                </a>
            </div>

            <!-- Form Presensi Link -->
            <a href="{{ route('guestbook.index') }}" class="inline-flex items-center justify-center gap-1.5 py-2 px-3.5 rounded-xl bg-blue-900/10 dark:bg-blue-950/40 hover:bg-blue-900 hover:text-amber-400 text-blue-900 dark:text-blue-300 font-bold text-xs border border-blue-800/30 transition-all cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> Presensi
            </a>
        </div>
    </div>

    <!-- FLASH SUCCESS ALERT -->
    @if(session('success'))
        <div class="mb-5 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- FORM TAMBAH OPSI BIDANG BARU -->
    <div class="p-5 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 mb-6 space-y-3">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-blue-600 dark:text-blue-400"></i> Tambah Opsi Bidang / Instansi Baru
        </h3>

        <form action="{{ route('guestbook.bidang.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-building-user text-sm"></i>
                </div>
                <input type="text" name="nama_bidang" required value="{{ old('nama_bidang') }}" placeholder="Contoh: Dinas Kesehatan, Samsat Keliling, BPJS TK..."
                    class="w-full pl-10 pr-4 py-3 rounded-xl border @error('nama_bidang') border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm font-medium shadow-sm">
            </div>

            <button type="submit" class="py-3 px-6 rounded-xl bg-blue-900 hover:bg-blue-800 text-amber-400 font-extrabold text-xs shadow-md border border-amber-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                <i class="fa-solid fa-plus"></i> Tambah Opsi
            </button>
        </form>

        @error('nama_bidang')
            <p class="text-xs text-rose-500 font-semibold mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- TABLE DAFTAR OPSI BIDANG -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-amber-500"></i> Daftar Opsi Bidang Aktif ({{ count($bidangs) }})
            </h3>
            <span class="text-[11px] text-slate-400 font-medium">Opsi ini otomatis muncul di formulir kunjungan</span>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 shadow-sm">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-extrabold uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 w-12">#</th>
                        <th scope="col" class="py-3.5 px-4">Nama Bidang / Instansi</th>
                        <th scope="col" class="py-3.5 px-4 w-44">Tanggal Dibuat</th>
                        <th scope="col" class="py-3.5 px-4 w-24 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                    @forelse($bidangs as $index => $b)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-3.5 px-4 font-bold text-slate-400">
                            {{ $index + 1 }}
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-900 dark:text-indigo-300 text-xs border border-indigo-200/60 dark:border-indigo-800/60">
                                <i class="fa-solid fa-building-user text-indigo-600 dark:text-indigo-400"></i> {{ $b->nama_bidang }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400 text-[11px]">
                            {{ $b->created_at ? $b->created_at->setTimezone('Asia/Makassar')->format('d M Y, H:i') : '-' }} WITA
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <button type="button" onclick="openEditModal({{ $b->id }}, '{{ addslashes($b->nama_bidang) }}')" title="Edit Nama Bidang" class="py-1.5 px-2.5 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-600 hover:text-white dark:text-amber-400 border border-amber-500/20 text-xs font-bold transition-all cursor-pointer mr-1">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            <form action="{{ route('guestbook.bidang.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus opsi bidang {{ addslashes($b->nama_bidang) }}?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Opsi Bidang" class="py-1.5 px-2.5 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-600 hover:text-white dark:text-rose-400 border border-rose-500/20 text-xs font-bold transition-all cursor-pointer">
                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300 dark:text-slate-600"></i>
                            <p class="font-bold text-sm">Belum ada opsi bidang yang tersimpan.</p>
                            <p class="text-xs text-slate-400">Gunakan form di atas untuk menambahkan opsi bidang pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- EDIT MODAL DIALOG -->
<div id="editModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 dark:border-slate-800 transform scale-95 transition-transform duration-300" id="editCard">
        <div class="flex justify-between items-center pb-3 border-b border-slate-200 dark:border-slate-800 mb-4">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Edit Opsi Bidang
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-lg font-bold">&times;</button>
        </div>
        
        <form id="editForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="space-y-1.5">
                <label for="editNamaBidang" class="text-xs font-bold text-slate-700 dark:text-slate-300">
                    Nama Bidang / Instansi <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-building-user text-sm"></i>
                    </div>
                    <input type="text" id="editNamaBidang" name="nama_bidang" required placeholder="Nama bidang..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm font-medium shadow-sm">
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="button" onclick="closeEditModal()" class="w-1/2 py-3 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-xs uppercase tracking-wide cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-1/2 py-3 bg-blue-900 hover:bg-blue-800 text-amber-400 font-extrabold rounded-xl text-xs uppercase tracking-wide border border-amber-500/40 shadow-md cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(id, currentName) {
        const modal = document.getElementById('editModal');
        const card = document.getElementById('editCard');
        const form = document.getElementById('editForm');
        const input = document.getElementById('editNamaBidang');

        form.action = `/admin/bidang/${id}`;
        input.value = currentName;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
        
        setTimeout(() => input.focus(), 150);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const card = document.getElementById('editCard');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
</script>
@endpush
