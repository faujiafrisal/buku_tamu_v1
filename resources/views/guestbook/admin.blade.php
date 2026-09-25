@extends('layouts.app')

@section('title', 'Dashboard Visual Analytics - Buku Tamu MPP Kota Samarinda')

@section('content')
<main class="w-full max-w-6xl gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-5 sm:p-7 relative overflow-hidden transition-all">
    
    <!-- Top Accent Bar -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 via-blue-900 to-amber-500"></div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <span class="text-[10px] font-extrabold tracking-widest text-amber-500 uppercase bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20">
                Visual Analytics Administrator
            </span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-2 flex items-center gap-2">
                <i class="fa-solid fa-chart-pie text-blue-600 dark:text-blue-400"></i> Analytics Bidang & Keperluan Kunjungan
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Visualisasi distribusi bidang yang dituju dan statistik keperluan pengunjung Mal Pelayanan Publik.
            </p>
        </div>

        <!-- Navigation Tabs & Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Navigation Tabs -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-900 p-1 rounded-xl border border-slate-200 dark:border-slate-800">
                <a href="{{ route('guestbook.admin') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-900 text-amber-400 shadow-sm transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-pie text-amber-400"></i> Dashboard Analytics
                </a>
                <a href="{{ route('guestbook.history') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left"></i> Histori Kunjungan
                </a>
                <a href="{{ route('guestbook.bidang.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-sliders"></i> Opsi Bidang
                </a>
                <a href="{{ route('guestbook.questions.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-shapes"></i> Box Formulir
                </a>
            </div>

            <!-- Add Guest Action -->
            <a href="{{ route('guestbook.index') }}" class="inline-flex items-center justify-center gap-1.5 py-2 px-3.5 rounded-xl bg-blue-900/10 dark:bg-blue-950/40 hover:bg-blue-900 hover:text-amber-400 text-blue-900 dark:text-blue-300 font-bold text-xs border border-blue-800/30 transition-all cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> Presensi Baru
            </a>
        </div>
    </div>

    <!-- INSIGHTS & STATISTICAL HIGHLIGHTS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <!-- Today Visitors Card -->
        <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-950 text-white border border-blue-800/80 shadow-md">
            <div class="flex items-center justify-between text-blue-200 text-xs mb-1 font-semibold">
                <span>Presensi Hari Ini</span>
                <i class="fa-solid fa-calendar-day text-amber-400"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-400">{{ number_format($todayCount) }}</div>
            <div class="text-[11px] text-blue-300 mt-1 font-medium flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Terverifikasi hari ini
            </div>
        </div>

        <!-- Total Visitors Card -->
        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-xs mb-1 font-semibold">
                <span>Total Seluruh Kunjungan</span>
                <i class="fa-solid fa-users text-blue-600 dark:text-blue-400"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($totalCount) }}</div>
            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 font-medium">Database MPP Samarinda</div>
        </div>

        <!-- Top Bidang Card -->
        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-xs mb-1 font-semibold">
                <span>Bidang Terfavorit</span>
                <i class="fa-solid fa-building-user text-indigo-500"></i>
            </div>
            <div class="text-sm font-extrabold text-slate-900 dark:text-white truncate" title="{{ $topBidang }}">
                {{ $topBidang }}
            </div>
            <div class="text-[11px] text-indigo-600 dark:text-indigo-400 mt-1 font-semibold">
                Tujuan terbanyak dipilih
            </div>
        </div>

        <!-- Top Keperluan Card -->
        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-xs mb-1 font-semibold">
                <span>Keperluan Terbanyak</span>
                <i class="fa-solid fa-clipboard-list text-amber-500"></i>
            </div>
            <div class="text-sm font-extrabold text-slate-900 dark:text-white truncate" title="{{ $topKeperluan }}">
                {{ $topKeperluan }}
            </div>
            <div class="text-[11px] text-amber-600 dark:text-amber-400 mt-1 font-semibold">
                Layanan dominan
            </div>
        </div>
    </div>

    <!-- CHARTS GRID (2 DONUT CHARTS) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- CHART 1: DONUT CHART BIDANG YANG DITUJU -->
        <div class="p-5 rounded-2xl bg-slate-50/90 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-blue-600 dark:text-blue-400"></i> Donut Chart: Bidang yang Dituju
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Persentase pengunjung per instansi/bidang MPP</p>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 bg-blue-900/10 dark:bg-blue-950 text-blue-800 dark:text-blue-300 rounded-lg">
                        {{ count($bidangStats) }} Bidang
                    </span>
                </div>

                <!-- Canvas & Legend Layout -->
                <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4 pt-4">
                    <div class="relative w-48 h-48 mx-auto flex items-center justify-center">
                        <canvas id="bidangDonutChart"></canvas>
                    </div>

                    <!-- Breakdown Detail List -->
                    <div class="space-y-2 max-h-52 overflow-y-auto pr-1 text-xs">
                        @forelse($bidangStats as $stat)
                            @php
                                $percent = $totalCount > 0 ? round(($stat->total / $totalCount) * 100, 1) : 0;
                            @endphp
                            <div class="p-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between shadow-2xs">
                                <div class="truncate mr-2">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 truncate" title="{{ $stat->bidang_tujuan }}">
                                        {{ $stat->bidang_tujuan }}
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full mt-1 overflow-hidden">
                                        <div class="bg-blue-800 dark:bg-blue-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="font-extrabold text-slate-900 dark:text-white">{{ $stat->total }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block">({{ $percent }}%)</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data bidang.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART 2: DONUT CHART KEPERLUAN KUNJUNGAN -->
        <div class="p-5 rounded-2xl bg-slate-50/90 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-slate-800">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-donut text-amber-500"></i> Donut Chart: Keperluan Kunjungan
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Statistik keperluan / jenis layanan terbanyak</p>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-lg">
                        Top {{ count($keperluanStats) }} Keperluan
                    </span>
                </div>

                <!-- Canvas & Legend Layout -->
                <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4 pt-4">
                    <div class="relative w-48 h-48 mx-auto flex items-center justify-center">
                        <canvas id="keperluanDonutChart"></canvas>
                    </div>

                    <!-- Breakdown Detail List -->
                    <div class="space-y-2 max-h-52 overflow-y-auto pr-1 text-xs">
                        @forelse($keperluanStats as $stat)
                            @php
                                $percent = $totalCount > 0 ? round(($stat->total / $totalCount) * 100, 1) : 0;
                            @endphp
                            <div class="p-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between shadow-2xs">
                                <div class="truncate mr-2">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 truncate" title="{{ $stat->keperluan }}">
                                        {{ $stat->keperluan }}
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full mt-1 overflow-hidden">
                                        <div class="bg-amber-500 h-full rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="font-extrabold text-slate-900 dark:text-white">{{ $stat->total }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold block">({{ $percent }}%)</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic text-center py-4">Belum ada data keperluan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT VISITS WIDGET SECTION -->
    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30 p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i> Kunjungan Terakhir (5 Data Terbaru)
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Ringkasan pengunjung yang baru saja mendaftar.</p>
            </div>
            <a href="{{ route('guestbook.history') }}" class="py-2 px-4 rounded-xl bg-blue-900 hover:bg-blue-800 text-amber-400 font-bold text-xs shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                <span>Lihat Seluruh Histori</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- RECENT GUESTS TABLE -->
        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/80 shadow-sm">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-extrabold uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="py-3 px-4">Nama Lengkap</th>
                        <th scope="col" class="py-3 px-4">Asal Instansi/Perusahaan</th>
                        <th scope="col" class="py-3 px-4">Bidang / Orang Ditemui</th>
                        <th scope="col" class="py-3 px-4">Gender</th>
                        <th scope="col" class="py-3 px-4">Layanan & Keperluan</th>
                        <th scope="col" class="py-3 px-4">Waktu Presensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                    @forelse($recentGuests as $guest)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">
                            {{ $guest->nama }}
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/80 text-amber-900 dark:text-amber-300 font-semibold text-[11px] border border-amber-200/60 dark:border-amber-800/60">
                                <i class="fa-solid fa-building text-amber-600 dark:text-amber-400"></i> {{ $guest->asal_instansi ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/80 text-indigo-900 dark:text-indigo-300 font-semibold text-[11px] border border-indigo-200/60 dark:border-indigo-800/60">
                                <i class="fa-solid fa-user-gear text-indigo-600 dark:text-indigo-400"></i> {{ $guest->bidang_orang_ditemui ?? '-' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($guest->jenis_kelamin === 'Laki-Laki')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 text-[10px] font-bold">
                                    <i class="fa-solid fa-mars text-blue-600"></i> Laki-Laki
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-pink-100 dark:bg-pink-950/80 text-pink-800 dark:text-pink-300 text-[10px] font-bold">
                                    <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-400 max-w-xs truncate">
                            {{ $guest->keperluan ?? '-' }}
                        </td>
                        <td class="py-3 px-4 text-slate-500 dark:text-slate-400 text-[11px]">
                            {{ $guest->created_at->setTimezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-500 dark:text-slate-400">
                            <p class="font-bold text-xs">Belum ada data kunjungan terbaru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bidangData = @json($bidangStats);
        const keperluanData = @json($keperluanStats);

        const chartColors = [
            '#1e3a8a', // Deep Blue
            '#f59e0b', // Amber / Gold
            '#10b981', // Emerald
            '#6366f1', // Indigo
            '#ec4899', // Pink
            '#06b6d4', // Cyan
            '#8b5cf6', // Purple
            '#64748b'  // Slate
        ];

        // DONUT CHART 1: BIDANG YANG DITUJU
        const bidangCanvas = document.getElementById('bidangDonutChart');
        if (bidangCanvas && bidangData.length > 0) {
            const labels = bidangData.map(item => item.bidang_tujuan || 'Lainnya');
            const dataValues = bidangData.map(item => item.total);

            new Chart(bidangCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: chartColors.slice(0, labels.length),
                        borderWidth: 2,
                        borderColor: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${val} pengunjung (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // DONUT CHART 2: KEPERLUAN KUNJUNGAN
        const keperluanCanvas = document.getElementById('keperluanDonutChart');
        if (keperluanCanvas && keperluanData.length > 0) {
            const labels = keperluanData.map(item => item.keperluan || 'Lainnya');
            const dataValues = keperluanData.map(item => item.total);

            new Chart(keperluanCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: chartColors.slice(1, labels.length + 1),
                        borderWidth: 2,
                        borderColor: document.documentElement.classList.contains('dark') ? '#0f172a' : '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${val} presensi (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
