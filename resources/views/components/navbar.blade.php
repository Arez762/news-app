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
                    class="font-bold nightwind-prevent underline-offset-2 hover:text-orange-500 focus:outline-none hover:no-underline"
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
                                                class="relative ml-3 flex flex-col w-full max-w-64 text-neutral-600 justify-between sm:flex">
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
                                                    class="flex-grow items-center flex justify-center gap-6 sm:flex">
                                                    <li>
                                                        <a href="/"
                                                            class="font-bold nightwind-prevent underline-offset-2 hover:text-orange-500 focus:outline-none hover:no-underline"
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
