<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berita</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Daftar Berita</h1>
        
        <!-- Daftar Kategori -->
        <div class="mb-4">
            <h4>Kategori Berita</h4>
            <ul class="list-group">
                @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('news.category', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                        <span class="badge badge-primary badge-pill">{{ $category->news_count }} berita</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Section: Berita dengan Tampilan Terbanyak -->
        <div class="mb-4">
            <h2>Top Views</h2>
            <div class="row">
                @foreach ($topViewsNews as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ Storage::url($item->thumbnail) }}" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">
                                    <strong>Kategori:</strong> {{ $item->category->name }}<br>
                                    <strong>Views:</strong> {{ $item->views }}<br>
                                    <strong>Diunggah pada:</strong>
                                    {{ \Carbon\Carbon::parse($item->upload_time)->diffForHumans() }}
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section: Berita Terbaru -->
        <div class="mb-4">
            <h2>Recent News</h2>
            <div class="row">
                @foreach ($recentNews as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ Storage::url($item->thumbnail) }}" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">
                                    <strong>Kategori:</strong> {{ $item->category->name }}<br>
                                    <strong>Diunggah pada:</strong>
                                    {{ \Carbon\Carbon::parse($item->upload_time)->diffForHumans() }}<br>
                                    <strong>Author:</strong> {{ $item->user->name }}<br>
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            @foreach ($news as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ Storage::url($item->thumbnail) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">
                                <strong>Kategori:</strong> {{ $item->category->name }}<br>
                                <strong>Diunggah pada:</strong>
                                {{ \Carbon\Carbon::parse($item->upload_time)->diffForHumans() }}<br>
                                <strong>Author:</strong> {{ $item->user->name }}<br>
                                <strong>Konten:</strong> {{ Str::limit($item->content, 100) }}...<br>
                                <strong>Views:</strong> {{ $item->views }}
                            </p>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
