@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- Hero --}}
    <section class="overflow-hidden rounded-3xl bg-zinc-900">

        <div class="flex flex-col lg:flex-row">

            {{-- Poster --}}
            <div class="w-full lg:w-[320px]">

                <img
                    src="{{ $donghua['poster'] }}"
                    alt="{{ $donghua['title'] }}"
                    class="h-[500px] w-full object-cover">

            </div>

            {{-- Detail --}}
            <div class="flex flex-1 flex-col p-8 lg:p-10">

                <div class="mb-4 flex flex-wrap gap-2">

                    <span class="rounded-full bg-sky-500 px-4 py-1 text-xs font-bold">

                        {{ $donghua['type'] }}

                    </span>

                    <span class="rounded-full bg-zinc-800 px-4 py-1 text-xs">

                        ⭐ {{ $donghua['rating'] }}

                    </span>

                    <span class="rounded-full bg-green-600 px-4 py-1 text-xs">

                        {{ $donghua['status'] }}

                    </span>

                </div>

                <h1 class="text-4xl font-black">

                    {{ $donghua['title'] }}

                </h1>

                @if($donghua['alter_title'])

                    <p class="mt-2 text-zinc-400">

                        {{ $donghua['alter_title'] }}

                    </p>

                @endif


                {{-- Info --}}
                <div class="mt-8 grid grid-cols-2 gap-5 lg:grid-cols-3">

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Studio

                        </p>

                        <p>{{ $donghua['studio'] }}</p>

                    </div>

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Network

                        </p>

                        <p>{{ $donghua['network'] }}</p>

                    </div>

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Country

                        </p>

                        <p>{{ $donghua['country'] }}</p>

                    </div>

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Episodes

                        </p>

                        <p>{{ $donghua['episodes_count'] }}</p>

                    </div>

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Duration

                        </p>

                        <p>{{ $donghua['duration'] }}</p>

                    </div>

                    <div>

                        <p class="text-xs uppercase text-zinc-500">

                            Released

                        </p>

                        <p>{{ $donghua['released_on'] }}</p>

                    </div>

                </div>


                {{-- Genre --}}
                <div class="mt-8 flex flex-wrap gap-2">

@foreach($donghua['genres'] as $genre)

    <a
        href="{{ route('donghua.genre', ['genre' => $genre['slug']]) }}"
        class="rounded-full bg-zinc-800 px-4 py-2 text-sm transition hover:bg-sky-500">

        {{ $genre['name'] }}

    </a>

@endforeach

                </div>

            </div>

        </div>

    </section>



    {{-- Synopsis --}}
    <section class="mt-10 rounded-3xl bg-zinc-900 p-8">

        <h2 class="mb-5 text-2xl font-bold">

            Synopsis

        </h2>

        <p class="leading-8 text-zinc-300">

            {{ $donghua['synopsis'] }}

        </p>

    </section>



    {{-- Episode List --}}
    <section class="mt-10">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold">

                Episode List

            </h2>

            <span class="text-zinc-500">

                {{ count($donghua['episodes_list']) }} Episodes

            </span>

        </div>

        <div class="grid gap-3">

            @foreach($donghua['episodes_list'] as $episode)

                <a
                    href="{{ route('donghua.watch',$episode['slug']) }}"
                    class="flex items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-900 px-6 py-4 transition hover:border-sky-500 hover:bg-zinc-800">

                    <div>

                        <h3 class="font-semibold">

                            {{ $episode['episode'] }}

                        </h3>

                    </div>

                    <div
                        class="rounded-lg bg-sky-500 px-4 py-2 text-sm font-semibold">

                        Watch

                    </div>

                </a>

            @endforeach

        </div>

    </section>

</div>

@endsection