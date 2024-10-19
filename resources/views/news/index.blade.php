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
        <div class="row">
            @foreach ($news as $item)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ Storage::url($item->thumbnail) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">
                                <strong>Kategori:</strong> {{ $item->category->name }}<br>
                                <strong>Diunggah pada:</strong>
                                {{ \Carbon\Carbon::parse($item->upload_time)->diffForHumans() }}<br>
                                <strong>Author:</strong> {{ $item->user->name}}<br>
                                <strong>Konten:</strong> {{ Str::limit($item->content, 100) }}...<br>
                                <!-- Menampilkan jumlah views -->
                                <strong>Views:</strong> {{ $item->views }}
                            </p>
                            <a href="{{ route('news.show', $item->slug) }}" class="btn btn-primary">Baca
                                Selengkapnya</a>
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
