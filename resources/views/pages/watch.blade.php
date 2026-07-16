@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    <div class="grid grid-cols-12 gap-6">

        {{-- PLAYER --}}
        <div class="col-span-12 xl:col-span-9">

            <div class="overflow-hidden rounded-2xl bg-black">

                <iframe
                    src="{{ $watch['player'] }}"
                    class="aspect-video w-full"
                    allowfullscreen
                    allow="autoplay; fullscreen">
                </iframe>

            </div>

            <div class="mt-6 rounded-2xl bg-zinc-900 p-6">

                <h1 class="text-2xl font-bold">
                    {{ $watch['title'] }}
                </h1>

                @if(!empty($watch['subtitle']))
                    <p class="mt-2 text-zinc-400">
                        {{ $watch['subtitle'] }}
                    </p>
                @endif

                @if(!empty($watch['release']))
                    <p class="mt-4 text-sm text-zinc-500">
                        {{ $watch['release'] }}
                    </p>
                @endif

            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-span-12 xl:col-span-3">

            {{-- Poster --}}
            @if(!empty($watch['poster']))
            <div class="rounded-2xl bg-zinc-900 p-5">

                <img
                    src="{{ $watch['poster'] }}"
                    class="mb-4 w-full rounded-xl">

                <h2 class="text-xl font-bold">
                    {{ $watch['subtitle'] }}
                </h2>

            </div>
            @endif

            {{-- Episode --}}
            @if(count($watch['episodes']))
            <div class="mt-6 rounded-2xl bg-zinc-900 p-5">

                <h2 class="mb-4 text-xl font-bold">
                    Episode
                </h2>

                <div class="max-h-[600px] space-y-2 overflow-y-auto">

                    @foreach($watch['episodes'] as $ep)

                        <a
                            href="{{ $ep['url'] }}"
                            class="block rounded-lg bg-zinc-800 px-4 py-3 transition hover:bg-sky-500">

                            {{ $ep['title'] }}

                        </a>

                    @endforeach

                </div>

            </div>
            @endif

        </div>

    </div>

</div>

@endsection