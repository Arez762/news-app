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

        // Ambil semua berita yang sesuai dengan kata kunci pencarian
        $newsQuery = News::with('category')->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        });

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

        $recentNewsHeader = News::with('category')
            ->orderByDesc('created_at')
            ->take(12) // Ambil 5 berita terbaru
            ->get();

        // Ambil semua kategori beserta jumlah berita yang terkait
        $categories = Category::withCount('news')->get();

        // Ambil 8 berita terbaru untuk setiap kategori
        $newsByCategory = [];
        foreach ($categories as $category) {
            $newsByCategory[$category->id] = News::with('category')
                ->where('category_id', $category->id)
                ->orderByDesc('created_at')
                ->take(8) // Ambil 8 berita terbaru
                ->get();
        }

        // Mengembalikan view dengan data berita, kategori, top views, dan recent news
        return view('news.index', compact('news', 'categories', 'topViewsNews', 'recentNews', 'search', 'recentNewsHeader', 'newsByCategory'));
    }

    // Menampilkan detail berita berdasarkan slug
    public function show($slug)
    {
        // Ambil berita terbaru (recent)
        $recentNews = News::with('category')
            ->orderByDesc('created_at')
            ->take(3) // Ambil 3 berita terbaru
            ->get();
        // Ambil berita berdasarkan slug
        $newsItem = News::where('slug', $slug)->with('category')->firstOrFail();

        // Inkrementasi jumlah views
        $newsItem->increment('views');

        // Ambil semua kategori beserta jumlah berita yang terkait
        $categories = Category::withCount('news')->get();

        // Ambil 5 berita terpopuler berdasarkan jumlah views
        $popularNews = News::with('category')
            ->orderByDesc('views')
            ->take(3)
            ->get();

        // Ambil 5 berita secara random
        $randomNews = News::with('category')
            ->inRandomOrder()
            ->take(8)
            ->get();

        // Mengembalikan view dengan data berita, kategori, dan berita terpopuler
        return view('news.show', compact('newsItem', 'categories', 'popularNews', 'randomNews', 'recentNews'));
    }

    // Menampilkan berita berdasarkan kategori
    public function category(Request $request, $slug)
    {
        // Debug: Tampilkan data kategori
        
        $popularNews = News::with('category')
            ->orderByDesc('views')
            ->take(3)
            ->get();
        // Ambil kata kunci pencarian dari request
        // Ambil berita terbaru (recent)
        $recentNews = News::with('category')
            ->orderByDesc('created_at')
            ->take(3) // Ambil 3 berita terbaru
            ->get();

        $search = $request->input('search');

        // Ambil kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();
         // Ini akan menghentikan eksekusi dan menampilkan data kategori

        // Ambil semua berita yang terkait dengan kategori ini, diurutkan dari yang terbaru
        $newsQuery = News::with('category')
            ->where('category_id', $category->id)
            ->orderByDesc('created_at'); // Mengurutkan dari yang terbaru ke yang terlama

        // Jika ada kata kunci pencarian, filter berita dalam kategori tersebut
        if ($search) {
            $newsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%'); // Cari berdasarkan nama kategori
                    });
            });
        }

        $news = $newsQuery->paginate(12); // Batasi 12 berita per halaman

        // Ambil semua kategori untuk sidebar atau keperluan lainnya
        $categories = Category::withCount('news')->get();

        // Mengembalikan view dengan data berita dan kategori yang dipilih
        return view('news.category', compact('news', 'categories', 'category', 'search', 'popularNews', 'recentNews'));
    }

    public function search(Request $request)
    {
        // Ambil kata kunci pencarian dari request
        $search = $request->input('search');

        // Ambil semua berita yang sesuai dengan kata kunci pencarian
        $newsQuery = News::with('category')->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        });

        $news = $newsQuery->paginate(12); // Batasi 12 berita per halaman

        // Ambil semua kategori untuk sidebar atau keperluan lainnya
        $categories = Category::withCount('news')->get();

        $popularNews = News::with('category')
            ->orderByDesc('views')
            ->take(3)
            ->get();
        // Ambil kata kunci pencarian dari request
        // Ambil berita terbaru (recent)
        $recentNews = News::with('category')
            ->orderByDesc('created_at')
            ->take(3) // Ambil 3 berita terbaru
            ->get();

        // Mengembalikan view dengan data berita yang sesuai dengan pencarian
        return view('news.search', compact('news', 'categories', 'search', 'recentNews', 'popularNews'));
    }
}
