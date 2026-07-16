@extends('layouts.app')

@section('content')

<div class="space-y-14">

    {{-- Hero --}}
    <section class="max-w-7xl">

        <h1 class="text-6xl font-bold">
            Watch Anime
            <span class="text-indigo-500">Anywhere.</span>
        </h1>

        <p class="mt-6 max-w-2xl text-lg text-zinc-400">
            Stream anime, donghua, and manga in one place.
        </p>

    </section>


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

            @foreach($latestDonghua as $donghua)

                <x-anime-card
                    :id="$donghua['slug']"
                    :route="'donghua.show'"
                    :image="$donghua['poster']"
                    :title="$donghua['title']"
                    :episode="$donghua['current_episode']"
                />

            @endforeach

        </div>

    </section>


    {{-- Completed Donghua --}}
    <section>

        <h2 class="mb-6 text-2xl font-bold">
            Completed Donghua
        </h2>

        <div class="grid grid-cols-2 gap-5 md:grid-cols-4 xl:grid-cols-6">

            @foreach($completedDonghua as $donghua)

                <x-anime-card
                    :id="$donghua['slug']"
                    :route="'donghua.show'"
                    :image="$donghua['poster']"
                    :title="$donghua['title']"
                    :episode="$donghua['current_episode'] ?? 'Completed'"
                />

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

                <x-anime-card
                    :id="$manga['slug']"
                    :route="'comic.show'"
                    :image="$manga['image']"
                    :title="$manga['title']"
                    :episode="$manga['chapter']"
                />

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

                <x-anime-card
                    :id="$manga['slug']"
                    :route="'comic.show'"
                    :image="$manga['image']"
                    :title="$manga['title']"
                    :episode="$manga['chapters'][0]['chapter'] ?? 'New'"
                />

            @endforeach

        </div>

    </section>

</div>

@endsection