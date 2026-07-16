@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1600px]">

    <div class="mb-10 flex items-center justify-between">

        <div>

            <h1 class="text-4xl font-bold">

                {{ ucfirst(str_replace('-', ' ', $genre)) }}

            </h1>

            <p class="mt-2 text-zinc-400">

                Anime dengan genre {{ ucfirst(str_replace('-', ' ', $genre)) }}

            </p>

        </div>

        <a
            href="{{ route('anime.genres') }}"
            class="rounded-xl border border-zinc-700 px-5 py-3 transition hover:border-sky-500 hover:text-sky-400">

            ← Semua Genre

        </a>

    </div>

    @if(count($results))

        <div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-6">

            @foreach($results as $anime)

                <x-anime-card
                    :id="$anime['animeId']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="$anime['status']"
                />

            @endforeach

        </div>

    @else

        <div class="rounded-2xl bg-zinc-900 py-20 text-center">

            <h2 class="text-2xl font-bold">

                Tidak ada anime

            </h2>

            <p class="mt-3 text-zinc-400">

                Belum ada anime untuk genre ini.

            </p>

        </div>

    @endif

</div>

@endsection