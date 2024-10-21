<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Menampilkan daftar berita
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // Ambil semua data berita beserta kategori, diurutkan dari yang terbaru
        // Ambil data berita dengan paginasi (12 item per halaman)
        $newsQuery = News::with('category')
            ->orderByDesc('created_at'); // Mengurutkan dari yang terbaru ke yang terlama

        // Jika ada kata kunci pencarian, filter berita
        if ($search) {
            $newsQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        }

        $news = $newsQuery->paginate(12); // Batasi 12 berita per halaman

        // Ambil berita dengan tampilan terbanyak (top views)
        $topViewsNews = News::with('category')
            ->orderByDesc('views')
            ->take(5) // Ambil 5 berita dengan views tertinggi
            ->get();

        // Ambil berita terbaru (recent)
        $recentNews = News::with('category')
            ->orderByDesc('created_at')
            ->take(5) // Ambil 5 berita terbaru
            ->get();

        // Ambil semua kategori beserta jumlah berita yang terkait
        $categories = Category::withCount('news')->get();

        // Mengembalikan view dengan data berita, kategori, top views, dan recent news
        return view('news.index', compact('news', 'categories', 'topViewsNews', 'recentNews', 'search'));
    }

    // Menampilkan detail berita berdasarkan slug
    public function show($slug)
    {
        // Ambil berita berdasarkan slug
        $newsItem = News::where('slug', $slug)->with('category')->firstOrFail();

        // Inkrementasi jumlah views
        $newsItem->increment('views');

        // Ambil semua kategori beserta jumlah berita yang terkait
        $categories = Category::withCount('news')->get();

        // Mengembalikan view dengan data berita dan kategori
        return view('news.show', compact('newsItem', 'categories'));
    }

    // Menampilkan berita berdasarkan kategori
    public function category(Request $request, $slug)
    {
        // Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // Ambil kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Ambil semua berita yang terkait dengan kategori ini, diurutkan dari yang terbaru
        $newsQuery = News::with('category')
            ->where('category_id', $category->id)
            ->orderByDesc('created_at'); // Mengurutkan dari yang terbaru ke yang terlama

        // Jika ada kata kunci pencarian, filter berita dalam kategori tersebut
        if ($search) {
            $newsQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        }

        $news = $newsQuery->paginate(12); // Batasi 12 berita per halaman

        // Ambil semua kategori untuk sidebar atau keperluan lainnya
        $categories = Category::withCount('news')->get();

        // Mengembalikan view dengan data berita dan kategori yang dipilih
        return view('news.category', compact('news', 'categories', 'category', 'search'));
    }
}
