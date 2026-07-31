@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Recommended --}}
    <h2 class="mb-5 text-3xl font-bold text-white">🔥 Recommended</h2>

    <div class="grid grid-cols-2 gap-5 md:grid-cols-5">

        @foreach($recommended as $item)

        <a href="{{ route('hentai.episode',$item['slug']) }}"
           class="rounded-xl bg-zinc-900 p-4 hover:bg-zinc-800 transition">

            <div class="text-center font-semibold text-white">
                {{ $item['title'] }}
            </div>

        </a>

        @endforeach

    </div>


    {{-- Latest Hentai --}}
    <h2 class="mt-12 mb-5 text-3xl font-bold text-white">
        🎬 Latest Hentai
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-5">

        @foreach($latestHentai as $item)

        <a href="{{ route('hentai.episode',$item['slug']) }}"
           class="overflow-hidden rounded-xl bg-zinc-900 hover:scale-105 transition">

            <img
                src="/proxy/image?url={{ urlencode($item['thumbnail']) }}"
                class="aspect-[2/3] w-full object-cover">

            <div class="p-3">

                <div class="font-semibold text-white line-clamp-2">
                    {{ $item['title'] }}
                </div>

            </div>

        </a>

        @endforeach

    </div>



    {{-- Latest Episodes --}}
    <h2 class="mt-12 mb-5 text-3xl font-bold text-white">
        📺 Latest Episodes
    </h2>

    <div class="grid md:grid-cols-2 gap-5">

        @foreach($latestEpisodes as $item)

        <a href="{{ route('hentai.episode',$item['slug']) }}"
           class="flex overflow-hidden rounded-xl bg-zinc-900 hover:bg-zinc-800 transition">

            <img
                src="/proxy/image?url={{ urlencode($item['thumbnail']) }}"
                class="w-60 object-cover">

            <div class="p-4">

                <div class="font-semibold text-white">
                    {{ $item['title'] }}
                </div>

                <div class="mt-2 text-sm text-gray-400">
                    {{ $item['date'] }}
                </div>

            </div>

        </a>

        @endforeach

    </div>



    {{-- Latest JAV --}}
    <h2 class="mt-12 mb-5 text-3xl font-bold text-white">
        🎥 Latest JAV
    </h2>

    <div class="grid md:grid-cols-4 gap-5">

        @foreach($latestJav as $item)

        <a href="{{ route('hentai.episode',$item['slug']) }}"
           class="overflow-hidden rounded-xl bg-zinc-900 hover:scale-105 transition">

            <img
                src="/proxy/image?url={{ urlencode($item['thumbnail']) }}"
                class="aspect-video w-full object-cover">

            <div class="p-3">

                <div class="font-semibold line-clamp-2 text-white">
                    {{ $item['title'] }}
                </div>

                <div class="text-sm text-gray-400 mt-2">
                    {{ $item['date'] }}
                </div>

            </div>

        </a>

        @endforeach

    </div>

</div>
@endsection