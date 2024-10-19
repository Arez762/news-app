<?php

namespace App\Http\Controllers;

use index;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Menampilkan daftar berita
    public function index()
    {
        // Ambil semua data berita beserta kategori
        $news = News::with('category')->get();
        // Ambil semua data pengguna
        $users = User::all();
    
        // Mengembalikan view dengan data berita dan pengguna
        return view('news.index', compact('news', 'users'));
    }
    

    // Menampilkan detail berita berdasarkan slug
    public function show($slug)
    {
        // Ambil berita berdasarkan slug
        $newsItem = News::where('slug', $slug)->with('category')->firstOrFail();

        // Inkrementasi jumlah views
        $newsItem->increment('views');

        // Mengembalikan view dengan data berita
        return view('news.show', compact('newsItem'));
    }
}
