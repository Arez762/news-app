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
        body {
            font-family: 'Poppins', sans-serif;
            /* Set Poppins font for the body */
        }

        p {
            color: white;
        }

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

        /* For Webkit-based browsers (Chrome, Safari and Opera) */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* For IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-[#F3F4F8]">

    <nav x-data="{ mobileMenuIsOpen: false, isVisible: true, lastScrollY: 0 }"
        @scroll.window="if (window.scrollY > lastScrollY && window.scrollY > 100) { isVisible = false } else { isVisible = true; } lastScrollY = window.scrollY"
        :class="{ 'translate-y-0': isVisible, '-translate-y-full': !isVisible }"
        class="nightwind-prevent-block fixed top-0 left-0 right-0 z-20 flex items-center justify-between w-full p-4 transition-transform duration-300 ease-in-out bg-white bg-opacity-80 backdrop-blur-md shadow-md rounded-b-xl"
        aria-label="penguin ui menu">

        <div class="flex w-full lg:px-28 items-center ">
            <!-- Brand Logo -->
            <a href="/" class="text-2xl font-bold text-neutral-900 nightwind-prevent">
                <img src="{{ asset('image/Icon-prspdnf.png') }}" alt="" class="h-12 lg:h-14">
            </a>
            <!-- End Brand Logo -->

            <!-- Desktop Menu (diletakkan di tengah) -->
            <!-- Desktop Menu (diletakkan di tengah) -->
            <ul class="flex-grow items-center flex justify-center gap-6 hidden sm:flex">
                <li>
                    <a href="/"
                        class="font-bold nightwind-prevent underline-offset-2 text-orange-500 hover:text-orange-500 focus:outline-none hover:no-underline"
                        aria-current="page">Home</a>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('news.category', $category->slug) }}"
                            class="font-bold nightwind-prevent underline-offset-2 
                            {{ request()->is('news/category/' . $category->slug) ? 'text-orange-500' : 'hover:text-orange-500' }} 
                            focus:outline-none hover:no-underline"
                            aria-current="page">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
            <!-- End Desktop Menu -->

            <!-- Search (diletakkan di kanan) -->
            <div class="relative ml-3 flex flex-col w-full max-w-64 text-neutral-600 hidden justify-between sm:flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true"
                    class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50 dark:text-neutral-300/50">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <form action="{{ route('news.search') }}" method="GET">
                    <input type="search" name="search"
                        class="w-full rounded-md border border-neutral-300 bg-neutral-50 py-2.5 pl-10 pr-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500 disabled:cursor-not-allowed disabled:opacity-75"
                        placeholder="Cari berita..." aria-label="Search" value="{{ request('search') }}">
                    <button type="submit" class="hidden">Search</button> <!-- Optional button for accessibility -->
                </form>


            </div>
            <!-- End Search -->
        </div>


        <!-- Mobile Menu Button -->
        <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen"
            :class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button"
            class="flex text-neutral-600 dark:text-neutral-300 sm:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
            <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button> <!-- End Mobile Menu Button -->

        <!-- Mobile Menu -->
        <template x-teleport="body">
            <div x-show="mobileMenuIsOpen" @keydown.window.escape="mobileMenuIsOpen=false" class="relative z-[99]">
                <div x-show="mobileMenuIsOpen" x-transition.opacity.duration.600ms @click="mobileMenuIsOpen = false"
                    class="fixed inset-0 bg-black bg-opacity-10"></div>
                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                            <div x-show="mobileMenuIsOpen" @click.away="mobileMenuIsOpen = false"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-md">
                                <div
                                    class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l shadow-lg border-neutral-100/70">
                                    <div class="px-4 sm:px-5">
                                        <div class="flex items-start justify-between pb-1">
                                            <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">

                                            </h2>
                                            <div class="flex h-auto ml-3">
                                                <button @click="mobileMenuIsOpen=false"
                                                    class="absolute top-0 right-0 z-30 flex justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    <span>Close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                        <div class="absolute inset-0 px-4 sm:px-5">
                                            <div class="relative h-full overflow-hidden border rounded-md">
                                                <div
                                                    class="relative ml-3 flex flex-col w-full max-w-64 text-neutral-600 justify-between sm:flex py-8">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true"
                                                        class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-neutral-600/50 dark:text-neutral-300/50">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                                    </svg>
                                                    <form action="{{ route('news.search') }}" method="GET">
                                                        <input type="search" name="search"
                                                            class="w-full rounded-md border border-neutral-300 bg-neutral-50 py-2.5 pl-10 pr-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500 disabled:cursor-not-allowed disabled:opacity-75"
                                                            placeholder="Cari berita..." aria-label="Search"
                                                            value="{{ request('search') }}">
                                                    </form>
                                                </div>
                                                <div class="">
                                                    <!-- Desktop Menu (diletakkan di tengah) -->
                                                    <ul
                                                        class="flex-col items-center flex justify-center gap-6">
                                                        <li>
                                                            <a href="/"
                                                                class="font-bold nightwind-prevent underline-offset-2 text-orange-500 hover:text-orange-500 focus:outline-none hover:no-underline"
                                                                aria-current="page">Home</a>
                                                        </li>
                                                        @foreach ($categories as $category)
                                                            <li>
                                                                <a href="{{ route('news.category', $category->slug) }}"
                                                                    class="font-bold nightwind-prevent underline-offset-2 
                            {{ request()->is('news/category/' . $category->slug) ? 'text-orange-500' : 'hover:text-orange-500' }} 
                            focus:outline-none hover:no-underline"
                                                                    aria-current="page">{{ $category->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Mobile Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <!-- prettier-ignore-end -->
    </nav>


    <div class="relative flex p-6 flex-col items-center justify-center lg:px-32 rounded-xl ">
        <div class="lg:py-16 py-12">

        </div>
        <div
            class="carousel scrollbar-hide flex w-full snap-x snap-mandatory gap-4 overflow-x-scroll scroll-smooth pb-3 rounded-xl">
            @foreach ($recentNewsHeader as $newsItem)
                <div
                    class="relative aspect-[1/1] h-96 lg:w-[50%] w-[100%] shrink-0 snap-start snap-always rounded-xl bg-blue-200  overflow-hidden">
                    <a href="{{ route('news.show', $newsItem->slug) }}" class="hover:no-underline">
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($newsItem->thumbnail) }}" alt="{{ $newsItem->name }}"
                                class="w-full h-full object-cover transition-opacity duration-500 opacity-0  rounded-xl"
                                loading="lazy" onload="this.style.opacity=1">
                        </div>
                    </a>
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                    <div class="absolute inset-0 flex flex-col items-start justify-end p-4 text-justify">
                        <a href="{{ route('news.show', $newsItem->slug) }}" class="hover:no-underline">
                            <h1
                                class="title-font text-base lg:text-lg font-medium text-white mb-2 hover:text-orange-500">
                                {{ Str::words($newsItem->name, 15) }}
                            </h1>
                            <p class="text-xs text-white lg:text-lg mb-4 hover:text-orange-500">
                                {!! Str::limit($newsItem->content, 100) !!}
                            </p>
                        </a>

                        <div class="flex w-full justify-start gap-3 lg:gap-6 items-center">
                            <div class="text-gray-300 lg:text-sm text-xs items-center">
                                {{ \Carbon\Carbon::parse($newsItem->created_at)->format('d F Y') }}
                            </div>
                            <span class="text-gray-300 inline-flex items-center leading-none text-sm">
                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                                    style="outline: none;">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                {{ $newsItem->views >= 1000 ? number_format($newsItem->views / 1000, 1) . 'k' : $newsItem->views }}
                                Views
                            </span>
                            <span class="text-gray-300 inline-flex items-center leading-none text-sm">
                                <svg class="w-5 h-5 text-gray-300" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24" style="outline: none;">
                                    <path stroke="currentColor" stroke-width=""
                                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                {{ $newsItem->user->name }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination my-4 flex gap-2">
            @foreach ($recentNewsHeader as $key => $newsItem)
                <span
                    class="h-3 w-3 ease-out duration-300 rounded-full bg-gray-400 {{ $key === 0 ? 'w-8' : '' }}"></span>
            @endforeach
        </div>
        <div class="flex flex-row w-64 items-center justify-center">
            <button class="prev-btn hover:text-gray-900 p-2 flex flex-row mr-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg> Prev
            </button>
            <button class="next-btn hover:text-gray-900 p-2 flex flex-row">Next
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        const container = document.querySelector('.carousel');
        const slides = document.querySelectorAll('.carousel > div');
        const dots = document.querySelectorAll('.pagination > span');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');

        const breakpoint = 768;
        const slidesPerPage = 3;
        const autoScrollInterval = 3000;
        let autoScroll;

        prevBtn.addEventListener('click', () => {
            scrollToPrev();
            resetAutoScroll();
        });

        nextBtn.addEventListener('click', () => {
            scrollToNext();
            resetAutoScroll();
        });

        function startAutoScroll() {
            autoScroll = setInterval(() => {
                scrollToNext();
            }, autoScrollInterval);
        }

        function resetAutoScroll() {
            clearInterval(autoScroll);
            startAutoScroll();
        }

        function scrollToNext() {
            if (getCenterSlideIndex() === slides.length - 1) {
                container.scrollTo({
                    left: 0,
                    behavior: 'smooth'
                });
                updateActiveDot(0);
            } else {
                container.scrollBy({
                    left: slides[0].offsetWidth,
                    behavior: 'smooth'
                });
                updateActiveDot(getCenterSlideIndex() + 1);
            }
        }

        function scrollToPrev() {
            if (getCenterSlideIndex() === 0) {
                container.scrollTo({
                    left: container.scrollWidth,
                    behavior: 'smooth'
                });
                updateActiveDot(slides.length - 1);
            } else {
                container.scrollBy({
                    left: -slides[0].offsetWidth,
                    behavior: 'smooth'
                });
                updateActiveDot(getCenterSlideIndex() - 1);
            }
        }

        function updateActiveDot(centerSlideIndex) {
            dots.forEach((dot) => dot.classList.remove('w-8'));
            dots[centerSlideIndex].classList.add('w-8');
        }

        function getCenterSlideIndex() {
            const slideWidth = slides[0].offsetWidth;
            const containerWidth = container.offsetWidth;
            const centerSlideIndex = Math.round((container.scrollLeft + Math.floor(containerWidth / 2)) / slideWidth);
            return centerSlideIndex;
        }

        startAutoScroll();
    </script>

    <section class="w-full lg:px-32">
        <!-- hero big grid -->
        <div class="my-4 lg:pl-4 pl-3">
            <p class="text-2xl text-black lg:mb-2 lg:text-3xl font-bold">Berita Terpopuler</p>
            <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
        </div>
        <div class="rounded-xl lg:mb-10 pb-4">
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
                                                src="{{ Storage::url($item->thumbnail) }}"
                                                alt="{{ $item->name }}">
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

    <section class="text-gray-600 body-font lg:flex lg:flex-row lg:px-32">
        <div class="flex flex-col lg:w-3/4">
            <div class=" items-start p-2">
                @foreach ($categories as $category)
                    <div class="my-4">
                        <div class="my-4 lg:pl-4 pl-3">
                            <p class="text-lg text-black lg:text-3xl font-bold">{{ $category->name }}</p>
                            <div class="w-16 lg:w-20 h-1 bg-orange-500"></div>
                        </div>
                        <div class="flex flex-wrap">
                            @foreach ($newsByCategory[$category->id] as $item)
                                <div class="lg:w-1/4 md:w-1/2 w-full p-2">
                                    <div
                                        class="h-full border-gray-200 border-opacity-60 rounded shadow-md overflow-hidden">
                                        <a href="{{ route('news.show', $item->slug) }}">
                                            <img class="h-40 w-full object-cover object-center lazyload loading-placeholder transform transition duration-300 hover:scale-105"
                                                data-src="{{ Storage::url($item->thumbnail) }}"
                                                alt="{{ $item->name }}">
                                        </a>
                                        <div class="p-3">
                                            <h2
                                                class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                                {{ $item->category->name }}
                                            </h2>
                                            <a href="{{ route('news.show', $item->slug) }}"
                                                class="hover:no-underline">
                                                <h1
                                                    class="title-font text-base font-medium text-gray-900 mb-2 hover:text-gray-500">
                                                    {{ Str::words($item->name, 15) }}
                                                </h1>
                                            </a>
                                            <div class="text-gray-400 text-xs mt-2">
                                                Diunggah
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                            </div>
                                            <div class="text-gray-400 text-xs mt-2 justify-between flex">
                                                <span
                                                    class="text-gray-400 mr-3 inline-flex items-center leading-none text-sm">
                                                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                        viewBox="0 0 24 24">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                    {{ $item->views >= 1000 ? number_format($item->views / 1000, 1) . 'k' : $item->views }}
                                                    Views
                                                </span>
                                                <span
                                                    class="text-gray-400 inline-flex items-center leading-none text-sm">
                                                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
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
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:w-1/4 p-4">
            <div class="lg:py-6"></div>
            <div class="sticky top-4 order-1">
                <div class="mb-4">
                    <div class="my-4">
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

                    <div class="h-20"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- footer start --}}
    <footer class="bg-[#697077] mt-12">
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
