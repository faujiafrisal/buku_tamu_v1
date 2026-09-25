<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestBookController;

Route::get('/', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');
Route::get('/admin', [GuestBookController::class, 'admin'])->name('guestbook.admin');
Route::get('/admin/history', [GuestBookController::class, 'history'])->name('guestbook.history');
Route::delete('/admin/history/{guest}', [GuestBookController::class, 'destroy'])->name('guestbook.destroy');

// Kelola Opsi Bidang Form
Route::get('/admin/bidang', [GuestBookController::class, 'manageBidang'])->name('guestbook.bidang.index');
Route::post('/admin/bidang', [GuestBookController::class, 'storeBidang'])->name('guestbook.bidang.store');
Route::put('/admin/bidang/{bidang}', [GuestBookController::class, 'updateBidang'])->name('guestbook.bidang.update');
Route::delete('/admin/bidang/{bidang}', [GuestBookController::class, 'destroyBidang'])->name('guestbook.bidang.destroy');

// Kelola Pertanyaan Form
Route::get('/admin/questions', [GuestBookController::class, 'manageQuestions'])->name('guestbook.questions.index');
Route::post('/admin/questions', [GuestBookController::class, 'storeQuestion'])->name('guestbook.questions.store');
Route::put('/admin/questions/{question}', [GuestBookController::class, 'updateQuestion'])->name('guestbook.questions.update');
Route::delete('/admin/questions/{question}', [GuestBookController::class, 'destroyQuestion'])->name('guestbook.questions.destroy');

