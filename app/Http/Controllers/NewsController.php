<?php

namespace App\Http\Controllers;

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
        
        // Ambil berita dengan tampilan terbanyak (top views)
        $topViewsNews = News::with('category')
            ->orderByDesc('views')
            ->take(5) // Misalnya, ambil 5 berita dengan views tertinggi
            ->get();
        
        // Ambil berita terbaru (recent)
        $recentNews = News::with('category')
            ->orderByDesc('created_at')
            ->take(5) // Misalnya, ambil 5 berita terbaru
            ->get();

        // Ambil semua kategori beserta jumlah berita yang terkait
        $categories = Category::withCount('news')->get();

        // Mengembalikan view dengan data berita, kategori, top views, dan recent news
        return view('news.index', compact('news', 'categories', 'topViewsNews', 'recentNews'));
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

    // Menampilkan berita berdasarkan kategori
    public function category($slug)
{
    // Ambil kategori berdasarkan slug
    $category = Category::where('slug', $slug)->firstOrFail();

    // Ambil semua berita yang terkait dengan kategori ini
    $news = News::with('category')
        ->where('category_id', $category->id)
        ->get();

    // Ambil semua kategori untuk sidebar atau keperluan lainnya
    $categories = Category::withCount('news')->get();

    // Mengembalikan view dengan data berita dan kategori yang dipilih
    return view('news.category', compact('news', 'categories', 'category'));
}

}
