@extends('layouts.app')

@section('title', $comic['title'])

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- Cover --}}
        <div>

            <img
                src="{{ $comic['image'] }}"
                alt="{{ $comic['title'] }}"
                class="w-full rounded-xl shadow-lg">

        </div>

        {{-- Detail --}}
        <div class="lg:col-span-3">

            <h1 class="text-3xl font-bold">

                {{ $comic['title'] }}

            </h1>

            @if(!empty($comic['alternativeTitle']))

                <p class="text-zinc-400 mt-2">

                    {{ $comic['alternativeTitle'] }}

                </p>

            @endif

            <div class="flex flex-wrap items-center gap-3 mt-5">

                <span class="bg-yellow-500 text-black px-4 py-1 rounded-lg font-semibold">

                    ⭐ {{ $comic['rating'] }}

                </span>

            </div>

            @if(!empty($comic['genres']))

                <div class="flex flex-wrap gap-2 mt-5">

                    @foreach($comic['genres'] as $genre)

                        <a
                            href="{{ route('comic.genre',$genre['id']) }}"
                            class="bg-blue-600 hover:bg-blue-500 rounded-full px-3 py-1 text-sm">

                            {{ $genre['name'] }}

                        </a>

                    @endforeach

                </div>

            @endif

            <div class="mt-8">

                <h2 class="text-xl font-bold mb-3">

                    Sinopsis

                </h2>

                <p class="leading-8 text-zinc-300">

                    {{ $comic['synopsis'] }}

                </p>

            </div>

        </div>

    </div>

    {{-- Chapter --}}
    <div class="mt-10">

        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold">

                Daftar Chapter

            </h2>

            <span class="text-zinc-400">

                {{ count($comic['chapters']) }} Chapter

            </span>

        </div>

        <div class="grid gap-3">

            @forelse($comic['chapters'] as $item)

                @php
                    $slug = trim($item['slug'],'/');
                @endphp

                <a
                    href="{{ route('comic.chapter',$slug) }}"
                    class="flex justify-between items-center rounded-xl bg-zinc-900 hover:bg-zinc-800 transition px-5 py-4">

                    <div>

                        <div class="font-semibold">

                            {{ $item['title'] }}

                        </div>

                        <div class="text-zinc-500 text-sm mt-1">

                            {{ $item['date'] }}

                        </div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            @empty

                <div class="rounded-xl bg-zinc-900 p-6 text-center">

                    Belum ada chapter.

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection