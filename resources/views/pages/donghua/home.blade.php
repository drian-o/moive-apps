@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    {{-- Hero --}}
    @if(count($latest))

        @php
            $hero = $latest[0];
        @endphp

        <section class="mb-12 overflow-hidden rounded-3xl bg-zinc-900">

            <div class="flex flex-col lg:flex-row">

                <div class="w-full lg:w-[320px]">
                    <img
                        src="{{ $hero['poster'] }}"
                        alt="{{ $hero['title'] }}"
                        class="h-[260px] w-full object-cover sm:h-[360px] lg:h-full">
                </div>

                <div class="flex flex-1 flex-col justify-center p-8">

                    <span class="mb-4 w-fit rounded-full bg-sky-500 px-4 py-2 text-xs font-semibold">
                        Latest Release
                    </span>

                    <h1 class="text-3xl font-bold lg:text-5xl">
                        {{ $hero['title'] }}
                    </h1>

                    <div class="mt-4 flex flex-wrap gap-4 text-zinc-400">
                        <span>🎬 {{ $hero['current_episode'] }}</span>
                        <span>{{ $hero['status'] }}</span>
                    </div>

                    {{-- Tombol Watch tetap ke player --}}
                    <a
                        href="{{ route('donghua.watch', $hero['slug']) }}"
                        class="mt-8 inline-flex w-fit rounded-xl bg-sky-500 px-6 py-3 font-semibold hover:bg-sky-600">
                        ▶ Watch Now
                    </a>

                </div>

            </div>

        </section>

    @endif


    {{-- Latest Release --}}
    <section class="mb-14">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold">
                Latest Release
            </h2>

            <a
                href="{{ route('donghua.latest') }}"
                class="text-sky-400 hover:underline">
                View All →
            </a>

        </div>

        <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-6">

            @foreach($latest as $anime)

                <x-anime-card
                    :route="'donghua.show'"
                    :id="$anime['slug']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="$anime['current_episode']"
                />

            @endforeach

        </div>

    </section>


    {{-- Completed --}}
    <section>

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold">
                Completed Donghua
            </h2>

            <a
                href="{{ route('donghua.completed') }}"
                class="text-sky-400 hover:underline">
                View All →
            </a>

        </div>

        <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-6">

            @foreach($completed as $anime)

                <x-anime-card
                    :route="'donghua.show'"
                    :id="$anime['slug']"
                    :image="$anime['poster']"
                    :title="$anime['title']"
                    :episode="'Completed'"
                />

            @endforeach

        </div>

    </section>

</div>

@endsection