@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px] px-4 py-6">

    <div class="grid grid-cols-12 gap-6">

        {{-- PLAYER --}}
        <div class="col-span-12 xl:col-span-9">

            @if(!empty($episode['streams']))
            <div class="relative overflow-hidden rounded-xl bg-black border border-zinc-800">

                <iframe
                    id="player"
                    src="{{ $episode['streams'][0]['url'] }}"
                    class="aspect-video w-full"
                    frameborder="0"
                    allowfullscreen
                    allow="autoplay; fullscreen">
                </iframe>

                {{-- Player Ads --}}
                @if($playerAd)
                <div
                    id="playerAd"
                    class="absolute inset-0 z-30 flex items-center justify-center bg-black/30">

                    <div class="relative w-[500px] max-w-[50%]">

                        <button
                            onclick="document.getElementById('playerAd').remove()"
                            class="absolute -top-3 -right-3 flex h-8 w-8 items-center justify-center rounded-full bg-red-600 text-white">

                            ✕

                        </button>

                        <a href="{{ $playerAd->url }}"
                           target="{{ $playerAd->target }}">

                            <img
                                src="{{ asset('storage/'.$playerAd->image) }}"
                                class="w-full rounded-xl shadow-2xl">

                        </a>

                    </div>

                </div>
                @endif

            </div>

            {{-- SERVER --}}
            <div class="mt-4 flex flex-wrap gap-2">

                @foreach($episode['streams'] as $index=>$stream)

                    <button
                        data-url="{{ $stream['url'] }}"
                        class="server-btn rounded-lg border border-zinc-700 px-4 py-2 text-sm transition
                        {{ $index==0 ? 'bg-sky-600 text-white border-sky-600' : 'bg-zinc-900 hover:bg-zinc-800' }}">

                        {{ $stream['server'] }}

                    </button>

                @endforeach

            </div>

            @endif

            {{-- INFO --}}
            <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-900 p-6">

                <h1 class="text-2xl font-bold">

                    {{ $episode['title'] }}

                </h1>

                @if(!empty($episode['description']))

                <div class="mt-5 leading-8 text-zinc-300">

                    {!! nl2br(e($episode['description'])) !!}

                </div>

                @endif

                <div class="mt-6 grid gap-4 md:grid-cols-4">

                    <div class="rounded-lg bg-zinc-950 p-4">

                        <div class="text-xs text-zinc-500">

                            Released

                        </div>

                        <div class="mt-1 font-semibold">

                            {{ $episode['released'] ?? '-' }}

                        </div>

                    </div>

                    <div class="rounded-lg bg-zinc-950 p-4">

                        <div class="text-xs text-zinc-500">

                            Duration

                        </div>

                        <div class="mt-1 font-semibold">

                            {{ $episode['duration'] ?? '-' }}

                        </div>

                    </div>

                    <div class="rounded-lg bg-zinc-950 p-4">

                        <div class="text-xs text-zinc-500">

                            Quality

                        </div>

                        <div class="mt-1 font-semibold">

                            {{ $episode['quality'] ?? '-' }}

                        </div>

                    </div>

                    <div class="rounded-lg bg-zinc-950 p-4">

                        <div class="text-xs text-zinc-500">

                            Size

                        </div>

                        <div class="mt-1 font-semibold">

                            {{ $episode['size'] ?? '-' }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="col-span-12 xl:col-span-3">

            @if($sidebarAd)
            <div class="mb-5">

                <a href="{{ $sidebarAd->url }}"
                   target="{{ $sidebarAd->target }}">

                    <img
                        src="{{ asset('storage/'.$sidebarAd->image) }}"
                        class="w-full rounded-xl">

                </a>

            </div>
            @endif

            @if(!empty($episode['thumbnail']))
            <div class="rounded-xl bg-zinc-900 border border-zinc-800 overflow-hidden">

                <img
                    src="{{ route('image.proxy',['url'=>$episode['thumbnail']]) }}"
                    class="w-full">

                <div class="p-5">

                    <h2 class="font-bold text-lg">

                        {{ $episode['title'] }}

                    </h2>

                    <div class="mt-4 space-y-3 text-sm">

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
            @endif
                        {{-- EPISODE LIST --}}
            @if(!empty($episode['episodes']) && count($episode['episodes']))

            <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-900">

                <div class="border-b border-zinc-800 px-5 py-4">

                    <h3 class="text-lg font-bold">

                        Episode

                    </h3>

                </div>

                <div class="max-h-[650px] overflow-y-auto p-4 space-y-2">

                    @foreach($episode['episodes'] as $ep)

                        <a
                            href="{{ $ep['url'] }}"
                            class="block rounded-lg border border-zinc-800 bg-zinc-950 px-4 py-3 transition hover:border-sky-500 hover:bg-sky-600 hover:text-white">

                            {{ $ep['title'] }}

                        </a>

                    @endforeach

                </div>

            </div>

            @endif

        </div>

    </div>

    {{-- FOOTER ADS --}}
    @if($footerAd)

    <div class="mt-8">

        <a
            href="{{ $footerAd->url }}"
            target="{{ $footerAd->target }}">

            <img
                src="{{ asset('storage/'.$footerAd->image) }}"
                class="mx-auto w-full max-w-[970px] rounded-xl">

        </a>

    </div>

    @endif

    {{-- DOWNLOAD --}}
    @if(!empty($episode['downloads']))

    <div class="mt-8 rounded-xl border border-zinc-800 bg-zinc-900">

        <div class="border-b border-zinc-800 px-6 py-5">

            <h2 class="text-xl font-bold">

                Download Episode

            </h2>

        </div>

        <div class="space-y-6 p-6">

            @foreach($episode['downloads'] as $download)

                <div class="rounded-lg border border-zinc-800 bg-zinc-950">

                    <div class="border-b border-zinc-800 px-5 py-4">

                        <h3 class="font-bold text-lg">

                            {{ $download['quality'] }}

                        </h3>

                    </div>

                    <div class="space-y-3 p-5">

                        @foreach($download['links'] as $link)

                        <div class="flex flex-col gap-3 rounded-lg border border-zinc-800 bg-zinc-900 p-4 md:flex-row md:items-center md:justify-between">

                            <div>

                                <div class="font-semibold">

                                    {{ $link['host'] }}

                                </div>

                                <div class="text-sm text-zinc-400">

                                    Mirror Download

                                </div>

                            </div>

                            <a
                                href="{{ $link['url'] }}"
                                target="_blank"
                                class="rounded-lg bg-sky-600 px-5 py-2 font-semibold text-white hover:bg-sky-500">

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

</div>

{{-- POPUP ADS --}}
@if($popupAd)

<div
    id="popupAds"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 p-5">

    <div class="relative w-[650px] max-w-[90vw]">

        <button
            onclick="document.getElementById('popupAds').remove()"
            class="absolute -right-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full bg-red-600 text-white">

            ✕

        </button>

        <a
            href="{{ $popupAd->url }}"
            target="{{ $popupAd->target }}">

            <img
                src="{{ asset('storage/'.$popupAd->image) }}"
                class="w-full rounded-xl shadow-2xl">

        </a>

    </div>

</div>

@endif

{{-- FLOATING ADS --}}
@if($floatingAd)

<div
    id="floatingAd"
    class="fixed bottom-5 right-5 z-[9999] w-[220px]">

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
            class="w-full rounded-xl shadow-2xl">

    </a>

</div>

@endif
<script>

const player = document.getElementById('player');

document.querySelectorAll('.server-btn').forEach(button => {

    button.addEventListener('click', function () {

        document.querySelectorAll('.server-btn').forEach(btn => {

            btn.classList.remove(
                'bg-sky-600',
                'border-sky-600',
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
            'bg-sky-600',
            'border-sky-600',
            'text-white'
        );

        player.src = this.dataset.url;

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    });

});

@if($popupAd)

window.addEventListener('load', function () {

    setTimeout(function () {

        const popup = document.getElementById('popupAds');

        if (popup) {

            popup.classList.remove('hidden');
            popup.classList.add('flex');

        }

    }, 1000);

});

@endif

</script>

@endsection