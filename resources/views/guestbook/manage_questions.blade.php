@extends('layouts.app')

@section('title', 'Kelola Pertanyaan Formulir - Buku Tamu MPP Kota Samarinda')

@section('content')
<main class="w-full max-w-5xl gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-5 sm:p-7 relative overflow-hidden transition-all">
    
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
                    <i class="fa-solid fa-circle-question text-amber-500"></i> Form Questions
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-2 flex items-center gap-2">
                <i class="fa-solid fa-shapes text-blue-600 dark:text-blue-400"></i> Kelola Box Formulir (Google Form Style)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Tambah, edit, atau hapus box pertanyaan pada formulir presensi pengunjung. Setiap pertanyaan akan tampil sebagai 1 box tersendiri dengan nomor urut otomatis.
            </p>
        </div>

        <!-- Navigation Tabs & Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center bg-slate-100 dark:bg-slate-900 p-1 rounded-xl border border-slate-200 dark:border-slate-800">
                <a href="{{ route('guestbook.admin') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('guestbook.history') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left"></i> Histori
                </a>
                <a href="{{ route('guestbook.questions.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-900 text-amber-400 shadow-sm transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-shapes text-amber-400"></i> Box Formulir
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

    <!-- FORM TAMBAH PERTANYAAN BARU -->
    <div class="p-5 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 mb-6 space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-blue-600 dark:text-blue-400"></i> Tambah Box Formulir Baru (Menjadi Box #{{ count($questions) + 1 }})
        </h3>

        <form action="{{ route('guestbook.questions.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <!-- Pertanyaan / Label -->
                <div class="md:col-span-8 space-y-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                        Judul Box / Pertanyaan <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-pen-nib text-sm"></i>
                        </div>
                        <input type="text" name="pertanyaan" required value="{{ old('pertanyaan') }}"
                            placeholder="Contoh: Apakah pelayanan MPP sudah memuaskan? / Asal Daerah..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border @error('pertanyaan') border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm font-medium shadow-sm">
                    </div>
                    @error('pertanyaan')<p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>@enderror
                </div>

                <!-- Tipe Input -->
                <div class="md:col-span-4 space-y-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                        Tipe Input Box <span class="text-rose-500">*</span>
                    </label>
                    <select name="tipe_input" id="addTipeInput" required onchange="handleTypeChange(this.value, 'addOpsiContainer', 'addOpsiList')"
                        class="w-full px-3 py-2.5 rounded-xl border @error('tipe_input') border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800 cursor-pointer">
                        <option value="text">Teks Singkat (Text)</option>
                        <option value="textarea">Uraian Panjang (Textarea)</option>
                        <option value="select">Pilihan Dropdown (Select)</option>
                        <option value="radio">Pilihan Ganda (Radio)</option>
                        <option value="number">Angka (Number)</option>
                    </select>
                </div>
            </div>

            <!-- OPSI INTERAKTIF BUILDER (GOOGLE FORM STYLE) -->
            <div id="addOpsiContainer" class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2.5 hidden">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-blue-900 dark:text-blue-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-amber-500"></i> Butir Pilihan Interaktif
                    </label>
                    <span class="text-[10px] text-slate-400">Klik "+ Tambah Opsi" untuk menambah opsi pilihan</span>
                </div>
                
                <div id="addOpsiList" class="space-y-2">
                    <!-- Dynamic option rows -->
                </div>

                <button type="button" onclick="addOptionRow('addOpsiList')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold text-xs border border-blue-200 dark:border-blue-800 transition-all cursor-pointer">
                    <i class="fa-solid fa-plus-circle text-xs"></i> Tambah Opsi Pilihan
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                <!-- Urutan -->
                <div class="space-y-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                        Urutan Tampilan
                    </label>
                    <input type="number" name="urutan" min="1" max="99" value="{{ old('urutan', count($questions) + 1) }}"
                        class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800">
                </div>

                <!-- Status Aktif -->
                <div class="space-y-1">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                        Status Box
                    </label>
                    <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800 cursor-pointer">
                        <option value="Aktif" {{ old('status') === 'Aktif' ? 'selected' : '' }}>Aktif (Tampil di Form)</option>
                        <option value="Nonaktif" {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                    </select>
                </div>

                <!-- Wajib Diisi Checkbox -->
                <div class="flex items-end pb-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="wajib" value="1" {{ old('wajib', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-blue-800 focus:ring-blue-800 border-slate-300 dark:border-slate-700 cursor-pointer">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Wajib Diisi</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="py-2.5 px-6 rounded-xl bg-blue-900 hover:bg-blue-800 text-amber-400 font-extrabold text-xs shadow-md border border-amber-500/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-plus"></i> Tambah Box Formulir
                </button>
            </div>
        </form>
    </div>

    <!-- TABLE DAFTAR PERTANYAAN -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-amber-500"></i> Daftar Seluruh Box Formulir ({{ count($questions) }} box)
            </h3>
            <span class="text-[11px] text-slate-400 font-medium">Setiap item tampil sebagai 1 box tersendiri di formulir</span>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 shadow-sm">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-extrabold uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="py-3.5 px-4 w-16 text-center">Nomor Box</th>
                        <th scope="col" class="py-3.5 px-4">Judul Box / Pertanyaan</th>
                        <th scope="col" class="py-3.5 px-4 w-32">Tipe Input</th>
                        <th scope="col" class="py-3.5 px-4 w-24 text-center">Wajib</th>
                        <th scope="col" class="py-3.5 px-4 w-24 text-center">Status</th>
                        <th scope="col" class="py-3.5 px-4 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                    @forelse($questions as $index => $q)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors {{ $q->system_key ? 'bg-blue-50/30 dark:bg-blue-950/10' : '' }}">
                        <td class="py-3.5 px-4 text-center font-bold">
                            @if($q->status === 'Aktif')
                                <span class="px-2.5 py-1 rounded-lg bg-blue-900 text-amber-400 font-extrabold text-[11px] shadow-sm border border-amber-500/30">
                                    Box {{ $index + 1 }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-500 text-[11px]">
                                    Box {{ $index + 1 }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $q->pertanyaan }}</span>
                                @if($q->system_key)
                                    <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 text-[10px] font-extrabold border border-blue-300 dark:border-blue-700 flex items-center gap-1">
                                        <i class="fa-solid fa-lock text-[8px]"></i> Sistem
                                    </span>
                                @endif
                            </div>
                            @if($q->opsi)
                                <div class="flex flex-wrap gap-1 mt-1.5">
                                    @foreach(array_slice(array_filter(explode("\n", trim($q->opsi))), 0, 4) as $opsiItem)
                                        @if(trim($opsiItem))
                                            <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-medium border border-slate-200 dark:border-slate-700 flex items-center gap-1">
                                                @if($q->tipe_input === 'radio')
                                                    <i class="fa-solid fa-circle-dot text-[8px] text-amber-500"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-chevron-down text-[8px] text-purple-500"></i>
                                                @endif
                                                {{ trim($opsiItem) }}
                                            </span>
                                        @endif
                                    @endforeach
                                    @php $totalOpsi = count(array_filter(explode("\n", trim($q->opsi)))); @endphp
                                    @if($totalOpsi > 4)
                                        <span class="px-2 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 text-[10px] font-medium">
                                            +{{ $totalOpsi - 4 }} lagi
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($q->tipe_input === 'text')
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 text-[11px] font-bold border border-blue-200 dark:border-blue-800">
                                    <i class="fa-solid fa-font text-[10px]"></i> Teks Singkat
                                </span>
                            @elseif($q->tipe_input === 'textarea')
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 text-[11px] font-bold border border-indigo-200 dark:border-indigo-800">
                                    <i class="fa-solid fa-paragraph text-[10px]"></i> Uraian
                                </span>
                            @elseif($q->tipe_input === 'select')
                                <span class="px-2.5 py-1 rounded-lg bg-purple-50 dark:bg-purple-950 text-purple-700 dark:text-purple-300 text-[11px] font-bold border border-purple-200 dark:border-purple-800">
                                    <i class="fa-solid fa-circle-chevron-down text-[10px]"></i> Dropdown
                                </span>
                            @elseif($q->tipe_input === 'radio')
                                <span class="px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300 text-[11px] font-bold border border-amber-200 dark:border-amber-800">
                                    <i class="fa-solid fa-circle-dot text-[10px]"></i> Radio
                                </span>
                            @elseif($q->tipe_input === 'number')
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold border border-emerald-200 dark:border-emerald-800">
                                    <i class="fa-solid fa-arrow-down-1-9 text-[10px]"></i> Angka
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @if($q->wajib)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20 text-[10px] font-bold">
                                    Wajib
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-200/60 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-medium">
                                    Opsional
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @if($q->status === 'Aktif')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20 text-[11px] font-bold">
                                    <i class="fa-solid fa-circle text-[6px]"></i> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-200/80 dark:bg-slate-700/80 text-slate-500 dark:text-slate-400 border border-slate-300/50 text-[11px] font-bold">
                                    <i class="fa-solid fa-circle text-[6px]"></i> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <button type="button" onclick="openEditBoxModal({{ json_encode($q) }})" title="Edit Pertanyaan" class="py-1.5 px-2.5 rounded-lg bg-amber-500/10 hover:bg-amber-500 text-amber-600 hover:text-white dark:text-amber-400 border border-amber-500/20 text-xs font-bold transition-all cursor-pointer mr-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            @if($q->system_key)
                                <span title="Box sistem tidak bisa dihapus" class="inline-flex py-1.5 px-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 border border-slate-200 dark:border-slate-700 text-xs cursor-not-allowed">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                            @else
                                <form action="{{ route('guestbook.questions.destroy', $q->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus box ini?');"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Box" class="py-1.5 px-2.5 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-600 hover:text-white dark:text-rose-400 border border-rose-500/20 text-xs font-bold transition-all cursor-pointer">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 dark:text-slate-400">
                            <i class="fa-solid fa-clipboard-question text-3xl mb-2 text-slate-300 dark:text-slate-600 block"></i>
                            <p class="font-bold text-sm">Belum ada box formulir.</p>
                            <p class="text-xs text-slate-400 mt-1">Gunakan form di atas untuk menambahkan box pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- EDIT BOX MODAL (Google Form Style) -->
<div id="editBoxModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-7 max-w-xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto" id="editBoxCard">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b border-slate-200 dark:border-slate-800 mb-5">
            <div>
                <div id="editBoxSystemBadge" class="hidden mb-1.5">
                    <span class="px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 text-[10px] font-extrabold border border-blue-300 dark:border-blue-700 flex items-center gap-1 w-fit">
                        <i class="fa-solid fa-lock text-[8px]"></i> Box Sistem — Judul & opsi bisa diedit
                    </span>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-amber-500"></i>
                    <span id="editBoxModalTitle">Edit Box Formulir</span>
                </h3>
            </div>
            <button onclick="closeEditBoxModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-xl font-bold w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer">&times;</button>
        </div>
        
        <form id="editBoxForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Judul Box -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-pen-nib text-blue-500 text-[10px]"></i> Judul Box / Pertanyaan <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="editBoxPertanyaan" name="pertanyaan" required
                    placeholder="Contoh: Asal Daerah Pengunjung"
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800">
            </div>

            <!-- Tipe Input + Status -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-sliders text-purple-500 text-[10px]"></i> Tipe Input <span class="text-rose-500">*</span>
                    </label>
                    <select id="editBoxTipeInput" name="tipe_input" required
                        onchange="handleTypeChange(this.value, 'editBoxOpsiContainer', 'editBoxOpsiList')"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800 cursor-pointer">
                        <option value="text">Teks Singkat (Text)</option>
                        <option value="textarea">Uraian Panjang (Textarea)</option>
                        <option value="select">Pilihan Dropdown (Select)</option>
                        <option value="radio">Pilihan Ganda (Radio)</option>
                        <option value="number">Angka (Number)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-toggle-on text-emerald-500 text-[10px]"></i> Status Box <span class="text-rose-500">*</span>
                    </label>
                    <select id="editBoxStatus" name="status" required
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800 cursor-pointer">
                        <option value="Aktif">Aktif (Tampil di Form)</option>
                        <option value="Nonaktif">Nonaktif (Sembunyikan)</option>
                    </select>
                </div>
            </div>

            <!-- OPSI INTERAKTIF BUILDER (Google Form Style) -->
            <div id="editBoxOpsiContainer" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-2.5 hidden">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-2">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-blue-900 dark:text-blue-300 flex items-center gap-1.5">
                        <i class="fa-solid fa-list-check text-amber-500"></i> Butir Pilihan Interaktif
                    </label>
                    <span class="text-[10px] text-slate-400">Klik tombol untuk menambah / hapus opsi</span>
                </div>

                <div id="editBoxOpsiList" class="space-y-2">
                    <!-- Dynamic option rows populated by JS -->
                </div>

                <button type="button" onclick="addOptionRow('editBoxOpsiList')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold text-xs border border-blue-200 dark:border-blue-800 transition-all cursor-pointer">
                    <i class="fa-solid fa-plus-circle text-xs"></i> Tambah Opsi Pilihan
                </button>
            </div>

            <!-- Urutan + Wajib -->
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-sort-numeric-up text-slate-400 text-[10px]"></i> Urutan Tampilan
                    </label>
                    <input type="number" id="editBoxUrutan" name="urutan" min="1" max="99"
                        class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800">
                </div>

                <div class="flex items-end pb-2.5">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" id="editBoxWajib" name="wajib" value="1"
                            class="w-4 h-4 rounded text-blue-800 focus:ring-blue-800 border-slate-300 dark:border-slate-700 cursor-pointer">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Wajib Diisi</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2.5 pt-3 border-t border-slate-200 dark:border-slate-800">
                <button type="button" onclick="closeEditBoxModal()"
                    class="w-1/2 py-2.5 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold rounded-xl text-xs uppercase tracking-wide cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit"
                    class="w-1/2 py-2.5 bg-blue-900 hover:bg-blue-800 text-amber-400 font-extrabold rounded-xl text-xs uppercase tracking-wide border border-amber-500/40 shadow-md cursor-pointer transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ─── Add Option Row ──────────────────────────────────────────────────────────
    function addOptionRow(listId, value = '') {
        const list = document.getElementById(listId);
        const row  = document.createElement('div');
        row.className = 'flex items-center gap-2 group';
        row.innerHTML = `
            <i class="fa-solid fa-circle-dot text-amber-400 text-[11px] flex-shrink-0"></i>
            <input type="text" name="opsi_items[]" value="${escapeHtml(value)}"
                placeholder="Ketik opsi pilihan..."
                class="flex-1 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white text-xs font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-800 placeholder-slate-400">
            <button type="button" onclick="this.closest('.group').remove()"
                class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-400 hover:text-rose-600 hover:bg-rose-100 dark:hover:bg-rose-900 border border-rose-200 dark:border-rose-800 text-xs opacity-0 group-hover:opacity-100 transition-all cursor-pointer"
                title="Hapus opsi ini">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        list.appendChild(row);
        row.querySelector('input').focus();
    }

    // HTML escape helper
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // ─── Handle Type Change ──────────────────────────────────────────────────────
    function handleTypeChange(type, containerId, listId) {
        const container = document.getElementById(containerId);
        const list      = document.getElementById(listId);

        if (type === 'select' || type === 'radio') {
            container.classList.remove('hidden');
            // Seed 2 default options if empty
            if (list.children.length === 0) {
                addOptionRow(listId, 'Opsi 1');
                addOptionRow(listId, 'Opsi 2');
            }
        } else {
            container.classList.add('hidden');
        }
    }

    // ─── Open Edit Box Modal ─────────────────────────────────────────────────────
    function openEditBoxModal(q) {
        const modal = document.getElementById('editBoxModal');
        const card  = document.getElementById('editBoxCard');
        const form  = document.getElementById('editBoxForm');
        const list  = document.getElementById('editBoxOpsiList');

        // Set form action URL
        form.action = `/admin/questions/${q.id}`;

        // Fill basic fields
        document.getElementById('editBoxPertanyaan').value  = q.pertanyaan || '';
        document.getElementById('editBoxTipeInput').value   = q.tipe_input  || 'text';
        document.getElementById('editBoxStatus').value      = q.status      || 'Aktif';
        document.getElementById('editBoxUrutan').value      = q.urutan      || 1;
        document.getElementById('editBoxWajib').checked     = Boolean(q.wajib);

        // Modal title
        document.getElementById('editBoxModalTitle').textContent = q.system_key
            ? `Edit Box — ${q.pertanyaan}`
            : 'Edit Box Formulir';

        // System badge
        const badge = document.getElementById('editBoxSystemBadge');
        if (q.system_key) {
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }

        // Populate opsi builder rows
        list.innerHTML = '';
        if (q.opsi && (q.tipe_input === 'select' || q.tipe_input === 'radio')) {
            const items = q.opsi.split('\n').map(s => s.trim()).filter(s => s.length > 0);
            items.forEach(item => addOptionRow('editBoxOpsiList', item));
        }

        // Show/hide opsi container based on type
        handleTypeChange(q.tipe_input, 'editBoxOpsiContainer', 'editBoxOpsiList');
        // Avoid re-seeding if we already loaded real options from DB
        if (q.opsi && list.children.length > 0) {
            document.getElementById('editBoxOpsiContainer').classList.remove('hidden');
        }

        // Show modal with animation
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }

    // ─── Close Edit Box Modal ────────────────────────────────────────────────────
    function closeEditBoxModal() {
        const modal = document.getElementById('editBoxModal');
        const card  = document.getElementById('editBoxCard');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }

    // Close modal when clicking backdrop
    document.getElementById('editBoxModal').addEventListener('click', function(e) {
        if (e.target === this) closeEditBoxModal();
    });

    // ─── Add Form: handle type change on page load ───────────────────────────────
    document.getElementById('addTipeInput').addEventListener('change', function() {
        handleTypeChange(this.value, 'addOpsiContainer', 'addOpsiList');
    });
</script>
@endpush

