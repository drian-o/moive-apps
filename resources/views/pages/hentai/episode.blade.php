@extends('layouts.app')

@section('content')

<div class="relative min-h-screen overflow-hidden bg-zinc-950">

    {{-- Background --}}
    @if(!empty($episode['thumbnail']))
    <div class="absolute inset-x-0 top-0 -z-10 h-[520px] overflow-hidden">

        <img
            src="{{ route('image.proxy',['url'=>$episode['thumbnail']]) }}"
            class="h-full w-full scale-110 object-cover blur-3xl opacity-20">

        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-zinc-950/70 to-zinc-950"></div>

    </div>
    @endif

    <div class="mx-auto max-w-[1700px] px-5 py-8">

        <div class="grid grid-cols-12 gap-8">

            {{-- PLAYER --}}
            <div class="col-span-12 xl:col-span-9">

                @if(!empty($episode['streams']) && count($episode['streams']))

                <div class="overflow-hidden rounded-[28px] border border-zinc-800 bg-black shadow-2xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-zinc-800 bg-zinc-900 px-6 py-5">

                        <div>

                            <h1 class="text-2xl font-bold">

                                {{ $episode['title'] ?? '-' }}

                            </h1>

                            <p class="mt-1 text-sm text-zinc-400">

                                Streaming Episode

                            </p>

                        </div>

                        <span class="rounded-full bg-pink-600 px-4 py-2 text-xs font-bold uppercase">

                            HD Player

                        </span>

                    </div>

                    {{-- Player --}}
                    <div class="relative">

                        <iframe
                            id="player"
                            src="{{ $episode['streams'][0]['url'] }}"
                            class="aspect-video w-full"
                            frameborder="0"
                            allowfullscreen
                            allow="autoplay; fullscreen">
                        </iframe>

                        {{-- PLAYER ADS --}}
                        @if(!empty($playerAd))

                        <div
                            id="playerAd"
                            class="absolute inset-0 flex items-center justify-center bg-black/50 backdrop-blur-sm">

                            <div class="relative">

                                <button
                                    onclick="document.getElementById('playerAd').remove()"
                                    class="absolute -right-3 -top-3 flex h-9 w-9 items-center justify-center rounded-full bg-red-600 text-white">

                                    ✕

                                </button>

                                <a
                                    href="{{ $playerAd->url }}"
                                    target="{{ $playerAd->target }}">

                                    <img
                                        src="{{ asset('storage/'.$playerAd->image) }}"
                                        class="max-w-[520px] rounded-2xl shadow-2xl">

                                </a>

                            </div>

                        </div>

                        @endif

                    </div>

                </div>

                {{-- SERVER LIST --}}
                <div class="mt-6 flex flex-wrap gap-3">

                    @foreach($episode['streams'] as $index => $stream)

                    <button
                        class="server-btn rounded-full border px-5 py-3 font-semibold transition
                        {{ $index==0
                            ? 'border-pink-600 bg-pink-600 text-white'
                            : 'border-zinc-700 bg-zinc-900 hover:bg-zinc-800'
                        }}"
                        data-url="{{ $stream['url'] }}">

                        {{ $stream['server'] }}

                    </button>

                    @endforeach

                </div>

                @endif

                {{-- INFO --}}
                <div class="mt-8 rounded-[28px] border border-zinc-800 bg-zinc-900 p-8">

                    <h2 class="text-3xl font-black">

                        {{ $episode['title'] ?? '-' }}

                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-4">

                        <div class="rounded-2xl bg-zinc-950 p-5">

                            <div class="text-xs uppercase tracking-wider text-zinc-500">

                                Released

                            </div>

                            <div class="mt-2 font-bold">

                                {{ $episode['released'] ?? '-' }}

                            </div>

                        </div>

                        <div class="rounded-2xl bg-zinc-950 p-5">

                            <div class="text-xs uppercase tracking-wider text-zinc-500">

                                Duration

                            </div>

                            <div class="mt-2 font-bold">

                                {{ $episode['duration'] ?? '-' }}

                            </div>

                        </div>

                        <div class="rounded-2xl bg-zinc-950 p-5">

                            <div class="text-xs uppercase tracking-wider text-zinc-500">

                                Quality

                            </div>

                            <div class="mt-2 font-bold">

                                {{ $episode['quality'] ?? '-' }}

                            </div>

                        </div>

                        <div class="rounded-2xl bg-zinc-950 p-5">

                            <div class="text-xs uppercase tracking-wider text-zinc-500">

                                Size

                            </div>

                            <div class="mt-2 font-bold">

                                {{ $episode['size'] ?? '-' }}

                            </div>

                        </div>

                    </div>

                    @if(!empty($episode['description']))

                    <div class="mt-10">

                        <h3 class="mb-4 text-2xl font-bold">

                            Sinopsis

                        </h3>

                        <div class="leading-8 text-zinc-300">

                            {!! nl2br(e($episode['description'])) !!}

                        </div>

                    </div>

                    @endif

                </div>

            </div>

{{-- SIDEBAR --}}
<div class="col-span-12 xl:col-span-3">

    @if(!empty($sidebarAd))
    <div class="mb-6 overflow-hidden rounded-[28px] border border-zinc-800">

        <a href="{{ $sidebarAd->url }}" target="{{ $sidebarAd->target }}">

            <img
                src="{{ asset('storage/'.$sidebarAd->image) }}"
                class="w-full">

        </a>

    </div>
    @endif

    <div class="sticky top-24 overflow-hidden rounded-[28px] border border-zinc-800 bg-zinc-900">

        @if(!empty($episode['thumbnail']))

        <img
            src="{{ route('image.proxy',['url'=>$episode['thumbnail']]) }}"
            class="w-full">

        @endif

        <div class="p-6">

            <h3 class="text-xl font-bold">

                {{ $episode['title'] ?? '-' }}

            </h3>

            <div class="mt-6 space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-zinc-500">Released</span>
                    <span>{{ $episode['released'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-zinc-500">Duration</span>
                    <span>{{ $episode['duration'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-zinc-500">Quality</span>
                    <span>{{ $episode['quality'] ?? '-' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-zinc-500">Size</span>
                    <span>{{ $episode['size'] ?? '-' }}</span>
                </div>

            </div>

        </div>

    </div>

    {{-- Episode List --}}
    @if(!empty($episodes))

    <div class="mt-6 overflow-hidden rounded-[28px] border border-zinc-800 bg-zinc-900">

        <div class="border-b border-zinc-800 px-5 py-4">

            <h3 class="text-lg font-bold">

                Episode List

            </h3>

        </div>

        <div class="max-h-[550px] overflow-y-auto p-3 space-y-2">

            @foreach($episodes as $ep)

            <a
                href="{{ route('hentai.episode', $ep['slug']) }}"
                class="block rounded-xl border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-pink-600 hover:bg-pink-600 hover:text-white">

                {{ $ep['title'] }}

            </a>

            @endforeach

        </div>

    </div>

    @endif

</div>

</div>

{{-- DOWNLOAD --}}
@if(!empty($episode['downloads']))

<div class="mt-10 overflow-hidden rounded-[28px] border border-zinc-800 bg-zinc-900">

    <div class="border-b border-zinc-800 bg-gradient-to-r from-pink-600 to-fuchsia-600 px-8 py-5">

        <h2 class="text-2xl font-black">

            Download Episode

        </h2>

        <p class="mt-1 text-sm text-pink-100">

            Pilih kualitas download yang tersedia.

        </p>

    </div>

    <div class="space-y-8 p-8">

        @foreach($episode['downloads'] as $download)

        <div class="rounded-2xl border border-zinc-800 bg-zinc-950">

            <div class="border-b border-zinc-800 px-6 py-4">

                <h3 class="text-xl font-bold">

                    {{ $download['quality'] }}

                </h3>

            </div>

            <div class="space-y-4 p-6">

                @foreach($download['links'] as $link)

                <div class="flex flex-col gap-4 rounded-xl border border-zinc-800 bg-zinc-900 p-5 md:flex-row md:items-center md:justify-between">

                    <div>

                        <h4 class="font-bold">

                            {{ $link['host'] }}

                        </h4>

                        <p class="text-sm text-zinc-400">

                            Mirror Download

                        </p>

                    </div>

                    <a
                        href="{{ $link['url'] }}"
                        target="_blank"
                        class="rounded-xl bg-pink-600 px-6 py-3 font-semibold transition hover:bg-pink-500">

                        Download

                    </a>

                </div>

                @endforeach

            </div>

        </div>

        @endforeach

    </div>

</div>

@endif

{{-- FOOTER ADS --}}
@if(!empty($footerAd))

<div class="mt-10">

    <a
        href="{{ $footerAd->url }}"
        target="{{ $footerAd->target }}">

        <img
            src="{{ asset('storage/'.$footerAd->image) }}"
            class="mx-auto w-full max-w-[970px] rounded-3xl">

    </a>

</div>

@endif

</div>
{{-- POPUP ADS --}}
@if(!empty($popupAd))

<div
    id="popupAd"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 backdrop-blur-sm">

    <div class="relative w-[700px] max-w-[92vw]">

        <button
            onclick="document.getElementById('popupAd').remove()"
            class="absolute -right-3 -top-3 flex h-10 w-10 items-center justify-center rounded-full bg-red-600 text-lg font-bold text-white">

            ✕

        </button>

        <a
            href="{{ $popupAd->url }}"
            target="{{ $popupAd->target }}">

            <img
                src="{{ asset('storage/'.$popupAd->image) }}"
                class="w-full rounded-3xl shadow-2xl">

        </a>

    </div>

</div>

@endif

{{-- FLOATING ADS --}}
@if(!empty($floatingAd))

<div
    id="floatingAd"
    class="fixed bottom-5 right-5 z-[9999]">

    <div class="relative">

        <button
            onclick="document.getElementById('floatingAd').remove()"
            class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full bg-red-600 text-xs text-white">

            ✕

        </button>

        <a
            href="{{ $floatingAd->url }}"
            target="{{ $floatingAd->target }}">

            <img
                src="{{ asset('storage/'.$floatingAd->image) }}"
                class="w-[200px] rounded-2xl shadow-2xl">

        </a>

    </div>

</div>

@endif

<script>

document.addEventListener('DOMContentLoaded', function () {

    const player = document.getElementById('player');

    if (player) {

        document.querySelectorAll('.server-btn').forEach(button => {

            button.addEventListener('click', function () {

                document.querySelectorAll('.server-btn').forEach(btn => {

                    btn.classList.remove(
                        'bg-pink-600',
                        'border-pink-600',
                        'text-white'
                    );

                    btn.classList.add(
                        'bg-zinc-900',
                        'border-zinc-700'
                    );

                });

                this.classList.remove(
                    'bg-zinc-900',
                    'border-zinc-700'
                );

                this.classList.add(
                    'bg-pink-600',
                    'border-pink-600',
                    'text-white'
                );

                player.src = this.dataset.url;

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

            });

        });

    }

    @if(!empty($popupAd))

    setTimeout(function () {

        const popup = document.getElementById('popupAd');

        if (popup) {

            popup.classList.remove('hidden');
            popup.classList.add('flex');

        }

    }, 1500);

    @endif

});

</script>

@endsection