@extends('layouts.app')

@section('title', 'Login Administrator - Buku Tamu MPP Kota Samarinda')

@section('content')
<div class="w-full max-w-md mx-auto">
    <!-- Main Card Container -->
    <div class="gov-card rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl p-6 sm:p-8 relative overflow-hidden transition-all">
        
        <!-- Top Accent Gradient Bar -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 via-blue-900 to-amber-500"></div>

        <!-- Header / Logo Badge -->
        <div class="text-center mb-6 pt-2">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-950 text-amber-400 shadow-lg border border-amber-500/30 mb-3">
                <i class="fa-solid fa-user-shield text-2xl"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Login Administrator
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                Buku Tamu Digital MPP Kota Samarinda
            </p>
        </div>

        <!-- Session Success Flash Alert -->
        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-bold flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-base text-emerald-500 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Session Error Flash Alert -->
        @if(session('error'))
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs font-bold flex items-center gap-2.5">
                <i class="fa-solid fa-triangle-exclamation text-base text-rose-500 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Login Errors Alert -->
        @if($errors->has('login'))
            <div class="mb-5 p-3.5 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs font-bold flex items-center gap-2.5">
                <i class="fa-solid fa-circle-xmark text-base text-rose-500 shrink-0"></i>
                <span>{{ $errors->first('login') }}</span>
            </div>
        @endif

        <!-- LOGIN FORM -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Username Input -->
            <div class="space-y-1.5">
                <label for="usernameInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                    Username Admin <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                    <input type="text" id="usernameInput" name="username" value="{{ old('username') }}" required autofocus
                        placeholder="Masukkan username..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border @error('username') border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm font-medium shadow-sm transition-all">
                </div>
                @error('username')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input with Show/Hide Toggle -->
            <div class="space-y-1.5">
                <label for="passwordInput" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                    Password Admin <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="passwordInput" name="password" required
                        placeholder="Masukkan password..."
                        class="w-full pl-10 pr-11 py-3 rounded-xl border @error('password') border-rose-500 @else border-slate-300 dark:border-slate-700 @enderror bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-800 text-sm font-medium shadow-sm transition-all">
                    
                    <!-- Toggle Password Visibility Button -->
                    <button type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors focus:outline-none"
                        title="Tampilkan / Sembunyikan Password">
                        <i class="fa-solid fa-eye text-sm" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-900 via-indigo-900 to-blue-950 hover:from-blue-800 hover:to-indigo-800 text-amber-400 font-extrabold text-sm border border-amber-500/40 shadow-xl shadow-blue-950/20 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-right-to-bracket text-amber-400"></i>
                    <span>Masuk sebagai Admin</span>
                </button>
            </div>
        </form>

        <!-- Public Guestbook Link Footer -->
        <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800 text-center">
            <a href="{{ route('guestbook.index') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Form Presensi Publik</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('toggleIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
