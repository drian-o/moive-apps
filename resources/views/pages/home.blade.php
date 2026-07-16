@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px] space-y-16">

    {{-- HERO --}}
    @if(!empty($ongoingAnime))

    @php($hero = $ongoingAnime[0])

    <section class="overflow-hidden rounded-3xl bg-zinc-900">

        <div class="flex flex-col lg:flex-row">

            <img
                src="{{ $hero['poster'] }}"
                class="w-full lg:w-[330px] h-[420px] object-cover">

            <div class="flex flex-1 flex-col justify-center p-10">

                <span class="mb-4 w-fit rounded-full bg-sky-500 px-4 py-2 text-sm">
                    Ongoing Anime
                </span>

                <h1 class="text-5xl font-bold">
                    {{ $hero['title'] }}
                </h1>

                <p class="mt-6 text-zinc-400">

                    Episode {{ $hero['episodes'] }}

                </p>

                <a
                    href="{{ route('anime.show',$hero['animeId']) }}"
                    class="mt-8 w-fit rounded-xl bg-sky-500 px-8 py-3 font-semibold">

                    Watch Now

                </a>

            </div>

        </div>

    </section>

    @endif


    {{-- Ongoing Anime --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Ongoing Anime
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($ongoingAnime as $anime)

                <x-anime-card
                    :id="$anime['animeId']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="'EP '.$anime['episodes']"
                />

            @endforeach

        </div>

    </section>


    {{-- Completed Anime --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Completed Anime
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($completedAnime as $anime)

                <x-anime-card
                    :id="$anime['animeId']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="'⭐ '.$anime['score']"
                />

            @endforeach

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

</div>

@endsection