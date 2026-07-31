@extends('layouts.app')

@section('content')

<div class="relative mx-auto max-w-[1700px] space-y-20 px-5 lg:px-8">

    <div class="absolute -left-52 top-0 h-[500px] w-[500px] rounded-full bg-sky-500/10 blur-[180px]"></div>

    <div class="absolute right-0 top-[900px] h-[450px] w-[450px] rounded-full bg-violet-500/10 blur-[180px]"></div>

    <div class="relative z-10">
</div>

    {{-- HERO --}}
    @if(!empty($ongoingAnime))

    @php($hero = $ongoingAnime[0])

<section class="relative overflow-hidden rounded-3xl h-[620px]">

    {{-- Background --}}
    <img
        src="{{ $hero['poster'] }}"
        class="absolute inset-0 h-full w-full object-cover">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-black/20"></div>

    {{-- Content --}}
    <div class="relative z-10 flex h-full max-w-3xl flex-col justify-center px-12">

        <span
            class="mb-5 w-fit rounded-full bg-sky-500/90 px-4 py-2 text-sm font-semibold">

            2026

        </span>

        <h1 class="text-6xl font-black leading-tight">

            {{ $hero['title'] }}

        </h1>

        <div class="mt-6 flex flex-wrap gap-3">

            <span class="rounded-full bg-white/10 px-4 py-2 text-sm">
                Adventure
            </span>

            <span class="rounded-full bg-white/10 px-4 py-2 text-sm">
                Fantasy
            </span>

            <span class="rounded-full bg-white/10 px-4 py-2 text-sm">
                Action
            </span>
        </div>
        <p class="mt-8 max-w-xl text-zinc-300 leading-8">
            Episode {{ $hero['episodes'] }}
        </p>
        <a
            href="{{ route('anime.show',$hero['animeId']) }}"
            class="mt-10 w-fit rounded-xl bg-white px-8 py-4 font-semibold text-black transition hover:scale-105">
            ▶ Watch Now
        </a>
    </div>
</section>

    @endif


<section class="grid gap-8 xl:grid-cols-12">

    {{-- Latest Episodes --}}
    <div class="xl:col-span-8">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-3xl font-bold">
                Latest Episodes
            </h2>

            <a
                href="/anime/unlimited"
                class="text-sky-400 hover:text-sky-300">

                View All →

            </a>

        </div>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-3">

            @foreach($ongoingAnime as $anime)

                <x-anime-card
                    :id="$anime['animeId']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="'EP '.$anime['episodes']"
                />

            @endforeach

        </div>

    </div>

    {{-- Popular Sidebar --}}
    <div class="xl:col-span-4">

        <h2 class="mb-6 text-3xl font-bold">
            Popular Anime
        </h2>

        <div class="space-y-4">

            @foreach(array_slice($completedAnime,0,5) as $anime)

                <a
                    href="{{ route('anime.show',$anime['animeId']) }}"
                    class="flex gap-4 rounded-2xl bg-zinc-900 p-3 transition hover:bg-zinc-800">

                    <img
                        src="{{ $anime['poster'] }}"
                        class="h-24 w-16 rounded-lg object-cover">

                    <div class="flex flex-1 flex-col justify-center">

                        <h3 class="line-clamp-2 font-semibold">

                            {{ $anime['title'] }}

                        </h3>

                        <p class="mt-2 text-sm text-zinc-400">

                            ⭐ {{ $anime['score'] }}

                        </p>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>


    {{-- Latest Donghua --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Latest Donghua
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($latestDonghua as $item)

                <a href="{{ route('donghua.show',$item['slug']) }}">

                    <img
                        src="{{ $item['poster'] }}"
                        class="rounded-xl">

                    <h3 class="mt-3 line-clamp-2">

                        {{ $item['title'] }}

                    </h3>

                </a>
                

            @endforeach

        </div>
                <a
                href="{{ route('donghua.latest') }}"
                class="text-sky-400 hover:underline">
                View All →
            </a>
    </section>


    {{-- Popular Manga --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Popular Manga
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($popularManga as $manga)

                <a href="{{ route('comic.show',$manga['slug']) }}">

                    <img
                        src="{{ $manga['image'] }}"
                        class="rounded-xl">

                    <h3 class="mt-3 line-clamp-2">

                        {{ $manga['title'] }}

                    </h3>

                </a>

            @endforeach

        </div>

    </section>


    {{-- Latest Manga --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Latest Manga
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($latestManga as $manga)

                <a href="{{ route('comic.show',$manga['slug']) }}">

                    <img
                        src="{{ $manga['image'] }}"
                        class="rounded-xl">

                    <h3 class="mt-3 line-clamp-2">

                        {{ $manga['title'] }}

                    </h3>

                </a>

            @endforeach

        </div>

    </section>
    <section>

 <section>

    <h2 class="mb-6 text-2xl font-bold">
        TEST Recommended Hentai
    </h2>

    <div class="grid grid-cols-2 gap-5 md:grid-cols-4">

        @foreach($recommendedHentai as $item)

            <div class="border border-red-500 p-3">

                <img
                    src="{{ $item['thumbnail'] }}"
                    style="width:100%;height:300px;object-fit:cover;">

                <p>{{ $item['title'] }}</p>

            </div>

        @endforeach

    </div>

</section>

</div>

@endsection