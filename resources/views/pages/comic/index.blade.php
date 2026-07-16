@extends('layouts.app')

@section('title', 'SoftKomik')

@section('content')

<div class="max-w-7xl mx-auto space-y-12">

    {{-- HOT COMICS --}}
    <section>

        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold">

                🔥 Hot Comics

            </h2>

        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">

            @forelse($homepage['hotComics'] ?? [] as $comic)

                <a
                    href="{{ route('comic.show',$comic['slug']) }}"
                    class="group">

                    <div
                        class="overflow-hidden rounded-xl bg-zinc-900 shadow hover:bg-zinc-800 transition">

                        <img
                            src="{{ $comic['image'] }}"
                            alt="{{ $comic['title'] }}"
                            class="h-72 w-full object-cover group-hover:scale-105 transition duration-300">

                        <div class="p-3">

                            <h3
                                class="line-clamp-2 font-semibold">

                                {{ $comic['title'] }}

                            </h3>

                            <div class="mt-3">

                                <span
                                    class="rounded bg-red-600 px-2 py-1 text-xs">

                                    {{ $comic['chapter'] }}

                                </span>

                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="col-span-full">

                    Tidak ada data.

                </div>

            @endforelse

        </div>

    </section>

    {{-- LATEST UPDATE --}}
    <section>

        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold">

                📚 Latest Update

            </h2>

        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">

            @forelse($homepage['latestUpdates'] ?? [] as $comic)

                <a
                    href="{{ route('comic.show',$comic['slug']) }}"
                    class="group">

                    <div
                        class="overflow-hidden rounded-xl bg-zinc-900 shadow hover:bg-zinc-800 transition">

                        <img
                            src="{{ $comic['image'] }}"
                            alt="{{ $comic['title'] }}"
                            class="h-72 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-3">

                            <h3
                                class="line-clamp-2 font-semibold">

                                {{ $comic['title'] }}

                            </h3>

                            @if(isset($comic['chapters'][0]))

                                <div
                                    class="mt-3 text-sm text-zinc-400">

                                    {{ $comic['chapters'][0]['title'] }}

                                </div>

                                <div
                                    class="text-xs text-zinc-500 mt-1">

                                    {{ $comic['chapters'][0]['time'] }}

                                </div>

                            @endif

                        </div>

                    </div>

                </a>

            @empty

                <div class="col-span-full">

                    Tidak ada data.

                </div>

            @endforelse

        </div>

    </section>

    {{-- POPULAR TODAY --}}
    <section>

        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold">

                ⭐ Popular Today

            </h2>

        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">

            @forelse($homepage['popularToday'] ?? [] as $comic)

                <a
                    href="{{ route('comic.show',$comic['slug']) }}"
                    class="group">

                    <div
                        class="overflow-hidden rounded-xl bg-zinc-900 shadow hover:bg-zinc-800 transition">

                        <img
                            src="{{ $comic['image'] }}"
                            alt="{{ $comic['title'] }}"
                            class="h-72 w-full object-cover group-hover:scale-105 transition">

                        <div class="p-3">

                            <h3
                                class="line-clamp-2 font-semibold">

                                {{ $comic['title'] }}

                            </h3>

                            <div
                                class="mt-3 flex items-center justify-between">

                                <span
                                    class="text-xs text-zinc-400">

                                    {{ $comic['chapter'] }}

                                </span>

                                <span
                                    class="rounded bg-yellow-500 px-2 py-1 text-xs font-bold text-black">

                                    ⭐ {{ $comic['rating'] }}

                                </span>

                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="col-span-full">

                    Tidak ada data.

                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection