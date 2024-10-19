<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Kategori: {{ $category->name }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Berita Kategori: {{ $category->name }}</h1>

        <!-- Daftar Kategori -->
        <div class="mb-4">
            <h4>Kategori Berita</h4>
            <ul class="list-group">
                @foreach($categories as $cat)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('news.category', $cat->slug) }}">
                            {{ $cat->name }}
                        </a>
                        <span class="badge badge-primary badge-pill">{{ $cat->news_count }} berita</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Daftar Berita Berdasarkan Kategori -->
        <div class="row">
            @foreach ($news as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ Storage::url($item->thumbnail) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">
                                <strong>Diunggah pada:</strong>
                                {{ \Carbon\Carbon::parse($item->upload_time)->diffForHumans() }}<br>
                                <strong>Author:</strong> {{ $item->user->name }}<br>
                                <strong>Konten:</strong> {{ Str::limit($item->content, 100) }}...
                            </p>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="/">kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
