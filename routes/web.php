<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UsernameController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\CreditDebitController;
use App\Http\Controllers\EricaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrpsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.store');

    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

Route::middleware(['auth', 'username.required'])->group(function () {
    Route::get('/set-username', [UsernameController::class, 'create'])->name('username.create');
    Route::post('/set-username', [UsernameController::class, 'store'])->name('username.store');

    Route::get('/verify-email', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware(['verified', 'profile.complete'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/erica', [EricaController::class, 'index'])->name('erica.index');
        Route::post('/erica/generate', [EricaController::class, 'generate'])->name('erica.generate');

        Route::post('/bindings/credit-debit', CreditDebitController::class)->name('bindings.credit-debit');
        Route::post('/bindings/qrps', QrpsController::class)->name('bindings.qrps');
    });
});

Route::get('/docs', [DocController::class, 'index'])->name('docs.index');
Route::get('/docs/{doc}', [DocController::class, 'show'])->name('docs.show');

Route::get('/docs/category/{category:slug}', [DocController::class, 'showCategory'])
     ->name('docs.category.show');

// LAMA: Rute buat nampilin Halaman Postingan/Dokumen
Route::get('/docs/{doc:slug}', [DocController::class, 'show'])
     ->name('docs.show');
