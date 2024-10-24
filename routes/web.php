<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// Rute untuk halaman utama yang menampilkan semua berita
Route::get('/', [NewsController::class, 'index'])->name('news.index');

// Rute untuk menampilkan detail berita berdasarkan slug
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Rute untuk menampilkan berita berdasarkan kategori
Route::get('/news/category/{slug}', [NewsController::class, 'category'])->name('news.category');

Route::get('/search', [NewsController::class, 'search'])->name('news.search');
