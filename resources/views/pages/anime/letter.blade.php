@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    <div class="mb-10 flex items-center justify-between">

        <div>

            <h1 class="text-5xl font-bold">

                {{ $letter }}

            </h1>

            <p class="mt-2 text-zinc-400">

                Semua anime yang diawali huruf {{ $letter }}

            </p>

        </div>

        <a
            href="{{ route('anime.unlimited') }}"
            class="rounded-xl border border-zinc-700 px-6 py-3 transition hover:border-sky-500">

            ← Browse A-Z

        </a>

    </div>

    {{-- Alphabet --}}
    <div class="mb-10 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900">

        <div class="grid grid-cols-7 md:grid-cols-14">

            @foreach(range('A','Z') as $char)

                <a
                    href="{{ route('anime.letter',$char) }}"
                    class="border border-zinc-800 py-4 text-center font-semibold transition

                    {{ $char==$letter
                        ? 'bg-sky-500'
                        : 'hover:bg-zinc-800'
                    }}">

                    {{ $char }}

                </a>

            @endforeach

        </div>

    </div>

    <div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-6">

        @foreach($results as $anime)

            <a
                href="{{ route('anime.show',$anime['animeId']) }}"
                class="group rounded-2xl border border-zinc-800 bg-zinc-900 p-5 transition hover:border-sky-500">

                <h3 class="line-clamp-2 min-h-[50px] font-semibold group-hover:text-sky-400">

                    {{ $anime['title'] }}

                </h3>

                <div class="mt-4 text-xs text-zinc-500">

                    Anime

                </div>

            </a>

        @endforeach

    </div>

</div>

@endsection