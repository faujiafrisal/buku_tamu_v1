@extends('layouts.app')

@section('title', 'Formulir Kunjungan - MPP Kota Samarinda')

@section('content')
<main class="w-full max-w-2xl gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-5 sm:p-7 relative overflow-hidden transition-all">
    
    <!-- Top Gold Accent Decorative Line -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-900 via-amber-500 to-blue-900"></div>

    <!-- Form Title Header -->
    <div class="mb-5 pb-3 border-b border-slate-200 dark:border-slate-800">
        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
            📋 Formulir Buku Tamu Mal Pelayanan Publik (MPP)
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
           Selamat datang di Mal Pelayanan Publik Kota Samarinda. Silakan isi formulir kehadiran Anda di bawah ini.
        </p>
    </div>

    <!-- FORM BODY -->
    <form id="guestForm" action="{{ route('guestbook.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <!-- SUB-SECTION 1: DATA DIRI -->
        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <span class="w-5 h-5 rounded-full bg-blue-800 text-white flex items-center justify-center text-[10px] font-bold">1</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Identitas Pengunjung</h3>
            </div>

            <!-- Nama Lengkap Field -->
            <div class="space-y-1.5">
                <label for="namaInput" class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Nama Lengkap <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </div>
                    <input type="text" id="namaInput" name="nama" required placeholder="Masukkan nama lengkap Anda..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all shadow-sm text-sm font-medium">
                </div>
            </div>

            <!-- Jenis Kelamin Field -->
            <div class="space-y-1.5">
                <label class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Jenis Kelamin <span class="text-rose-500">*</span></span>
                </label>
                <input type="hidden" id="jkInput" name="jenis_kelamin" value="Laki-Laki">
                <div class="grid grid-cols-2 gap-3" id="jkGroup">
                    <button type="button" data-value="Laki-Laki" class="jk-btn active flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl border-2 border-blue-800 bg-blue-50 dark:bg-blue-950/80 text-blue-900 dark:text-blue-300 font-bold text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-mars text-blue-600 dark:text-blue-400 text-base"></i> Laki-Laki
                    </button>
                    <button type="button" data-value="Perempuan" class="jk-btn flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-medium text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-venus text-pink-500 text-base"></i> Perempuan
                    </button>
                </div>
            </div>
        </div>

        <!-- SUB-SECTION 2: DETAIL KUNJUNGAN -->
        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <span class="w-5 h-5 rounded-full bg-blue-800 text-white flex items-center justify-center text-[10px] font-bold">2</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Detail Kunjungan</h3>
            </div>

            <!-- Usia Range Slider Field -->
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label for="usiaSlider" class="text-xs font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                        <span>Usia Anda saat ini</span>
                    </label>
                    <div class="flex items-center gap-1.5">
                        <span id="usiaBadge" class="px-3 py-1 bg-blue-900 text-amber-400 font-extrabold text-xs rounded-lg border border-amber-500/40 shadow-sm">
                            20
                        </span>
                        <span class="text-xs text-slate-600 dark:text-slate-400 font-semibold">Tahun</span>
                    </div>
                </div>
                
                <div class="pt-2 pb-1">
                    <input type="range" id="usiaSlider" min="12" max="75" value="20" step="1">
                    <input type="hidden" id="usiaHiddenInput" name="usia" value="20">
                </div>
                
                <div class="flex justify-between text-[11px] font-semibold text-slate-400 dark:text-slate-500 px-1">
                    <span>12 Thn</span>
                    <span>25 Thn</span>
                    <span>50 Thn</span>
                    <span>75+ Thn</span>
                </div>
            </div>

            <!-- Jumlah Rombongan Pill Selector Field -->
            <div class="space-y-2 pt-1">
                <label class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Jumlah Anggota Rombongan <span class="text-rose-500">*</span></span>
                </label>

                <input type="hidden" id="jumlahOrangInput" name="jumlah_rombongan" value="1 orang">

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="pillGroup">
                    <button type="button" data-value="1 orang" class="pill-btn active flex items-center justify-center gap-2 py-3 px-3 rounded-xl border-2 border-blue-800 bg-blue-50 dark:bg-blue-950/80 text-blue-900 dark:text-blue-300 font-bold text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-user text-xs"></i> 1 orang
                    </button>
                    <button type="button" data-value="2 orang" class="pill-btn flex items-center justify-center gap-2 py-3 px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-medium text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-user-group text-xs"></i> 2 orang
                    </button>
                    <button type="button" data-value="3 orang" class="pill-btn flex items-center justify-center gap-2 py-3 px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-medium text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-users text-xs"></i> 3 orang
                    </button>
                    <button type="button" data-value="4 orang" class="pill-btn flex items-center justify-center gap-2 py-3 px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-medium text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-users-rectangle text-xs"></i> 4 orang
                    </button>
                    <button type="button" data-value="5-10 orang" class="pill-btn col-span-2 sm:col-span-1 flex items-center justify-center gap-2 py-3 px-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 font-medium text-xs sm:text-sm transition-all shadow-sm cursor-pointer">
                        <i class="fa-solid fa-people-group text-xs"></i> 5-10 orang
                    </button>
                </div>
            </div>
        </div>

        <!-- SUB-SECTION 3: LAYANAN & KEPERLUAN -->
        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <span class="w-5 h-5 rounded-full bg-blue-800 text-white flex items-center justify-center text-[10px] font-bold">3</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Layanan & Keperluan</h3>
            </div>

            <!-- Bidang yang Dituju Field -->
            <div class="space-y-1.5">
                <label for="bidangInput" class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Bidang / Instansi yang Dituju <span class="text-rose-500">*</span></span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-building-user text-sm"></i>
                    </div>
                    <select id="bidangInput" name="bidang_tujuan" required
                        class="w-full pl-10 pr-8 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all shadow-sm text-sm font-medium appearance-none">
                        <option value="" disabled selected>-- Pilih Bidang / Instansi --</option>
                        @isset($bidangs)
                            @foreach($bidangs as $b)
                                <option value="{{ $b->nama_bidang }}">{{ $b->nama_bidang }}</option>
                            @endforeach
                        @else
                            <option value="DPMPTSP (Perizinan & Penanaman Modal)">DPMPTSP (Perizinan & Penanaman Modal)</option>
                            <option value="Disdukcapil (Kependudukan & Catatan Sipil)">Disdukcapil (Kependudukan & Catatan Sipil)</option>
                            <option value="Bapenda (Pajak & Retribusi Daerah)">Bapenda (Pajak & Retribusi Daerah)</option>
                            <option value="SAMSAT (Pajak Kendaraan & STNK)">SAMSAT (Pajak Kendaraan & STNK)</option>
                            <option value="BPJS Kesehatan & Ketenagakerjaan">BPJS Kesehatan & Ketenagakerjaan</option>
                            <option value="Dinas Perhubungan (Dishub)">Dinas Perhubungan (Dishub)</option>
                            <option value="Sekretariat / Layanan Umum">Sekretariat / Layanan Umum</option>
                            <option value="Lainnya">Lainnya</option>
                        @endisset
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Keperluan Kunjungan Field -->
            <div class="space-y-1.5">
                <label for="keperluanInput" class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Keperluan Kunjungan <span class="text-rose-500">*</span></span>
                </label>
                
                <!-- Quick Pilihan Select -->
                <div class="relative mb-2">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-list-check text-sm"></i>
                    </div>
                    <select id="keperluanQuickSelect"
                        class="w-full pl-10 pr-8 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100/70 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all shadow-sm text-xs font-medium appearance-none cursor-pointer">
                        <option value="" selected>-- Pilih Templat / Kategori Keperluan --</option>
                        <option value="Konsultasi & Informasi Layanan">Konsultasi & Informasi Layanan</option>
                        <option value="Pengurusan Dokumen / Perizinan Baru">Pengurusan Dokumen / Perizinan Baru</option>
                        <option value="Perpanjangan / Pembaruan Berkas">Perpanjangan / Pembaruan Berkas</option>
                        <option value="Pengaduan / Keluhan Layanan">Pengaduan / Keluhan Layanan</option>
                        <option value="Penyerahan / Pengambilan Berkas Fisik">Penyerahan / Pengambilan Berkas Fisik</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-clipboard-list text-sm"></i>
                    </div>
                    <input type="text" id="keperluanInput" name="keperluan" required placeholder="Tuliskan detail keperluan kunjungan Anda..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all shadow-sm text-sm font-medium">
                </div>
            </div>
        </div>

        <!-- DYNAMIC FORM BOXES (GOOGLE FORM STYLE: SETIAP PERTANYAAN 1 BOX TERSENDIRI) -->
        @if(isset($questions) && $questions->count() > 0)
            @foreach($questions as $index => $q)
            <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 space-y-3 transition-all hover:border-blue-800/40">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-blue-800 text-white flex items-center justify-center text-[10px] font-bold">{{ $index + 4 }}</span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                            {{ $q->pertanyaan }}
                        </h3>
                    </div>
                    @if($q->wajib)
                        <span class="text-[10px] font-bold text-rose-500 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20">Wajib</span>
                    @else
                        <span class="text-[10px] text-slate-400 font-normal">(Opsional)</span>
                    @endif
                </div>

                <div class="pt-1">
                    @if($q->tipe_input === 'textarea')
                        <textarea id="q_{{ $q->id }}" name="jawaban[{{ $q->id }}]" rows="3" {{ $q->wajib ? 'required' : '' }} placeholder="Tuliskan jawaban Anda di sini..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 shadow-sm text-sm font-medium resize-none"></textarea>
                    @elseif($q->tipe_input === 'select')
                        <div class="relative">
                            <select id="q_{{ $q->id }}" name="jawaban[{{ $q->id }}]" {{ $q->wajib ? 'required' : '' }}
                                class="w-full pl-4 pr-8 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-800 shadow-sm text-sm font-medium appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Salah Satu Jawaban --</option>
                                @foreach($q->opsi_array as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    @elseif($q->tipe_input === 'radio')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-0.5">
                            @foreach($q->opsi_array as $optIndex => $opt)
                                <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:border-blue-800 cursor-pointer transition-all">
                                    <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $opt }}" {{ $q->wajib && $optIndex === 0 ? 'required' : '' }}
                                        class="w-4 h-4 text-blue-800 focus:ring-blue-800 border-slate-300 dark:border-slate-700">
                                    <span class="text-xs font-semibold text-slate-800 dark:text-slate-200">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($q->tipe_input === 'number')
                        <input type="number" id="q_{{ $q->id }}" name="jawaban[{{ $q->id }}]" {{ $q->wajib ? 'required' : '' }} placeholder="Masukkan angka..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 shadow-sm text-sm font-medium">
                    @else
                        <input type="text" id="q_{{ $q->id }}" name="jawaban[{{ $q->id }}]" {{ $q->wajib ? 'required' : '' }} placeholder="Tuliskan jawaban Anda di sini..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 shadow-sm text-sm font-medium">
                    @endif
                </div>
            </div>
            @endforeach
        @endif

        <!-- SUB-SECTION: KONTAK PENGUNJUNG (SELALU NOMOR TERAKHIR) -->
        <div class="p-4 rounded-2xl bg-slate-50/80 dark:bg-slate-900/40 border border-slate-200/80 dark:border-slate-800/80 space-y-3">
            <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 pb-2">
                <span class="w-5 h-5 rounded-full bg-blue-800 text-white flex items-center justify-center text-[10px] font-bold">{{ (isset($questions) ? $questions->count() : 0) + 4 }}</span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">Kontak Pengunjung</h3>
            </div>

            <!-- Kontak WhatsApp Field -->
            <div class="space-y-1.5">
                <label for="kontakInput" class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-300">
                    <span>Nomor WhatsApp Aktif <span class="text-rose-500">*</span></span>
                    <span class="text-[10px] font-normal text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                        <i class="fa-brands fa-whatsapp"></i> Database Laravel
                    </span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-phone text-sm"></i>
                    </div>
                    <input type="tel" id="kontakInput" name="no_whatsapp" required placeholder="Contoh: 081234567890"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-transparent transition-all shadow-sm text-sm font-medium">
                </div>
            </div>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="pt-2">
            <button type="submit" id="submitBtn" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-950 hover:from-blue-800 hover:to-indigo-800 text-amber-400 font-extrabold text-base border border-amber-500/40 shadow-xl shadow-blue-950/20 active:scale-[0.99] transition-all flex items-center justify-center space-x-3 group cursor-pointer">
                <i class="fa-solid fa-paper-plane text-amber-400 group-hover:scale-110 transition-transform text-sm"></i>
                <span>SIMPAN DATA KEHADIRAN</span>
                <i class="fa-solid fa-arrow-right text-xs text-amber-400 group-hover:translate-x-1 transition-transform"></i>
            </button>
        </div>
        
        <p class="text-center text-xs text-slate-500 dark:text-slate-400 pt-1 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-database text-emerald-600 dark:text-emerald-400"></i> Terintegrasi langsung dengan Database Laravel MPP Kota Samarinda
        </p>
    </form>
</main>

<!-- SUCCESS MODAL DIALOG -->
<div id="successModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full text-center shadow-2xl border-2 border-amber-500/40 transform scale-95 transition-transform duration-300" id="successCard">
        <div class="w-20 h-20 bg-gradient-to-tr from-emerald-600 to-teal-500 text-white rounded-3xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-xl shadow-emerald-600/20 border-2 border-white">
            <i class="fa-solid fa-check-double"></i>
        </div>
        
        <span class="text-[10px] font-extrabold tracking-widest text-emerald-600 dark:text-emerald-400 uppercase bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
            Presensi Terverifikasi (Laravel)
        </span>

        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mt-3 mb-2">
            Terima Kasih Atas Kunjungan Anda!
        </h3>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mb-6 leading-relaxed">
            Data presensi Anda telah tersimpan secara resmi di Database Mal Pelayanan Publik (MPP) Kota Samarinda. Selamat melanjutkan pelayanan.
        </p>
        
        <button id="closeSuccessBtn" class="w-full py-4 bg-gradient-to-r from-blue-900 to-indigo-900 text-amber-400 font-extrabold rounded-xl shadow-lg border border-amber-500/40 transition-all active:scale-95 text-sm uppercase tracking-wide cursor-pointer">
            Kembali ke Formulir
        </button>
        <p id="countdownText" class="text-xs text-amber-600 dark:text-amber-400 font-semibold mt-3 flex items-center justify-center gap-1.5">
            <i class="fa-solid fa-rotate text-xs animate-spin"></i>
            Otomatis kembali dalam <span id="countdownSec" class="font-extrabold text-sm underline">7</span> detik...
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const guestForm = document.getElementById('guestForm');
        const submitBtn = document.getElementById('submitBtn');
        const usiaSlider = document.getElementById('usiaSlider');
        const usiaBadge = document.getElementById('usiaBadge');
        const usiaHiddenInput = document.getElementById('usiaHiddenInput');
        const jkInput = document.getElementById('jkInput');
        const jkBtns = document.querySelectorAll('.jk-btn');
        const jumlahOrangInput = document.getElementById('jumlahOrangInput');
        const pillBtns = document.querySelectorAll('.pill-btn');

        const successModal = document.getElementById('successModal');
        const successCard = document.getElementById('successCard');
        const closeSuccessBtn = document.getElementById('closeSuccessBtn');
        const countdownSec = document.getElementById('countdownSec');

        let autoResetTimer = null;
        let countdownInterval = null;

        // Slider calculation
        function updateSliderProgress(val) {
            const min = usiaSlider.min || 12;
            const max = usiaSlider.max || 75;
            const percentage = ((val - min) / (max - min)) * 100;
            const isDark = document.documentElement.classList.contains('dark');
            usiaSlider.style.background = `linear-gradient(to right, #1e3a8a 0%, #1e3a8a ${percentage}%, ${isDark ? '#1e293b' : '#cbd5e1'} ${percentage}%, ${isDark ? '#1e293b' : '#cbd5e1'} 100%)`;
            usiaBadge.textContent = val;
            usiaHiddenInput.value = val;
        }

        usiaSlider.addEventListener('input', function(e) {
            updateSliderProgress(e.target.value);
        });
        updateSliderProgress(20);

        // Gender button selector
        jkBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                jkBtns.forEach(b => {
                    b.classList.remove('active', 'border-2', 'border-blue-800', 'bg-blue-50', 'dark:bg-blue-950/80', 'text-blue-900', 'dark:text-blue-300', 'font-bold');
                    b.classList.add('border', 'border-slate-300', 'dark:border-slate-700', 'bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'font-medium');
                });
                this.classList.add('active', 'border-2', 'border-blue-800', 'bg-blue-50', 'dark:bg-blue-950/80', 'text-blue-900', 'dark:text-blue-300', 'font-bold');
                this.classList.remove('border', 'border-slate-300', 'dark:border-slate-700', 'bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'font-medium');
                jkInput.value = this.getAttribute('data-value');
            });
        });

        // Group members selector
        pillBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                pillBtns.forEach(b => {
                    b.classList.remove('active', 'border-2', 'border-blue-800', 'bg-blue-50', 'dark:bg-blue-950/80', 'text-blue-900', 'dark:text-blue-300', 'font-bold');
                    b.classList.add('border', 'border-slate-300', 'dark:border-slate-700', 'bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'font-medium');
                });
                this.classList.add('active', 'border-2', 'border-blue-800', 'bg-blue-50', 'dark:bg-blue-950/80', 'text-blue-900', 'dark:text-blue-300', 'font-bold');
                this.classList.remove('border', 'border-slate-300', 'dark:border-slate-700', 'bg-white', 'dark:bg-slate-900', 'text-slate-600', 'dark:text-slate-400', 'font-medium');
                jumlahOrangInput.value = this.getAttribute('data-value');
            });
        });

        // Quick keperluan template select handler
        const keperluanQuickSelect = document.getElementById('keperluanQuickSelect');
        const keperluanInput = document.getElementById('keperluanInput');
        if (keperluanQuickSelect && keperluanInput) {
            keperluanQuickSelect.addEventListener('change', function() {
                if (this.value) {
                    keperluanInput.value = this.value;
                }
            });
        }

        // Form Submit via AJAX
        guestForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <i class="fa-solid fa-circle-notch animate-spin text-lg text-amber-400"></i>
                <span>MENYIMPAN DATA PRESENSI...</span>
            `;

            const formData = new FormData(guestForm);

            try {
                const response = await fetch(guestForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    handleFormSuccess();
                } else {
                    const errorMsg = data.message || 'Terjadi kesalahan saat menyimpan data.';
                    showToast(errorMsg, 'error');
                    resetSubmitButton();
                }
            } catch (err) {
                console.error(err);
                showToast('Gagal terhubung ke server Laravel.', 'error');
                resetSubmitButton();
            }
        });

        function resetSubmitButton() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <i class="fa-solid fa-paper-plane text-amber-400"></i>
                <span>SIMPAN DATA KEHADIRAN</span>
                <i class="fa-solid fa-arrow-right text-xs text-amber-400"></i>
            `;
        }

        function handleFormSuccess() {
            resetSubmitButton();

            // Display modal
            successModal.classList.remove('opacity-0', 'pointer-events-none');
            successModal.classList.add('opacity-100');
            successCard.classList.remove('scale-95');
            successCard.classList.add('scale-100');

            let timeLeft = 7;
            if (countdownSec) countdownSec.textContent = timeLeft;

            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                timeLeft--;
                if (countdownSec) countdownSec.textContent = Math.max(0, timeLeft);
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);

            if (autoResetTimer) clearTimeout(autoResetTimer);
            autoResetTimer = setTimeout(() => {
                resetAndReturnToForm();
            }, 7000);
        }

        function resetAndReturnToForm() {
            if (autoResetTimer) clearTimeout(autoResetTimer);
            if (countdownInterval) clearInterval(countdownInterval);

            successModal.classList.remove('opacity-100');
            successModal.classList.add('opacity-0', 'pointer-events-none');
            successCard.classList.remove('scale-100');
            successCard.classList.add('scale-95');
            
            guestForm.reset();
            updateSliderProgress(20);
            
            if (pillBtns.length > 0) pillBtns[0].click();
            if (jkBtns.length > 0) jkBtns[0].click();

            window.scrollTo({ top: 0, behavior: 'smooth' });
            showToast('Presensi tersimpan! Formulir siap untuk pengunjung berikutnya.', 'success');
        }

        closeSuccessBtn.addEventListener('click', function() {
            resetAndReturnToForm();
        });
    });
</script>
@endpush
