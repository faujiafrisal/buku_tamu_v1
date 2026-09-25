@extends('layouts.app')

@section('title', 'Histori Kunjungan - Buku Tamu MPP Kota Samarinda')

@section('content')
<main class="w-full max-w-6xl gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-5 sm:p-7 relative overflow-hidden transition-all">
    
    <!-- Top Accent Bar -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 via-blue-900 to-amber-500"></div>

    <!-- Header & Navigation Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-extrabold tracking-widest text-amber-500 uppercase bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20">
                    Buku Tamu Digital
                </span>
                <span class="text-xs text-slate-400 dark:text-slate-500">•</span>
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-1">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Data Histori
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-2 flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-blue-600 dark:text-blue-400"></i> Histori Kunjungan Pengunjung
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Daftar rekaman riwayat kehadiran seluruh pengunjung Mal Pelayanan Publik Kota Samarinda.
            </p>
        </div>

        <!-- Navigation Tabs & Action -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Navigation Tabs -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-900 p-1 rounded-xl border border-slate-200 dark:border-slate-800">
                <a href="{{ route('guestbook.admin') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('guestbook.history') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-900 text-amber-400 shadow-sm transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-list text-amber-400"></i> Histori
                </a>
                <a href="{{ route('guestbook.bidang.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders"></i> Opsi Bidang
                </a>
                <a href="{{ route('guestbook.questions.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-shapes"></i> Box Formulir
                </a>
            </div>

            <!-- Form Presensi Link -->
            <a href="{{ route('guestbook.index') }}" class="inline-flex items-center justify-center gap-1.5 py-2 px-3.5 rounded-xl bg-blue-900/10 dark:bg-blue-950/40 hover:bg-blue-900 hover:text-amber-400 text-blue-900 dark:text-blue-300 font-bold text-xs border border-blue-800/30 transition-all cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> Presensi Baru
            </a>
        </div>
    </div>

    <!-- QUICK STATS BANNER & SEARCH BAR -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Stats Summary Mini Card 1 -->
        <div class="p-3.5 rounded-2xl bg-slate-100/80 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-900/10 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div>
                    <div class="text-[11px] text-slate-500 dark:text-slate-400 font-semibold">Total Seluruh Histori</div>
                    <div class="text-lg font-extrabold text-slate-900 dark:text-white">{{ number_format($totalCount) }} Data</div>
                </div>
            </div>
        </div>

        <!-- Stats Summary Mini Card 2 -->
        <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div>
                    <div class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold">Kunjungan Hari Ini</div>
                    <div class="text-lg font-extrabold text-amber-600 dark:text-amber-400">{{ number_format($todayCount) }} Pengunjung</div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="flex items-center">
            <form method="GET" action="{{ route('guestbook.history') }}" class="w-full flex gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, WA, bidang, keperluan..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-xs font-medium shadow-sm">
                </div>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-blue-900 text-amber-400 font-bold text-xs shadow-sm hover:bg-blue-800 transition-all flex items-center justify-center gap-1 cursor-pointer">
                    <i class="fa-solid fa-filter"></i> Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('guestbook.history') }}" class="py-2.5 px-3 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium text-xs hover:bg-slate-300 dark:hover:bg-slate-700 transition-all text-center flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- DATA HISTORI TABLE -->
    <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 shadow-sm mb-4">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-extrabold uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                <tr>
                    <th scope="col" class="py-3.5 px-4">#</th>
                    <th scope="col" class="py-3.5 px-4">Nama Lengkap</th>
                    <th scope="col" class="py-3.5 px-4">Gender</th>
                    <th scope="col" class="py-3.5 px-4">Usia</th>
                    <th scope="col" class="py-3.5 px-4">Rombongan</th>
                    <th scope="col" class="py-3.5 px-4">Bidang Tujuan</th>
                    <th scope="col" class="py-3.5 px-4">Keperluan Kunjungan</th>
                    <th scope="col" class="py-3.5 px-4">No WhatsApp</th>
                    <th scope="col" class="py-3.5 px-4">Waktu Presensi (WITA)</th>
                    <th scope="col" class="py-3.5 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                @forelse($guests as $index => $guest)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                    <td class="py-3.5 px-4 font-bold text-slate-400">
                        {{ $guests->firstItem() + $index }}
                    </td>
                    <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                        {{ $guest->nama }}
                    </td>
                    <td class="py-3.5 px-4">
                        @if($guest->jenis_kelamin === 'Laki-Laki')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 text-[11px] font-bold">
                                <i class="fa-solid fa-mars text-blue-600"></i> Laki-Laki
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-pink-100 dark:bg-pink-950/80 text-pink-800 dark:text-pink-300 text-[11px] font-bold">
                                <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                            </span>
                        @endif
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold text-[11px]">
                            {{ $guest->usia }} Thn
                        </span>
                    </td>
                    <td class="py-3.5 px-4">
                        <span class="text-slate-600 dark:text-slate-400 font-semibold">
                            <i class="fa-solid fa-user-group text-[10px] mr-1 text-amber-500"></i> {{ $guest->jumlah_rombongan }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4 font-medium text-slate-800 dark:text-slate-200">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-900 dark:text-indigo-300 font-semibold text-[11px] border border-indigo-200/60 dark:border-indigo-800/60">
                            <i class="fa-solid fa-building-user text-indigo-600 dark:text-indigo-400"></i> {{ $guest->bidang_tujuan ?? '-' }}
                        </span>
                    </td>
                    <td class="py-3.5 px-4 text-slate-700 dark:text-slate-300 max-w-xs">
                        <span class="line-clamp-2 font-medium" title="{{ $guest->keperluan }}">
                            {{ $guest->keperluan ?? '-' }}
                        </span>
                        @if(!empty($guest->jawaban_tambahan))
                            <div class="mt-1 flex flex-wrap gap-1">
                                @foreach($guest->jawaban_tambahan as $ans)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-amber-500/10 text-amber-700 dark:text-amber-300 text-[10px] font-medium border border-amber-500/20" title="{{ $ans['pertanyaan'] ?? '' }}: {{ $ans['jawaban'] ?? '' }}">
                                        <i class="fa-solid fa-comment-dots text-[9px] text-amber-500"></i> {{ Str::limit($ans['pertanyaan'] ?? '', 18) }}: <strong class="font-bold">{{ Str::limit($ans['jawaban'] ?? '', 18) }}</strong>
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="py-3.5 px-4 font-mono">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->no_whatsapp) }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-sm"></i> {{ $guest->no_whatsapp }}
                        </a>
                    </td>
                    <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400 text-[11px]">
                        {{ $guest->created_at->setTimezone('Asia/Makassar')->format('d M Y, H:i:s') }} WITA
                    </td>
                    <td class="py-3.5 px-4 text-center">
                        <form action="{{ route('guestbook.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi {{ $guest->nama }}?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus Data Pengunjung" class="py-1.5 px-2.5 rounded-lg bg-rose-500/10 hover:bg-rose-600 text-rose-600 hover:text-white dark:text-rose-400 border border-rose-500/20 text-xs font-bold transition-all cursor-pointer">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-12 text-center text-slate-500 dark:text-slate-400">
                        <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
                        <p class="font-bold text-sm">Tidak ada data histori kunjungan.</p>
                        <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau tambahkan data presensi baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $guests->links() }}
    </div>
</main>
@endsection
