@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-[1700px]">

    <div class="grid grid-cols-12 gap-6">

        {{-- PLAYER --}}
        <div class="col-span-12 xl:col-span-9">

            <div class="relative overflow-hidden rounded-2xl bg-black">

                <iframe
                    src="{{ $watch['player'] }}"
                    class="aspect-video w-full"
                    allowfullscreen
                    allow="autoplay; fullscreen">
                </iframe>

{{-- Banner Player Overlay --}}
@if($playerAd)
<div
    id="playerAd"
    class="absolute inset-0 z-30 flex items-center justify-center">

    <div class="relative w-[500px] max-w-[50%]">

        <button
            type="button"
            onclick="document.getElementById('playerAd').remove()"
            class="absolute -top-3 -right-3 z-50 flex h-8 w-8 items-center justify-center rounded-full bg-red-600 text-sm font-bold text-white shadow-xl hover:bg-red-700">

            ✕

        </button>

        <a
            href="{{ $playerAd->url }}"
            target="{{ $playerAd->target }}">

            <img
                src="{{ asset('storage/'.$playerAd->image) }}"
                alt="{{ $playerAd->name }}"
                class="block w-full rounded-xl shadow-2xl">

        </a>

    </div>

</div>
@endif

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

            {{-- Banner Sidebar --}}
            @if($sidebarAd)
            <div class="mb-6 flex justify-center">

                <a href="{{ $sidebarAd->url }}"
                   target="{{ $sidebarAd->target }}">

                    <img
                        src="{{ asset('storage/'.$sidebarAd->image) }}"
                        alt="{{ $sidebarAd->name }}"
                        class="w-full max-w-[300px] rounded-xl object-cover">

                </a>

            </div>
            @endif

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

    {{-- Footer Banner --}}
    @if($footerAd)
    <div class="mt-8 flex justify-center">

        <a href="{{ $footerAd->url }}"
           target="{{ $footerAd->target }}">

            <img
                src="{{ asset('storage/'.$footerAd->image) }}"
                alt="{{ $footerAd->name }}"
                class="w-full max-w-[970px] rounded-xl object-cover">

        </a>

    </div>
    @endif

</div>

{{-- Popup Banner --}}
@if($popupAd)
<div
    id="popupAds"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 p-5">

    <div class="relative w-[600px] max-w-[90vw]">

        <button
            onclick="document.getElementById('popupAds').remove()"
            class="absolute -right-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full bg-red-600 text-white">

            ✕

        </button>

        <a href="{{ $popupAd->url }}"
           target="{{ $popupAd->target }}">

            <img
                src="{{ asset('storage/'.$popupAd->image) }}"
                alt="{{ $popupAd->name }}"
                class="w-full rounded-xl shadow-2xl">

        </a>

    </div>

</div>

<script>
window.addEventListener('load', function () {
    setTimeout(function () {
        const popup = document.getElementById('popupAds');
        if (popup) {
            popup.style.display = 'flex';
        }
    }, 1000);
});
</script>
@endif

{{-- Floating Banner --}}
@if($floatingAd)
<div
    id="floatingAd"
    class="fixed bottom-5 right-5 z-[9999] w-[300px]">

    <button
        onclick="document.getElementById('floatingAd').remove()"
        class="absolute -top-2 -right-2 flex h-7 w-7 items-center justify-center rounded-full bg-red-600 text-white">

        ✕

    </button>

    <a href="{{ $floatingAd->url }}"
       target="{{ $floatingAd->target }}">

        <img
            src="{{ asset('storage/'.$floatingAd->image) }}"
            alt="{{ $floatingAd->name }}"
            class="w-full rounded-xl shadow-2xl">

    </a>

</div>
@endif

@endsection