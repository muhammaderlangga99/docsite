<?php

use App\Http\Controllers\DocController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', [DocController::class, 'index'])->name('docs.index');
Route::get('/docs/{doc}', [DocController::class, 'show'])->name('docs.show');

Route::get('/docs/category/{category:slug}', [DocController::class, 'showCategory'])
     ->name('docs.category.show');

// LAMA: Rute buat nampilin Halaman Postingan/Dokumen
Route::get('/docs/{doc:slug}', [DocController::class, 'show'])
     ->name('docs.show');