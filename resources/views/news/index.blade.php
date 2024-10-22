<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Berita</title>
    <!-- Styles -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Import Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lazysizes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .lazyload {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .lazyloaded {
            opacity: 1;
        }

        .loading-placeholder {
            background: #f0f0f0;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
</head>

<body class="bg-[#F3F4F8] font-sans">
    <x-navbar></x-navbar>

    <section class="w-full lg:px-32">
        <!-- hero big grid -->
        <div class="my-4 lg:pl-4 pl-3 lg:pt-36 pt-24">
            <p class="text-lg lg:mb-2 lg:text-3xl font-bold">Berita Terpopuler</p>
            <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
        </div>
        <div class=" rounded-xl lg:mb-10 pb-4">
            <div class="xl:container mx-auto px-3 sm:px-4">
                <!-- big grid 1 -->
                <div class="flex flex-wrap h-auto lg:h-96 ">
                    <!-- Start left cover -->
                    <div class="flex-shrink max-w-full w-full lg:w-1/2 lg:pr-1">
                        <div class="relative hover-img overflow-hidden h-full rounded">
                            @if ($topViewsNews->isNotEmpty())
                                @php
                                    $topNews = $topViewsNews->first();
                                @endphp
                                <a href="{{ route('news.show', $topNews->slug) }}">
                                    <img class="max-w-full w-full h-full object-cover transform transition duration-300 hover:scale-105"
                                        src="{{ Storage::url($topNews->thumbnail) }}" alt="{{ $topNews->name }}">
                                </a>
                                <div class="absolute bottom-0 w-full p-4 bg-gradient-to-t from-black to-transparent">
                                    <a href="{{ route('news.show', $topNews->slug) }}">
                                        <h2 class="text-base lg:text-xl font-bold hover:underline text-white mb-3">
                                            {{ $topNews->name }}
                                        </h2>
                                    </a>
                                    <div class="">
                                        <div class="text-gray-100">
                                            <div class="inline-block h-3 border-l-2 border-orange-600 mr-2"></div>
                                            {{ $topNews->category->name }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500">No top view news available.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Start box news -->
                    <div class="flex-shrink max-w-full w-full lg:w-1/2">
                        <div class="box-one flex flex-wrap h-full rounded">
                            @foreach ($topViewsNews->slice(1, 4) as $item)
                                <article class="flex-shrink max-w-full w-full sm:w-1/2 lg:mb-0">
                                    <div
                                        class="relative hover-img overflow-hidden border-white border-2 h-48 lg:h-56 rounded">

                                        <a href="{{ route('news.show', $item->slug) }}">
                                            <img class="max-w-full w-full h-full object-cover transform transition duration-300 hover:scale-105"
                                                src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->name }}">
                                        </a>
                                        <div
                                            class="absolute px-4 pt-7 pb-4 bottom-0 w-full bg-gradient-to-t from-black to-transparent">
                                            <a href="{{ route('news.show', $item->slug) }}">
                                                <h2
                                                    class="text-sm lg:text-lg font-bold hover:underline capitalize leading-tight text-white">
                                                    {{ $item->name }}
                                                </h2>
                                            </a>
                                            <div class="pt-1">
                                                <div class="text-gray-100">
                                                    <div class="inline-block h-3 border-l-2 border-orange-600 mr-2">
                                                    </div>
                                                    {{ $item->category->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="news-terbaru" class="text-gray-600 body-font lg:flex lg:flex-row lg:px-32">
        <div class="lg:w-3/4  items-start p-2">
            <div class="my-4 lg:pl-4 pl-3">
                <p class="text-lg text-black lg:text-3xl font-bold">Berita Terbaru</p>
                <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
            </div>
            <div class="flex flex-wrap">
                @if ($news->isEmpty())
                    <div class="text-center py-10 pl-3">
                        <p class="text-gray-500 text-lg">Berita tidak ditemukan</p>
                    </div>
                @else
                    @foreach ($news as $item)
                        <div class="lg:w-1/4 md:w-1/2 w-full p-2">
                            <div class="h-full border-gray-200 border-opacity-60 rounded shadow-md overflow-hidden">
                                <a href="{{ route('news.show', $item->slug) }}">
                                    <img class="h-40 w-full object-cover object-center lazyload loading-placeholder transform transition duration-300 hover:scale-105"
                                        data-src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->name }}">
                                </a>
                                <div class="p-3">
                                    <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                        {{ $item->category->name }}
                                    </h2>
                                    <a href="{{ route('news.show', $item->slug) }}" class="hover:no-underline">
                                        <h1
                                            class="title-font text-base font-medium text-gray-900 mb-2 hover:text-gray-500">
                                            {{ Str::words($item->name, 15) }}
                                        </h1>
                                    </a>
                                    <div class="text-gray-400 text-xs mt-2">
                                        Diunggah {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                    </div>
                                    <div class="text-gray-400 text-xs mt-2 justify-between flex">
                                        <span class="text-gray-400 mr-3 inline-flex items-center leading-none text-sm">
                                            <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            {{ $item->views }} Views
                                        </span>
                                        <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                                            <svg class="w-5 h-5 text-gray-400 aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            {{ $item->user->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
            <!-- Pagination links -->
            <div class="mt-4 px-4">
                <div class="mt-4 px-4">
                    {{ $news->appends(['search' => request('search')])->links() }}
                </div>

            </div>
        </div>


        <div class=" lg:w-1/4 p-4 ">
            <div class="lg:py-6"></div>
            <div class="sticky top-4 order-1">
                <div class="mb-4">
                    <div class="my-4 ">
                        <p class="text-lg text-black lg:text-2xl font-bold">Kategori</p>
                        <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
                    </div>
                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="list-group-item p-0 hover:bg-gray-100">
                                <a href="{{ route('news.category', $category->slug) }}"
                                    class="d-flex text-black hover:text-orange-500 justify-content-between align-items-center text-decoration-none px-3 py-2 w-100 h-100">
                                    {{ $category->name }}
                                    <span class="hover:text-orange-500">({{ $category->news_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="">
                    <div class="my-4">
                        <p class="text-lg text-black lg:text-2xl font-bold">Ikuti Kami</p>
                        <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
                    </div>
                    <div class="flex flex-row gap-2">
                        <svg class="w-8 h-8 text-gray-800  aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg class="w-8 h-8 text-gray-800  aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg class="w-8 h-8 text-gray-800  aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div class="h-20">

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- footer start --}}
    <footer class="bg-[#697077] lg:mt-12">
        <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
            <!-- Logo Section -->
            <div class="mb-6 md:mb-0 flex items-center space-x-3 rtl:space-x-reverse">
                <!-- Logo with responsive sizing -->
                <img src="https://a-rez.my.id/icon/Logo%20PRSPDNF%20FH.ico" class="h-8 md:h-10 lg:h-12"
                    alt="PRSPDNF Logo" />

                <div class="flex flex-col items-center">
                    <!-- Text with responsive font sizes -->
                    <span class="uppercase text-center text-white text-xs md:text-sm lg:text-base">PRSPDNF</span>
                    <span class="font-semibold text-white text-sm md:text-lg lg:text-xl">Fajar Harapan</span>
                </div>
                </a>
                <!-- Extended Horizontal Line -->
            </div>
            <!-- Footer Bottom -->
            <hr class="my-6 border-white sm:mx-auto dark:border-gray-700 lg:my-8" />
            <div class="sm:flex sm:items-center sm:justify-between flex flex-col-reverse sm:flex-row">
                <span class="lg:text-sm md-text-sm text-xs text-white sm:text-center dark:text-white">
                    © 2024 <a href="#" class="hover:underline">Magang PRSPDNF FH</a> @ All Rights Reserved.
                </span>
                <div class="text-white flex mb-4 sm:justify-center sm:mb-0 space-x-4">
                    <a href="/" class="hover:underline">Home</a>
                    <a href="aboutus" class="hover:underline">About us</a>
                </div>
            </div>
        </div>
    </footer>
    {{-- footer end --}}

    <script>
        // Script untuk toggle menu pada mobile
        const menuButton = document.getElementById('menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</body>

</html>
