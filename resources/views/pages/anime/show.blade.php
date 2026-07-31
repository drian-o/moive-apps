@extends('layouts.app')
@section('content')

<div class="relative -mx-4 -mt-5 overflow-hidden lg:-mx-8">

    {{-- Banner --}}
    <img
        src="{{ $anime['banner'] ?? $anime['poster'] }}"
        alt="{{ $anime['title'] }}"
        class="absolute inset-0 h-full w-full object-cover">

    <div class="absolute inset-0 bg-black/70"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#090909] via-[#090909f2] to-[#09090980]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#090909] via-transparent to-transparent"></div>

    <div class="relative mx-auto max-w-none px-6 py-12 lg:px-10">

        <div class="grid gap-10 lg:grid-cols-[340px_minmax(0,1fr)]">

            {{-- ================= LEFT ================= --}}
            <div>

                <img
                    src="{{ $anime['poster'] }}"
                    alt="{{ $anime['title'] }}"
                    class="w-full rounded-3xl shadow-[0_30px_80px_rgba(0,0,0,.6)] ring-1 ring-white/10">

                <a
                    href="{{ !empty($anime['episodeList']) ? route('watch',$anime['episodeList'][0]['episodeId']) : '#' }}"
                    class="mt-5 flex w-full items-center justify-center rounded-xl bg-sky-500 py-4 font-semibold transition hover:bg-sky-400">

                    ▶ Watch Now

                </a>

                <button
                    class="mt-3 flex w-full items-center justify-center rounded-xl border border-white/10 bg-white/5 py-4 backdrop-blur transition hover:bg-white/10">

                    + Add Bookmark

                </button>

                {{-- Information --}}
                <div class="mt-6 rounded-3xl border border-white/10 bg-zinc-900/70 p-7 backdrop-blur-xl">

                    <h3 class="mb-5 text-lg font-bold">

                        Information

                    </h3>

                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Type</span>

                            <span>{{ $anime['type'] }}</span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Status</span>

                            <span>{{ $anime['status'] }}</span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Studio</span>

                            <span>{{ $anime['studios'] ?: '-' }}</span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Release</span>

                            <span>{{ $anime['aired'] }}</span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Episodes</span>

                            <span>{{ count($anime['episodeList']) }}</span>

                        </div>

                        <div class="flex justify-between">

                            <span class="text-zinc-500">Duration</span>

                            <span>{{ $anime['duration'] }}</span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= RIGHT ================= --}}
            <div>

                @if(!empty($anime['japanese']))
                    <p class="text-sm uppercase tracking-[0.3em] text-zinc-400">

                        {{ $anime['japanese'] }}

                    </p>
                @endif

                <h1 class="mt-3 text-5xl xl:text-6xl font-black leading-tight lg:text-5xl">

                    {{ $anime['title'] }}

                </h1>

                {{-- Badges --}}
                <div class="mt-6 flex flex-wrap gap-3">

                    <span class="rounded-full bg-yellow-500 px-5 py-2 font-bold text-black">

                        ⭐ {{ $anime['score'] }}

                    </span>

                    <span class="rounded-full bg-white/10 px-5 py-2">

                        {{ $anime['type'] }}

                    </span>

                    <span class="rounded-full bg-white/10 px-5 py-2">

                        {{ $anime['status'] }}

                    </span>

                    <span class="rounded-full bg-white/10 px-5 py-2">

                        {{ $anime['duration'] }}

                    </span>

                </div>

                {{-- Genre --}}
                <div class="mt-8 flex flex-wrap gap-2">

                    @foreach($anime['genreList'] as $genre)

                        <span
                            class="rounded-full border border-sky-500/20 bg-sky-500/10 px-4 py-2 text-sm text-sky-300 backdrop-blur">

                            {{ $genre['title'] }}

                        </span>

                    @endforeach

                </div>

                {{-- Synopsis --}}
                @if(!empty($anime['synopsis']['paragraphs']))

                    <div class="mt-12 max-w-5xl">

                        <h2 class="mb-5 text-2xl font-bold">

                            Synopsis

                        </h2>

                        <div class="max-w-4xl space-y-5 leading-8 text-zinc-300">

                            @foreach($anime['synopsis']['paragraphs'] as $paragraph)
                                <p>
                                    {{ $paragraph }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ================= EPISODES ================= --}}
<section class="mx-auto mt-20 max-w-none px-6 lg:px-10">

    <div class="mb-6 flex items-center justify-between">

        <div>

            <h2 class="text-3xl font-bold">

                Episodes

            </h2>

            <p class="mt-2 text-sm text-zinc-500">

                {{ count($anime['episodeList']) }} Episodes Available

            </p>

        </div>

        <div class="hidden lg:block">

            <button
                class="rounded-xl border border-white/10 bg-white/5 px-5 py-2 text-sm backdrop-blur hover:bg-white/10">

                Newest First

            </button>

        </div>

    </div>

    <div class="space-y-4">

        @foreach($anime['episodeList'] as $episode)

            <a
                href="{{ route('watch',$episode['episodeId']) }}"
                class="group flex items-center gap-5 rounded-2xl border border-white/10 bg-zinc-900/70 p-4 transition duration-300 hover:border-sky-500/40 hover:bg-zinc-800">

                {{-- Thumbnail --}}
                <div class="relative h-24 w-40 shrink-0 overflow-hidden rounded-xl">

                    <img
                        src="{{ $anime['banner'] ?? $anime['poster'] }}"
                        alt="Episode {{ $episode['eps'] }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                    <div class="absolute inset-0 bg-black/30"></div>

                    <div
                        class="absolute bottom-2 left-2 rounded-md bg-sky-500 px-2 py-1 text-xs font-bold">

                        EP {{ $episode['eps'] }}

                    </div>

                </div>

                {{-- Info --}}
                <div class="min-w-0 flex-1">

                    <h3
                        class="truncate text-lg font-semibold transition group-hover:text-sky-400">

                        Episode {{ $episode['eps'] }}

                    </h3>

                    <div
                        class="mt-2 flex flex-wrap items-center gap-3 text-sm text-zinc-500">

                        <span>

                            {{ $episode['date'] ?? 'Unknown Release Date' }}

                        </span>

                        <span>•</span>

                        <span>

                            {{ $anime['duration'] }}

                        </span>

                        <span
                            class="rounded-full bg-green-500/10 px-2 py-1 text-xs text-green-400">

                            SUB

                        </span>

                    </div>

                </div>

                {{-- Play --}}
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500 text-xl transition group-hover:scale-110">
                    ▶
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- ================= RECOMMENDED ================= --}}
@if(!empty($anime['recommendedAnimeList']))

<section class="mx-auto mt-20 max-w-none px-6 lg:px-10">

    <div class="mb-8 flex items-center justify-between">

        <div>

            <h2 class="text-3xl font-bold">

                Recommended Anime

            </h2>

            <p class="mt-2 text-zinc-500">

                You might also like these anime

            </p>

        </div>

        <div class="hidden gap-3 lg:flex">

            <div class="recommended-prev cursor-pointer rounded-xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">

                ←

            </div>

            <div class="recommended-next cursor-pointer rounded-xl border border-white/10 bg-white/5 px-4 py-3 transition hover:bg-white/10">

                →

            </div>

        </div>

    </div>

    <div class="swiper recommended-swiper overflow-visible">

        <div class="swiper-wrapper">

            @foreach($anime['recommendedAnimeList'] as $item)

                <div class="swiper-slide !w-[170px]">

                    <a
                        href="{{ route('anime.show',$item['animeId']) }}"
                        class="group block">

                        <div
                            class="overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 transition duration-300 hover:border-sky-500/40">

                            {{-- Poster --}}
                            <div class="relative aspect-[2/3] overflow-hidden">

                                <img
                                    src="{{ $item['poster'] }}"
                                    alt="{{ $item['title'] }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-110">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent">
                                </div>

                                @if(!empty($item['episode']))
                                    <div
                                        class="absolute bottom-3 left-3 rounded-full bg-sky-500 px-2 py-1 text-xs font-bold">

                                        EP {{ $item['episode'] }}

                                    </div>
                                @endif

                            </div>

                            {{-- Info --}}
                            <div class="p-4">

                                <h3
                                    class="line-clamp-2 text-sm font-semibold transition group-hover:text-sky-400">

                                    {{ $item['title'] }}

                                </h3>

                                @if(!empty($item['type']))

                                    <p class="mt-2 text-xs text-zinc-500">

                                        {{ $item['type'] }}

                                    </p>

                                @endif

                            </div>

                        </div>

                    </a>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endif




@endsection