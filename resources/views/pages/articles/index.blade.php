@extends('layouts.app')

@section('title', 'Artikel')

@php
    $articleCollection = $articles->getCollection();
    $hero = $articleCollection->first();

    $pageViews = $articleCollection->sum(fn ($article) => (int) ($article->views ?? 0));

    $latestPublishedAt = $articleCollection
        ->pluck('published_at')
        ->filter()
        ->sortDesc()
        ->first();
@endphp

@section('content')
<div
    id="public-articles-page"
    class="relative overflow-hidden"
>
    {{-- Background decoration --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[720px] overflow-hidden">
        <div class="absolute -left-40 -top-40 h-[420px] w-[420px] rounded-full bg-indigo-600/15 blur-3xl"></div>
        <div class="absolute -right-40 top-10 h-[420px] w-[420px] rounded-full bg-cyan-500/10 blur-3xl"></div>

        <div
            class="absolute inset-0 opacity-[0.025]"
            style="
                background-image:
                    linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px);
                background-size: 34px 34px;
            "
        ></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        {{-- Hero heading --}}
        <header class="mb-10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-indigo-500/20 bg-indigo-500/10 px-3 py-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-40"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                        </span>

                        <span class="text-xs font-bold uppercase tracking-[0.16em] text-indigo-300">
                            Latest Stories
                        </span>
                    </div>

                    <h1 class="max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Artikel terbaru,
                        <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-cyan-400 bg-clip-text text-transparent">
                            inspirasi tanpa batas.
                        </span>
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-400 sm:text-lg">
                        Berita, tutorial, update anime, manga, donghua, dan berbagai informasi menarik yang dikurasi untuk kamu.
                    </p>
                </div>

                @if($articles->count())
                    <div class="grid w-full max-w-md grid-cols-3 gap-3 lg:w-auto">
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4 text-center shadow-lg shadow-black/10 backdrop-blur">
                            <p class="text-2xl font-black text-white">
                                {{ number_format($articles->total()) }}
                            </p>

                            <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Artikel
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4 text-center shadow-lg shadow-black/10 backdrop-blur">
                            <p class="text-2xl font-black text-cyan-400">
                                {{ number_format($pageViews) }}
                            </p>

                            <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Views
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-900/80 p-4 text-center shadow-lg shadow-black/10 backdrop-blur">
                            <p class="text-sm font-black text-indigo-400">
                                {{ $latestPublishedAt ? optional($latestPublishedAt)->format('d M') : '-' }}
                            </p>

                            <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Terbaru
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </header>

        @if($articles->count())
            {{-- Featured article --}}
            <article class="group relative mb-12 overflow-hidden rounded-[2rem] border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30 transition duration-300 hover:border-indigo-500/40">
                <a
                    href="{{ route('articles.show', $hero->slug) }}"
                    class="block"
                >
                    <div class="relative min-h-[520px] overflow-hidden lg:min-h-[560px]">
                        @if($hero->thumbnail)
                            <img
                                src="{{ asset('storage/'.$hero->thumbnail) }}"
                                alt="{{ $hero->title }}"
                                loading="eager"
                                class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                            >
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-900 to-indigo-950"></div>

                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg
                                    class="h-24 w-24 text-slate-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.4"
                                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A2.25 2.25 0 0 0 22.5 17.25V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v10.5A2.25 2.25 0 0 0 3.75 19.5Zm12-12h.008v.008H15.75V7.5Z"
                                    />
                                </svg>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/55 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-transparent to-transparent"></div>

                        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8 lg:p-12">
                            <div class="max-w-4xl">
                                <div class="mb-5 flex flex-wrap items-center gap-3">
                                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-400/20 bg-indigo-500/20 px-3 py-1.5 text-xs font-bold text-indigo-200 backdrop-blur">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.563.563 0 0 0-.182-.557L3.04 10.385a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                                        </svg>

                                        Featured Story
                                    </span>

                                    <span class="rounded-full border border-white/10 bg-black/25 px-3 py-1.5 text-xs font-semibold text-slate-300 backdrop-blur">
                                        {{ optional($hero->published_at)->format('d M Y') ?? 'Tanggal belum tersedia' }}
                                    </span>
                                </div>

                                <h2 class="max-w-4xl text-3xl font-black leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                                    {{ $hero->title }}
                                </h2>

                                <p class="mt-5 max-w-3xl line-clamp-3 text-sm leading-7 text-slate-300 sm:text-base">
                                    {{ $hero->excerpt ?: 'Baca artikel lengkap untuk mengetahui informasi selengkapnya.' }}
                                </p>

                                <div class="mt-8 flex flex-wrap items-center gap-4">
                                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300">
                                        <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>

                                        {{ number_format($hero->views ?? 0) }} views
                                    </span>

                                    @php
                                        $heroWordCount = str_word_count(strip_tags($hero->excerpt ?? ''));
                                        $heroReadTime = max(1, (int) ceil($heroWordCount / 200));
                                    @endphp

                                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-slate-300">
                                        <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>

                                        {{ $heroReadTime }} menit baca
                                    </span>

                                    <span class="ml-auto inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-black text-slate-950 transition group-hover:bg-indigo-400">
                                        Baca Selengkapnya

                                        <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </article>

            {{-- Latest articles header --}}
            <div
                id="latest-articles"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
            >
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-indigo-400">
                        Discover More
                    </p>

                    <h2 class="mt-2 text-2xl font-black text-white sm:text-3xl">
                        Artikel lainnya
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Temukan bacaan menarik lainnya yang mungkin kamu suka.
                    </p>
                </div>

                <div class="group relative w-full sm:w-80">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-slate-600 transition group-focus-within:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m21 21-4.35-4.35m1.6-5.4a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>

                    <input
                        id="article-search"
                        type="search"
                        placeholder="Cari artikel pada halaman ini..."
                        class="w-full rounded-2xl border border-slate-800 bg-slate-900/80 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-indigo-500/60 focus:ring-4 focus:ring-indigo-500/10"
                    >
                </div>
            </div>

            {{-- Articles grid --}}
            <div
                id="articles-grid"
                class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
            >
                @foreach($articles->skip(1) as $article)
                    @php
                        $wordCount = str_word_count(strip_tags(
                            ($article->excerpt ?? '').' '.($article->content ?? '')
                        ));

                        $readTime = max(1, (int) ceil($wordCount / 200));
                        $searchText = strtolower($article->title.' '.$article->slug.' '.$article->excerpt);
                    @endphp

                    <article
                        class="article-card group flex min-h-full flex-col overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl shadow-black/10 transition duration-300 hover:-translate-y-1.5 hover:border-indigo-500/40 hover:shadow-indigo-950/20"
                        data-search="{{ $searchText }}"
                    >
                        <a
                            href="{{ route('articles.show', $article->slug) }}"
                            class="relative block aspect-[16/10] overflow-hidden bg-slate-800"
                        >
                            @if($article->thumbnail)
                                <img
                                    src="{{ asset('storage/'.$article->thumbnail) }}"
                                    alt="{{ $article->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                                    <svg
                                        class="h-14 w-14 text-slate-700"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A2.25 2.25 0 0 0 22.5 17.25V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v10.5A2.25 2.25 0 0 0 3.75 19.5Zm12-12h.008v.008H15.75V7.5Z"
                                        />
                                    </svg>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent opacity-0 transition group-hover:opacity-100"></div>

                            <div class="absolute left-4 top-4 rounded-full border border-white/10 bg-slate-950/70 px-3 py-1.5 text-[11px] font-bold text-white backdrop-blur">
                                {{ optional($article->published_at)->format('d M Y') ?? 'Artikel' }}
                            </div>
                        </a>

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <div class="mb-4 flex items-center gap-4 text-xs font-semibold text-slate-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>

                                    {{ number_format($article->views ?? 0) }}
                                </span>

                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>

                                    {{ $readTime }} menit
                                </span>
                            </div>

                            <a href="{{ route('articles.show', $article->slug) }}">
                                <h3 class="line-clamp-2 text-xl font-black leading-7 text-white transition group-hover:text-indigo-300">
                                    {{ $article->title }}
                                </h3>
                            </a>

                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-400">
                                {{ $article->excerpt ?: 'Baca artikel lengkap untuk mengetahui informasi selengkapnya.' }}
                            </p>

                            <div class="mt-auto pt-6">
                                <a
                                    href="{{ route('articles.show', $article->slug) }}"
                                    class="inline-flex items-center gap-2 text-sm font-black text-indigo-400 transition hover:text-indigo-300"
                                >
                                    Baca Artikel

                                    <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Filter empty state --}}
            <div
                id="article-search-empty"
                class="mt-6 hidden rounded-3xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-20 text-center"
            >
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                    <svg class="h-8 w-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="m21 21-4.35-4.35m1.6-5.4a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>

                <h3 class="mt-5 text-xl font-black text-white">
                    Artikel tidak ditemukan
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Coba gunakan kata pencarian yang berbeda.
                </p>
            </div>

            {{-- Pagination --}}
            @if($articles->hasPages())
                <div class="mt-12 rounded-2xl border border-slate-800 bg-slate-900/70 p-4 shadow-xl shadow-black/10">
                    {{ $articles->onEachSide(1)->links() }}
                </div>
            @endif
        @else
            {{-- Empty state --}}
            <div class="relative overflow-hidden rounded-[2rem] border border-dashed border-slate-700 bg-slate-900/50 px-6 py-28 text-center shadow-2xl shadow-black/20">
                <div class="pointer-events-none absolute -left-24 -top-24 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-24 -right-24 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>

                <div class="relative">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl border border-slate-700 bg-slate-800 shadow-lg shadow-black/20">
                        <svg
                            class="h-10 w-10 text-slate-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.75A3.375 3.375 0 0 0 11.25 3.375H8.625m0 11.625h4.5m-4.5 3h4.5M10.5 3.375H5.625c-.621 0-1.125.504-1.125 1.125v15c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V12.375a9 9 0 0 0-9-9Z"
                            />
                        </svg>
                    </div>

                    <h2 class="mt-6 text-2xl font-black text-white">
                        Belum Ada Artikel
                    </h2>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">
                        Artikel terbaru akan muncul di halaman ini setelah dipublikasikan.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.getElementById('article-search');

    const cards = Array.from(
        document.querySelectorAll('.article-card')
    );

    const emptyState =
        document.getElementById('article-search-empty');

    if (!searchInput || cards.length === 0) {
        return;
    }

    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value
            .trim()
            .toLowerCase();

        let visible = 0;

        cards.forEach(card => {
            const matches =
                !keyword ||
                (card.dataset.search || '').includes(keyword);

            card.classList.toggle('hidden', !matches);

            if (matches) {
                visible++;
            }
        });

        emptyState?.classList.toggle(
            'hidden',
            visible > 0
        );
    });
});
</script>
@endpush