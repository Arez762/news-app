<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsItem->judul }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            margin: 40px auto;
            max-width: 1200px;
        }

        .content {
            flex: 6;
            /* 60% of the width */
            padding-right: 20px;
        }

        .empty-space {
            flex: 4;
            /* 40% of the width */
        }

        .thumbnail {
            max-width: 100%;
            height: 350px;
            width: auto;
            margin-bottom: 20px;
        }

        .title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 20px;
        }

        .meta span {
            margin-right: 15px;
        }

        .content p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #3490dc;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .back-button:hover {
            background-color: #2779bd;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- 60% Section -->
        <div class="content">
            <img src="{{ Storage::url($newsItem->thumbnail) }}" alt="{{ $newsItem->judul }}" class="thumbnail">

            <h1 class="title">{{ $newsItem->judul }}</h1>

            <div class="meta">
                <span>Kategori: {{ $newsItem->category->name }}</span>
                <span>Diunggah pada: {{ $newsItem->created_at->format('d M Y H:i') }}</span>
                <span>Views: {{ $newsItem->views }}</span> <!-- Tambahkan jumlah views di sini -->
            </div>

            <div class="content">
                <p>{{ $newsItem->content }}</p>
            </div>

            <a href="{{ route('news.index') }}" class="back-button">&larr; Kembali ke Daftar Berita</a>
            
        </div>

        <!-- 40% Empty Space -->
        <div class="empty-space"></div>
    </div>
</body>

</html>
