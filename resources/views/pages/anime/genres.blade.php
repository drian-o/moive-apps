@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-white">
            Browse Genres
        </h1>

        <p class="mt-2 text-zinc-400">
            Temukan anime berdasarkan genre favoritmu.
        </p>

    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">

        @foreach($genres as $genre)

            <a
                href="{{ route('anime.genre',$genre['genreId']) }}"
                class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-5 transition duration-300 hover:border-sky-500 hover:bg-sky-500">

                <div class="text-lg font-semibold text-white">

                    {{ $genre['title'] }}

                </div>

                <div class="mt-2 text-sm text-zinc-400 group-hover:text-white">

                    Browse Anime →

                </div>

            </a>

        @endforeach

    </div>

</div>

@endsection