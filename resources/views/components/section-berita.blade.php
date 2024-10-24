<style>
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

<div
    class="relative flex p-10 flex-col items-center lg:mb-12 justify-center bg-white lg:mx-12 mx-4 rounded-xl shadow-xl">
    <div class="items-start mb-10">
        <!-- Top Small Title -->
        <p class="font-bold text-2xl lg:text-3xl">Berita Terbaru</p>
        <!-- Orange underline below 'Profil' -->
        <div class="w-auto h-1 bg-orange-500 mx-auto my-2"></div>
    </div>
    <div class="carousel scrollbar-hide flex w-full snap-x snap-mandatory gap-4 overflow-x-scroll scroll-smooth">
        @foreach ($recentNews as $newsItem)
            <div
                class="relative aspect-[1/1] w-[85%] shrink-0 snap-start snap-always rounded-xl bg-blue-200 md:w-[calc(33.33%-(32px/3))] shadow-lg overflow-hidden">
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->name }}"
                        class="w-full h-full object-cover transition-opacity duration-500 opacity-0" loading="lazy"
                        onload="this.style.opacity=1">
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-start justify-end p-4 text-justify">
                    <h2 class="text-sm lg:text-2xl font-bold text-white mb-2">{{ $newsItem->name }}</h2>
                    <p class="text-xs lg:text-sm text-white mb-4">
                        {{ Str::limit($newsItem->content, 100) }}
                    </p>
                    <a href="{{ route('news.show', $newsItem->id) }}"
                        class="text-xs lg:text-sm hover:text-orange-400 text-white font-semibold py-2 rounded flex items-center">
                        Lihat Selengkapnya
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination my-4 flex gap-2">
        @foreach ($recentNews as $key => $newsItem)
            <span class="h-3 w-3 ease-out duration-300 rounded-full bg-black {{ $key === 0 ? 'w-8' : '' }}"></span>
        @endforeach
    </div>

    <div class="flex flex-row w-64 items-center justify-center">
        <button class="prev-btn hover:text-orange-400 p-2 flex flex-row mr-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg> Prev
        </button>
        <button class="next-btn hover:text-orange-400 p-2 flex flex-row">Next
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
