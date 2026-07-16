@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- Player --}}
    <section class="overflow-hidden rounded-3xl bg-zinc-900">

        <div class="aspect-video w-full">

            <iframe
                src="{{ $episode['streaming']['main_url']['url'] }}"
                class="h-full w-full"
                allowfullscreen
                frameborder="0">
            </iframe>

        </div>

    </section>


    {{-- Judul --}}
    <section class="mt-8">

        <h1 class="text-3xl font-bold">

            {{ $episode['episode'] }}

        </h1>

        <div class="mt-2 text-zinc-400">

            {{ $episode['donghua_details']['title'] }}

        </div>

    </section>


    {{-- Server --}}
    @if(!empty($episode['streaming']['servers']))

    <section class="mt-10">

        <h2 class="mb-4 text-xl font-bold">
            Streaming Server
        </h2>

        <div class="flex flex-wrap gap-3">

            @foreach($episode['streaming']['servers'] as $server)

                <a
                    href="{{ $server['url'] }}"
                    target="_blank"
                    class="rounded-xl bg-sky-500 px-5 py-3 font-semibold hover:bg-sky-600">

                    {{ $server['name'] }}

                </a>

            @endforeach

        </div>

    </section>

    @endif


    {{-- Download --}}
    @if(!empty($episode['download_url']))

    <section class="mt-12">

        <h2 class="mb-5 text-xl font-bold">
            Download
        </h2>

        @foreach($episode['download_url'] as $quality => $links)

            <div class="mb-5 rounded-2xl bg-zinc-900 p-5">

                <h3 class="mb-3 font-semibold uppercase">

                    {{ str_replace('download_url_', '', $quality) }}

                </h3>

                <div class="flex flex-wrap gap-3">

                    @foreach($links as $host => $url)

                        <a
                            href="{{ $url }}"
                            target="_blank"
                            class="rounded-lg border border-zinc-700 px-4 py-2 hover:border-sky-500">

                            {{ $host }}

                        </a>

                    @endforeach

                </div>

            </div>

        @endforeach

    </section>

    @endif


    {{-- Episode --}}
    <section class="mt-12">

        <div class="mb-5 flex items-center justify-between">

            <h2 class="text-xl font-bold">

                Semua Episode

            </h2>

            <span class="text-zinc-500">

                {{ count($episode['episodes_list']) }} Episode

            </span>

        </div>

        <div class="grid gap-3">

            @foreach($episode['episodes_list'] as $ep)

                <a
                    href="{{ route('donghua.watch', $ep['slug']) }}"
                    class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-900 px-5 py-4 transition hover:border-sky-500">

                    <span>

                        {{ $ep['episode'] }}

                    </span>

                    <span class="text-sky-400">

                        ▶ Watch

                    </span>

                </a>

            @endforeach

        </div>

    </section>

</div>

@endsection