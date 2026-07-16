@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    {{-- Header --}}
    <div class="mb-10 flex items-center justify-between">

        <div>

            <h1 class="text-4xl font-bold">

                Browse Anime

            </h1>

            <p class="mt-2 text-zinc-400">

                Jelajahi seluruh anime berdasarkan alfabet.

            </p>

        </div>

    </div>

    {{-- Alphabet --}}
    <div class="mb-10 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900">

        <div class="grid grid-cols-7 md:grid-cols-14 lg:grid-cols-[repeat(14,minmax(0,1fr))]">

            @foreach(range('A','Z') as $letter)

                <a
                    href="{{ route('anime.letter',$letter) }}"
                    class="border border-zinc-800 py-4 text-center font-semibold transition hover:bg-sky-500">

                    {{ $letter }}

                </a>

            @endforeach

            <a
                href="{{ route('anime.unlimited') }}"
                class="border border-zinc-800 bg-sky-500 py-4 text-center font-bold">

                ALL

            </a>

        </div>

    </div>

    {{-- Anime List --}}
    @foreach($list as $group)

        <section class="mb-14">

            <div class="mb-6 flex items-center gap-4">

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-500 text-2xl font-bold">

                    {{ $group['startWith'] }}

                </div>

                <h2 class="text-3xl font-bold">

                    {{ $group['startWith'] }}

                </h2>

            </div>

            <div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-6">

                @foreach($group['animeList'] as $anime)

                    <a
                        href="{{ route('anime.show',$anime['animeId']) }}"
                        class="group overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 transition hover:border-sky-500">

                        <div class="p-5">

                            <h3 class="line-clamp-2 min-h-[48px] font-semibold transition group-hover:text-sky-400">

                                {{ $anime['title'] }}

                            </h3>

                            <div class="mt-4 flex items-center justify-between">

                                <span class="text-xs text-zinc-500">

                                    {{ $group['startWith'] }}

                                </span>

                                <span class="text-sky-400">

                                    →

                                </span>

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>

        </section>

    @endforeach

</div>

@endsection