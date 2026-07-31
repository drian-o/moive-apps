@extends('layouts.app')

@section('title', 'Home')

@php
    $ongoingCollection = collect($ongoingAnime ?? [])->values();
    $completedCollection = collect($completedAnime ?? [])->values();
    $donghuaCollection = collect($latestDonghua ?? [])->values();
    $popularMangaCollection = collect($popularManga ?? [])->values();
    $latestMangaCollection = collect($latestManga ?? [])->values();
    $hentaiCollection = collect($recommendedHentai ?? [])->values();

    $hero = $ongoingCollection->first();
    $heroImage = data_get($hero, 'banner') ?: data_get($hero, 'poster');
    $heroId = data_get($hero, 'animeId');
    $heroTitle = data_get($hero, 'title', 'Anime Pilihan');
    $heroEpisodes = data_get($hero, 'episodes', '?');
    $heroDescription = data_get(
        $hero,
        'description',
        'Nikmati berbagai anime terbaru dengan kualitas terbaik dan update episode yang cepat.'
    );
@endphp

@section('content')
<div id="home-discovery" class="relative overflow-hidden pb-16">
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[1500px] overflow-hidden">
        <div class="absolute -left-64 -top-40 h-[620px] w-[620px] rounded-full bg-sky-500/10 blur-[170px]"></div>
        <div class="absolute -right-64 top-[420px] h-[560px] w-[560px] rounded-full bg-violet-500/10 blur-[170px]"></div>
        <div class="absolute left-1/3 top-[1050px] h-[440px] w-[440px] rounded-full bg-fuchsia-500/5 blur-[160px]"></div>

        <div
            class="absolute inset-0 opacity-[0.025]"
            style="background-image:linear-gradient(rgba(255,255,255,.6) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.6) 1px,transparent 1px);background-size:42px 42px;"
        ></div>
    </div>

    <div class="mx-auto max-w-[1800px] space-y-16 px-4 sm:px-6 lg:px-8 xl:space-y-20">
        @if($hero)
            <section class="group relative -mx-4 overflow-hidden border-y border-white/5 bg-slate-950 shadow-2xl shadow-black/40 sm:-mx-6 lg:-mx-8 xl:mx-0 xl:mt-6 xl:rounded-[2rem] xl:border">
                <div class="relative min-h-[650px] overflow-hidden sm:min-h-[700px] xl:min-h-[720px]">
                    @if($heroImage)
                        <img
                            src="{{ $heroImage }}"
                            alt="{{ $heroTitle }}"
                            loading="eager"
                            class="absolute inset-0 h-full w-full scale-[1.03] object-cover object-center transition duration-[1200ms] ease-out group-hover:scale-[1.07] lg:object-[75%_center]"
                        >
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950"></div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-r from-[#04070f] via-[#04070ff0] to-[#04070f25]"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#04070f] via-[#04070f55] to-transparent"></div>
                    <div class="absolute inset-0 bg-black/15"></div>
                    <div class="pointer-events-none absolute bottom-0 left-0 h-80 w-80 rounded-full bg-sky-500/10 blur-[120px]"></div>
                    <div class="pointer-events-none absolute right-0 top-0 h-80 w-80 rounded-full bg-violet-500/10 blur-[120px]"></div>

                    <div class="relative z-10 flex min-h-[650px] items-end px-5 pb-12 pt-28 sm:min-h-[700px] sm:px-8 sm:pb-16 lg:items-center lg:px-14 lg:pb-10 lg:pt-20 xl:min-h-[720px] xl:px-20">
                        <div class="max-w-3xl">
                            <div class="mb-6 flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center gap-2 rounded-full border border-sky-400/25 bg-sky-500/15 px-3.5 py-2 text-xs font-black uppercase tracking-[0.14em] text-sky-200 backdrop-blur-md">
                                    <span class="relative flex h-2 w-2">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-sky-400 opacity-50"></span>
                                        <span class="relative inline-flex h-2 w-2 rounded-full bg-sky-400"></span>
                                    </span>
                                    New Release
                                </span>

                                <span class="rounded-full border border-white/10 bg-black/25 px-3.5 py-2 text-xs font-bold text-slate-300 backdrop-blur-md">
                                    TV Series
                                </span>

                                <span class="rounded-full border border-white/10 bg-black/25 px-3.5 py-2 text-xs font-bold text-slate-300 backdrop-blur-md">
                                    Episode {{ $heroEpisodes }}
                                </span>
                            </div>

                            <h1 class="max-w-3xl text-4xl font-black leading-[1.05] tracking-tight text-white sm:text-5xl lg:text-6xl xl:text-7xl">
                                {{ $heroTitle }}
                            </h1>

                            <div class="mt-6 flex flex-wrap gap-2">
                                @foreach(['Adventure', 'Fantasy', 'Action'] as $genre)
                                    <span class="rounded-full border border-white/10 bg-white/[0.06] px-4 py-2 text-xs font-semibold text-zinc-200 backdrop-blur-md sm:text-sm">
                                        {{ $genre }}
                                    </span>
                                @endforeach
                            </div>

                            <p class="mt-7 max-w-2xl line-clamp-4 text-sm leading-7 text-zinc-300 sm:text-base sm:leading-8 lg:text-lg">
                                {{ $heroDescription }}
                            </p>

                            <div class="mt-10 flex flex-wrap items-center gap-3 sm:gap-4">
                                <a
                                    href="{{ route('anime.show', $heroId) }}"
                                    class="group/watch inline-flex items-center gap-3 rounded-2xl bg-white px-6 py-3.5 text-sm font-black text-slate-950 shadow-xl shadow-black/20 transition hover:-translate-y-0.5 hover:bg-sky-300 sm:px-8 sm:py-4"
                                >
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-950 text-white transition group-hover/watch:scale-110">
                                        <svg class="ml-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.5 3.8v12.4L16 10 5.5 3.8Z"/>
                                        </svg>
                                    </span>
                                    Watch Now
                                </a>

                                <a
                                    href="{{ route('anime.show', $heroId) }}"
                                    class="inline-flex items-center gap-2 rounded-2xl border border-white/15 bg-white/[0.06] px-6 py-3.5 text-sm font-bold text-white backdrop-blur-md transition hover:-translate-y-0.5 hover:border-white/25 hover:bg-white/10 sm:px-7 sm:py-4"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.25 11.25h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008V8.25Zm.75 12.75a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                                    </svg>
                                    More Info
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="grid gap-10 xl:grid-cols-12">
            <div class="min-w-0 xl:col-span-8">
                <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <span class="mb-3 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.18em] text-sky-400">
                            <span class="h-px w-8 bg-sky-400"></span>
                            Fresh Updates
                        </span>

                        <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                            Latest Episodes
                        </h2>

                        <p class="mt-2 text-sm text-zinc-500">
                            Episode anime terbaru yang baru saja dirilis.
                        </p>
                    </div>

                    <a
                        href="{{ url('/anime') }}"
                        class="group inline-flex items-center gap-2 text-sm font-bold text-sky-400 transition hover:text-sky-300"
                    >
                        View All
                        <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </div>

                @if($ongoingCollection->isNotEmpty())
                    <div class="grid grid-cols-2 gap-4 sm:gap-5 md:grid-cols-3 xl:grid-cols-4">
                        @foreach($ongoingCollection as $anime)
                            <div class="min-w-0">
                                <x-episode-card
                                    :id="data_get($anime, 'animeId')"
                                    :image="data_get($anime, 'poster')"
                                    :title="data_get($anime, 'title', 'Untitled')"
                                    :episode="'EP '.data_get($anime, 'episodes', '?')"
                                />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center text-sm text-slate-500">
                        Belum ada episode terbaru.
                    </div>
                @endif
            </div>

            <aside class="xl:col-span-4">
                <div class="overflow-hidden rounded-[2rem] border border-white/5 bg-slate-900/70 shadow-2xl shadow-black/20 backdrop-blur">
                    <div class="flex items-center justify-between border-b border-white/5 px-5 py-5 sm:px-6">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-[0.18em] text-violet-400">
                                Weekly Ranking
                            </span>

                            <h2 class="mt-1 text-2xl font-black text-white">
                                Popular Anime
                            </h2>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-500/10 text-violet-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m2.25 18 7.5-7.5 4 4L21.75 6M18 6h3.75v3.75"/>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-1 p-3">
                        @forelse($completedCollection->take(6) as $index => $anime)
                            <x-popular-card
                                :anime="$anime"
                                :rank="$index + 1"
                            />
                        @empty
                            <div class="px-4 py-12 text-center text-sm text-slate-600">
                                Belum ada data anime populer.
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>

        {{-- Latest Donghua --}}
        <section>
            <div class="mb-7">
                <span class="mb-3 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.18em] text-cyan-400">
                    <span class="h-px w-8 bg-cyan-400"></span>
                    Chinese Animation
                </span>

                <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                    Latest Donghua
                </h2>

                <p class="mt-2 text-sm text-zinc-500">
                    Donghua terbaru yang baru saja diperbarui.
                </p>
            </div>

            @if($donghuaCollection->isNotEmpty())
                <div class="swiper content-swiper latest-donghua-swiper">
                    <div class="swiper-wrapper">
                        @foreach($donghuaCollection as $item)
                            <div class="swiper-slide">
                                <x-poster-card
                                    :id="data_get($item, 'slug')"
                                    :image="data_get($item, 'poster')"
                                    :title="data_get($item, 'title', 'Untitled')"
                                    episode="Donghua"
                                    route="donghua.show"
                                />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination !relative !bottom-auto mt-8"></div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center text-sm text-slate-500">
                    Belum ada donghua terbaru.
                </div>
            @endif
        </section>

        {{-- Popular Manga --}}
        <section>
            <div class="mb-7">
                <span class="mb-3 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.18em] text-violet-400">
                    <span class="h-px w-8 bg-violet-400"></span>
                    Reader Favorites
                </span>

                <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                    Popular Manga
                </h2>

                <p class="mt-2 text-sm text-zinc-500">
                    Manga yang paling banyak dilihat oleh pembaca.
                </p>
            </div>

            @if($popularMangaCollection->isNotEmpty())
                <div class="swiper content-swiper popular-manga-swiper">
                    <div class="swiper-wrapper">
                        @foreach($popularMangaCollection as $manga)
                            <div class="swiper-slide">
                                <x-poster-card
                                    :id="data_get($manga, 'slug')"
                                    :image="data_get($manga, 'image')"
                                    :title="data_get($manga, 'title', 'Untitled')"
                                    episode="Manga"
                                    route="comic.show"
                                />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination !relative !bottom-auto mt-8"></div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center text-sm text-slate-500">
                    Belum ada manga populer.
                </div>
            @endif
        </section>

        {{-- Latest Manga --}}
        <section>
            <div class="mb-7">
                <span class="mb-3 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.18em] text-sky-400">
                    <span class="h-px w-8 bg-sky-400"></span>
                    New Chapters
                </span>

                <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                    Latest Manga
                </h2>

                <p class="mt-2 text-sm text-zinc-500">
                    Chapter manga terbaru yang baru saja diperbarui.
                </p>
            </div>

            @if($latestMangaCollection->isNotEmpty())
                <div class="swiper content-swiper latest-manga-swiper">
                    <div class="swiper-wrapper">
                        @foreach($latestMangaCollection as $manga)
                            <div class="swiper-slide">
                                <x-poster-card
                                    :id="data_get($manga, 'slug')"
                                    :image="data_get($manga, 'image')"
                                    :title="data_get($manga, 'title', 'Untitled')"
                                    episode="Latest"
                                    route="comic.show"
                                />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination !relative !bottom-auto mt-8"></div>
                </div>
            @else
                <div class="rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center text-sm text-slate-500">
                    Belum ada manga terbaru.
                </div>
            @endif
        </section>

        {{-- Mature content --}}
        @if($hentaiCollection->isNotEmpty())
            <section class="relative overflow-hidden rounded-[2rem] border border-red-500/10 bg-gradient-to-br from-red-950/20 via-slate-950/40 to-fuchsia-950/15 p-5 sm:p-7 lg:p-9">
                <div class="pointer-events-none absolute -right-24 -top-24 h-64 w-64 rounded-full bg-red-500/10 blur-[110px]"></div>

                <div class="relative">
                    <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <div class="mb-3 flex items-center gap-2">
                                <span class="rounded-md bg-red-500 px-2 py-1 text-[10px] font-black uppercase tracking-wider text-white">
                                    18+
                                </span>

                                <span class="text-xs font-black uppercase tracking-[0.18em] text-red-300">
                                    Mature Content
                                </span>
                            </div>

                            <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                                Recommended Hentai
                            </h2>

                            <p class="mt-2 text-sm text-slate-500">
                                Rekomendasi konten khusus untuk pengguna dewasa.
                            </p>
                        </div>

                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-red-300/70">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21H6.75A2.25 2.25 0 0 1 4.5 18.75v-6a2.25 2.25 0 0 1 2.25-2.25Z"/>
                            </svg>
                            Adult access only
                        </span>
                    </div>

                    <div class="swiper content-swiper recommended-hentai-swiper">
                        <div class="swiper-wrapper">
                            @foreach($hentaiCollection as $item)
                                <div class="swiper-slide">
                                    <x-poster-card
                                        :id="data_get($item, 'slug')"
                                        :image="data_get($item, 'thumbnail')"
                                        :title="data_get($item, 'title', 'Untitled')"
                                        episode="18+"
                                        route="hentai.show"
                                    />
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !relative !bottom-auto mt-8"></div>
                    </div>
                </div>
            </section>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    #home-discovery .content-swiper {
        overflow: visible;
    }

    #home-discovery .content-swiper .swiper-slide {
        height: auto;
    }

    #home-discovery .swiper-pagination-bullet {
        width: 7px;
        height: 7px;
        background: #475569;
        opacity: .8;
        transition: all .25s ease;
    }

    #home-discovery .swiper-pagination-bullet-active {
        width: 26px;
        border-radius: 9999px;
        background: #38bdf8;
        opacity: 1;
    }

    @media (max-width: 640px) {
        #home-discovery .content-swiper {
            overflow: hidden;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper belum dimuat pada layouts.app.');
        return;
    }

    [
        '.latest-donghua-swiper',
        '.popular-manga-swiper',
        '.latest-manga-swiper',
        '.recommended-hentai-swiper',
    ].forEach(selector => {
        const element = document.querySelector(selector);

        if (!element) {
            return;
        }

new Swiper(element, {
    slidesPerView: 2.15,
    spaceBetween: 14,

    grabCursor: true,
    watchOverflow: true,

    // Slide otomatis
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },

    // Transisi lebih halus
    speed: 800,

    // Berputar terus
    loop: true,

    pagination: {
        el: element.querySelector('.swiper-pagination'),
        clickable: true,
    },

    breakpoints: {
        520: {
            slidesPerView: 2.7,
            spaceBetween: 16,
        },

        640: {
            slidesPerView: 3.2,
            spaceBetween: 18,
        },

        768: {
            slidesPerView: 4.2,
            spaceBetween: 20,
        },

        1024: {
            slidesPerView: 5.2,
            spaceBetween: 22,
        },

        1280: {
            slidesPerView: 6.2,
            spaceBetween: 24,
        },

        1536: {
            slidesPerView: 7.2,
            spaceBetween: 24,
        },
    },
});
    });
});
</script>
@endpush