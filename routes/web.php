<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\AdminAuthController;

// ─── PUBLIC ROUTES (Free access for visitors) ──────────────────────────────
Route::get('/', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');

// ─── ADMIN AUTH ROUTES ─────────────────────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── ADMIN ONLY PROTECTED ROUTES (Requires admin.auth middleware) ──────────
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', [GuestBookController::class, 'admin'])->name('guestbook.admin');
    Route::get('/admin/history', [GuestBookController::class, 'history'])->name('guestbook.history');
    Route::get('/admin/history/export', [GuestBookController::class, 'exportHistory'])->name('guestbook.history.export');
    Route::delete('/admin/history/{guest}', [GuestBookController::class, 'destroy'])->name('guestbook.destroy');

    // Kelola Pertanyaan Form (Box Formulir)
    Route::get('/admin/questions', [GuestBookController::class, 'manageQuestions'])->name('guestbook.questions.index');
    Route::post('/admin/questions', [GuestBookController::class, 'storeQuestion'])->name('guestbook.questions.store');
    Route::put('/admin/questions/{question}', [GuestBookController::class, 'updateQuestion'])->name('guestbook.questions.update');
    Route::delete('/admin/questions/{question}', [GuestBookController::class, 'destroyQuestion'])->name('guestbook.questions.destroy');
});
