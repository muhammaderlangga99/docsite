<?php

use App\Http\Controllers\DocController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\EricaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('login');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/erica', [EricaController::class, 'index'])->middleware('auth')->name('erica.index');
Route::post('/erica/generate', [EricaController::class, 'generate'])->middleware('auth')->name('erica.generate');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/docs', [DocController::class, 'index'])->name('docs.index');
Route::get('/docs/{doc}', [DocController::class, 'show'])->name('docs.show');

Route::get('/docs/category/{category:slug}', [DocController::class, 'showCategory'])
     ->name('docs.category.show');

// LAMA: Rute buat nampilin Halaman Postingan/Dokumen
Route::get('/docs/{doc:slug}', [DocController::class, 'show'])
     ->name('docs.show');
