@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-[1600px]">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white">
            Search Result
        </h1>

        @if($keyword)
            <p class="mt-3 text-zinc-400">
                Menampilkan hasil untuk
                <span class="font-semibold text-sky-400">
                    "{{ $keyword }}"
                </span>
            </p>
        @endif
    </div>

    {{-- Anime --}}
    @if(!empty($anime['results']))
        <div class="mb-10">
            <h2 class="mb-5 text-2xl font-bold text-white">
                Anime
            </h2>

            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                @foreach($anime['results'] as $item)
                    <x-anime-card
                        :id="$item['animeId']"
                        :image="$item['poster']"
                        :title="$item['title']"
                        :episode="'⭐ '.$item['score']"
                        route="anime.show"
                    />
                @endforeach
            </div>
        </div>
    @endif

    {{-- Donghua --}}
    @if(!empty($donghua['results']))
        <div class="mb-10">
            <h2 class="mb-5 text-2xl font-bold text-white">
                Donghua
            </h2>

            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                @foreach($donghua['results'] as $item)
                    <x-anime-card
                        :id="$item['slug']"
                        :image="$item['poster']"
                        :title="$item['title']"
                        :episode="$item['episode']"
                        route="donghua.show"
                    />
                @endforeach
            </div>
        </div>
    @endif

    {{-- Manga --}}
    @if(!empty($comic['results']))
        <div class="mb-10">
            <h2 class="mb-5 text-2xl font-bold text-white">
                Manga
            </h2>

            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
                @foreach($comic['results'] as $item)
                    <x-anime-card
                        :id="$item['slug']"
                        :image="$item['image']"
                        :title="$item['title']"
                        :episode="$item['chapter']"
                        route="comic.show"
                    />
                @endforeach
            </div>
        </div>
    @endif

    @if(
        empty($anime['results']) &&
        empty($donghua['results']) &&
        empty($comic['results'])
    )
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 py-20 text-center">
            <h2 class="text-2xl font-bold text-white">
                Tidak ada hasil ditemukan
            </h2>

            <p class="mt-3 text-zinc-400">
                Coba gunakan kata kunci lain.
            </p>
        </div>
    @endif

</div>
@endsection