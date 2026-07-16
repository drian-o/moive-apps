@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-10 lg:flex-row">

        {{-- Poster --}}
        <div class="w-full lg:w-72 shrink-0">

            <img
                src="{{ $anime['poster'] }}"
                alt="{{ $anime['title'] }}"
                class="w-full rounded-2xl shadow-xl">

        </div>

        {{-- Info --}}
        <div class="flex-1">

            <h1 class="text-5xl font-bold">

                {{ $anime['title'] }}

            </h1>

            <p class="mt-2 text-zinc-400">

                {{ $anime['japanese'] }}

            </p>

            <div class="mt-6 flex flex-wrap gap-3">

                <span class="rounded-lg bg-sky-500 px-4 py-2">
                    ⭐ {{ $anime['score'] }}
                </span>

                <span class="rounded-lg bg-zinc-800 px-4 py-2">
                    {{ $anime['type'] }}
                </span>

                <span class="rounded-lg bg-zinc-800 px-4 py-2">
                    {{ $anime['status'] }}
                </span>

                <span class="rounded-lg bg-zinc-800 px-4 py-2">
                    {{ $anime['duration'] }}
                </span>

            </div>

            {{-- Genre --}}
            <div class="mt-8 flex flex-wrap gap-2">

                @foreach($anime['genreList'] as $genre)

                    <span class="rounded-full bg-zinc-800 px-4 py-2 text-sm">

                        {{ $genre['title'] }}

                    </span>

                @endforeach

            </div>

            {{-- Info --}}
            <div class="mt-8 grid grid-cols-2 gap-4 text-sm">

                <div>

                    <span class="text-zinc-500">Studio</span>

                    <p>{{ $anime['studios'] }}</p>

                </div>

                <div>

                    <span class="text-zinc-500">Producer</span>

                    <p>{{ $anime['producers'] }}</p>

                </div>

                <div>

                    <span class="text-zinc-500">Released</span>

                    <p>{{ $anime['aired'] }}</p>

                </div>

            </div>

        </div>

    </div>

    {{-- Synopsis --}}
    @if(!empty($anime['synopsis']['paragraphs']))

    <section class="mt-16">

        <h2 class="text-3xl font-bold mb-6">

            Synopsis

        </h2>

        <div class="rounded-xl bg-zinc-900 p-8 space-y-5 leading-8 text-zinc-300">

            @foreach($anime['synopsis']['paragraphs'] as $text)

                <p>{{ $text }}</p>

            @endforeach

        </div>

    </section>

    @endif

    {{-- Episode --}}
    <section class="mt-16">

        <h2 class="text-3xl font-bold mb-6">

            Episode List

        </h2>

        <div class="grid gap-3">

            @foreach($anime['episodeList'] as $episode)

                <a
                    href="{{ route('watch',$episode['episodeId']) }}"
                    class="flex items-center justify-between rounded-xl bg-zinc-900 px-6 py-5 hover:bg-zinc-800 transition">

                    <div>

                        <h3 class="font-semibold">

                            Episode {{ $episode['eps'] }}

                        </h3>

                        <p class="text-sm text-zinc-400">

                            {{ $episode['date'] }}

                        </p>

                    </div>

                    <span class="text-sky-400">

                        ▶ Watch

                    </span>

                </a>

            @endforeach

        </div>

    </section>

    {{-- Recommended --}}
    @if(!empty($anime['recommendedAnimeList']))

    <section class="mt-16">

        <h2 class="text-3xl font-bold mb-6">

            Recommended Anime

        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-5">

            @foreach($anime['recommendedAnimeList'] as $item)

                <x-anime-card
                    :id="$item['animeId']"
                    :image="$item['poster']"
                    :title="$item['title']"
                    episode=""
                />

            @endforeach

        </div>

    </section>

    @endif

</div>

@endsection