@extends('layouts.app')

@section('title', $article->meta_title ?: $article->title)

@php
    $plainContent = trim(strip_tags($article->content ?? ''));
    $wordCount = $plainContent !== '' ? str_word_count($plainContent) : 0;
    $readingTime = max(1, (int) ceil($wordCount / 200));
    $publishedLabel = optional($article->published_at)->translatedFormat('d F Y');
    $shareUrl = route('articles.show', $article->slug);
@endphp

@section('content')
<div
    id="reading-progress"
    class="fixed left-0 top-0 z-[90] h-1 w-0 bg-gradient-to-r from-violet-500 via-indigo-500 to-cyan-400"
></div>

<div
    id="article-detail-page"
    class="relative overflow-hidden"
    data-share-url="{{ $shareUrl }}"
    data-share-title="{{ $article->title }}"
>
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[760px] overflow-hidden">
        <div class="absolute -left-40 -top-48 h-[460px] w-[460px] rounded-full bg-indigo-600/15 blur-3xl"></div>
        <div class="absolute -right-48 top-20 h-[440px] w-[440px] rounded-full bg-cyan-500/10 blur-3xl"></div>

        <div
            class="absolute inset-0 opacity-[0.025]"
            style="
                background-image:
                    linear-gradient(rgba(255,255,255,.65) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.65) 1px, transparent 1px);
                background-size: 36px 36px;
            "
        ></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        {{-- Breadcrumb --}}
        <nav class="mb-8 flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ url('/') }}" class="transition hover:text-white">
                Home
            </a>

            <svg class="h-4 w-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 18 6-6-6-6"/>
            </svg>

            <a href="{{ route('articles.index') }}" class="transition hover:text-white">
                Artikel
            </a>

            <svg class="h-4 w-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 18 6-6-6-6"/>
            </svg>

            <span class="max-w-[260px] truncate text-indigo-400 sm:max-w-lg">
                {{ $article->title }}
            </span>
        </nav>

        {{-- Article heading --}}
        <header class="mb-10">
            <div class="mx-auto max-w-5xl text-center">
                <div class="mb-5 flex flex-wrap items-center justify-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-500/20 bg-indigo-500/10 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-indigo-300">
                        <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                        Article
                    </span>

                    @if($publishedLabel)
                        <span class="rounded-full border border-slate-800 bg-slate-900/70 px-3 py-1.5 text-xs font-semibold text-slate-400 backdrop-blur">
                            {{ $publishedLabel }}
                        </span>
                    @endif
                </div>

                <h1 class="text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl lg:leading-[1.08]">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                    <p class="mx-auto mt-6 max-w-3xl text-base leading-8 text-slate-400 sm:text-lg">
                        {{ $article->excerpt }}
                    </p>
                @endif

                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-sm font-semibold text-slate-500">
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

                        {{ number_format($article->views ?? 0) }} views
                    </span>

                    <span class="inline-flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>

                        {{ $readingTime }} menit baca
                    </span>

                    <span class="inline-flex items-center gap-2">
                        <svg class="h-5 w-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.75A3.375 3.375 0 0 0 11.25 3.375H8.625m0 11.625h4.5m-4.5 3h4.5M10.5 3.375H5.625c-.621 0-1.125.504-1.125 1.125v15c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V12.375a9 9 0 0 0-9-9Z"/>
                        </svg>

                        {{ number_format($wordCount) }} kata
                    </span>
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="relative mx-auto mt-10 max-w-6xl overflow-hidden rounded-[2rem] border border-slate-800 bg-slate-900 shadow-2xl shadow-black/40">
                @if($article->thumbnail)
                    <img
                        src="{{ asset('storage/'.$article->thumbnail) }}"
                        alt="{{ $article->title }}"
                        loading="eager"
                        class="aspect-[16/8.5] w-full object-cover"
                    >
                @else
                    <div class="flex aspect-[16/8.5] w-full items-center justify-center bg-gradient-to-br from-slate-800 via-slate-900 to-indigo-950">
                        <svg class="h-24 w-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A2.25 2.25 0 0 0 22.5 17.25V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v10.5A2.25 2.25 0 0 0 3.75 19.5Zm12-12h.008v.008H15.75V7.5Z"/>
                        </svg>
                    </div>
                @endif

                <div class="pointer-events-none absolute inset-0 ring-1 ring-inset ring-white/5"></div>
            </div>
        </header>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_340px] xl:gap-10">
            {{-- Main article --}}
            <main class="min-w-0">
                <article class="overflow-hidden rounded-[2rem] border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    {{-- Share toolbar --}}
                    <div class="flex flex-col gap-4 border-b border-slate-800 bg-slate-950/35 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/10">
                                <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.346.452.638.785.842m-.785-.842 8.066-4.158m-8.066 6.344 8.066 4.158m0-10.502a2.25 2.25 0 1 1 3.935-2.186 2.25 2.25 0 0 1-3.935 2.186Zm0 10.502a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Z"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-bold text-white">
                                    Bagikan artikel
                                </p>

                                <p class="mt-0.5 text-xs text-slate-600">
                                    Sebarkan bacaan ini ke temanmu.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <button
                                type="button"
                                data-share="facebook"
                                class="share-button flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-900 text-slate-400 transition hover:border-blue-500/30 hover:bg-blue-500/10 hover:text-blue-400"
                                title="Facebook"
                            >
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.5 22v-9h3l.5-3h-3.5V8.1c0-.87.24-1.46 1.52-1.46H17V4.02c-.34-.05-1.5-.14-2.85-.14-2.82 0-4.75 1.72-4.75 4.88V10H6.5v3h2.9v9h4.1Z"/>
                                </svg>
                            </button>

                            <button
                                type="button"
                                data-share="twitter"
                                class="share-button flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-900 text-slate-400 transition hover:border-sky-500/30 hover:bg-sky-500/10 hover:text-sky-400"
                                title="X"
                            >
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 2H22l-6.78 7.75L23.2 22h-6.25l-4.9-6.4L6.45 22H3.34l7.27-8.31L2.95 2H9.36l4.43 5.85L18.9 2Zm-1.1 17.84h1.72L8.42 4.05H6.58L17.8 19.84Z"/>
                                </svg>
                            </button>

                            <button
                                type="button"
                                data-share="whatsapp"
                                class="share-button flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-900 text-slate-400 transition hover:border-emerald-500/30 hover:bg-emerald-500/10 hover:text-emerald-400"
                                title="WhatsApp"
                            >
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.52 3.48A11.88 11.88 0 0 0 12.05 0C5.46 0 .1 5.36.1 11.95c0 2.1.55 4.16 1.6 5.97L0 24l6.22-1.63a11.93 11.93 0 0 0 5.82 1.48h.01C18.64 23.85 24 18.49 24 11.9c0-3.18-1.24-6.17-3.48-8.42ZM12.05 21.84h-.01a9.88 9.88 0 0 1-5.04-1.38l-.36-.21-3.69.97.99-3.6-.23-.37a9.9 9.9 0 1 1 8.34 4.59Zm5.43-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48a9 9 0 0 1-1.66-2.06c-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.11 3.22 5.11 4.52.71.31 1.27.49 1.71.63.72.23 1.37.2 1.88.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/>
                                </svg>
                            </button>

                            <button
                                id="copy-article-link"
                                type="button"
                                class="flex h-10 items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 text-xs font-bold text-slate-400 transition hover:border-violet-500/30 hover:bg-violet-500/10 hover:text-violet-300"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/>
                                </svg>

                                <span id="copy-article-link-text">
                                    Copy Link
                                </span>
                            </button>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div
                        id="article-content"
                        class="article-content px-5 py-8 sm:px-8 sm:py-10 lg:px-10"
                    >
                        {!! $article->content !!}
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-slate-800 bg-slate-950/25 px-5 py-6 sm:px-8">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-bold text-white">
                                    Selesai membaca?
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Bagikan artikel ini agar lebih banyak orang mendapat manfaat.
                                </p>
                            </div>

                            <a
                                href="{{ route('articles.index') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-sm font-bold text-slate-300 transition hover:border-indigo-500/30 hover:bg-indigo-500/10 hover:text-indigo-300"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                                </svg>

                                Artikel Lainnya
                            </a>
                        </div>
                    </div>
                </article>
            </main>

            {{-- Sidebar --}}
            <aside class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                {{-- Table of contents --}}
                <section
                    id="toc-card"
                    class="hidden overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl shadow-black/20"
                >
                    <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-500/10">
                            <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8.25 6.75h12m-12 5.25h12m-12 5.25h12M3.75 6.75h.008v.008H3.75V6.75Zm0 5.25h.008v.008H3.75V12Zm0 5.25h.008v.008H3.75v-.008Z"/>
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-sm font-black text-white">
                                Daftar Isi
                            </h2>

                            <p class="mt-0.5 text-[11px] text-slate-600">
                                Navigasi cepat artikel
                            </p>
                        </div>
                    </div>

                    <nav
                        id="article-toc"
                        class="max-h-[340px] space-y-1 overflow-y-auto p-3"
                    ></nav>
                </section>

                {{-- Info --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl shadow-black/20">
                    <div class="border-b border-slate-800 px-5 py-4">
                        <h2 class="text-sm font-black text-white">
                            Informasi Artikel
                        </h2>
                    </div>

                    <div class="divide-y divide-slate-800">
                        <div class="flex items-center justify-between gap-4 px-5 py-4">
                            <span class="text-xs text-slate-500">Diterbitkan</span>
                            <span class="text-right text-xs font-bold text-slate-300">
                                {{ $publishedLabel ?: '-' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4 px-5 py-4">
                            <span class="text-xs text-slate-500">Waktu baca</span>
                            <span class="text-right text-xs font-bold text-slate-300">
                                {{ $readingTime }} menit
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4 px-5 py-4">
                            <span class="text-xs text-slate-500">Jumlah kata</span>
                            <span class="text-right text-xs font-bold text-slate-300">
                                {{ number_format($wordCount) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4 px-5 py-4">
                            <span class="text-xs text-slate-500">Total views</span>
                            <span class="text-right text-xs font-bold text-cyan-400">
                                {{ number_format($article->views ?? 0) }}
                            </span>
                        </div>
                    </div>
                </section>

                {{-- Related --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl shadow-black/20">
                    <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">
                        <div>
                            <h2 class="text-sm font-black text-white">
                                Artikel Terkait
                            </h2>

                            <p class="mt-0.5 text-[11px] text-slate-600">
                                Bacaan pilihan lainnya
                            </p>
                        </div>

                        <a
                            href="{{ route('articles.index') }}"
                            class="text-[11px] font-bold text-indigo-400 transition hover:text-indigo-300"
                        >
                            Lihat semua
                        </a>
                    </div>

                    <div class="divide-y divide-slate-800">
                        @forelse($related as $item)
                            <a
                                href="{{ route('articles.show', $item->slug) }}"
                                class="group flex gap-3 p-4 transition hover:bg-slate-800/45"
                            >
                                <div class="h-20 w-28 shrink-0 overflow-hidden rounded-xl border border-slate-700 bg-slate-800">
                                    @if($item->thumbnail)
                                        <img
                                            src="{{ asset('storage/'.$item->thumbnail) }}"
                                            alt="{{ $item->title }}"
                                            loading="lazy"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                                            <svg class="h-7 w-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5A2.25 2.25 0 0 0 22.5 17.25V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v10.5A2.25 2.25 0 0 0 3.75 19.5Zm12-12h.008v.008H15.75V7.5Z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="line-clamp-2 text-sm font-bold leading-5 text-slate-200 transition group-hover:text-indigo-300">
                                        {{ $item->title }}
                                    </h3>

                                    <div class="mt-2 flex items-center gap-2 text-[10px] font-semibold text-slate-600">
                                        <span>
                                            {{ optional($item->published_at)->format('d M Y') ?? '-' }}
                                        </span>

                                        <span class="h-1 w-1 rounded-full bg-slate-700"></span>

                                        <span>
                                            {{ number_format($item->views ?? 0) }} views
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-5 py-10 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-800">
                                    <svg class="h-6 w-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5V6.75A3.375 3.375 0 0 0 11.25 3.375H8.625m0 11.625h4.5m-4.5 3h4.5M10.5 3.375H5.625c-.621 0-1.125.504-1.125 1.125v15c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V12.375a9 9 0 0 0-9-9Z"/>
                                    </svg>
                                </div>

                                <p class="mt-3 text-xs text-slate-500">
                                    Tidak ada artikel terkait.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>

{{-- Toast --}}
<div
    id="article-toast"
    class="pointer-events-none fixed bottom-5 right-5 z-[95] hidden w-[calc(100%-2.5rem)] max-w-sm translate-y-4 rounded-2xl border border-emerald-500/20 bg-slate-900/95 p-4 opacity-0 shadow-2xl shadow-black/50 backdrop-blur transition duration-200"
>
    <div class="flex items-start gap-3">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10">
            <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4.5 12.75 6 6 9-13.5"/>
            </svg>
        </div>

        <div>
            <p class="text-sm font-bold text-white">
                Berhasil
            </p>

            <p id="article-toast-message" class="mt-1 text-xs text-slate-400"></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }

    .article-content {
        color: #cbd5e1;
        font-size: 1.05rem;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .article-content > *:first-child {
        margin-top: 0;
    }

    .article-content > *:last-child {
        margin-bottom: 0;
    }

    .article-content p {
        margin: 1.4rem 0;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        color: #ffffff;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.3;
        scroll-margin-top: 7rem;
    }

    .article-content h1 {
        margin: 2.8rem 0 1.3rem;
        font-size: 2.15rem;
    }

    .article-content h2 {
        margin: 2.6rem 0 1.2rem;
        font-size: 1.85rem;
    }

    .article-content h3 {
        margin: 2.2rem 0 1rem;
        font-size: 1.45rem;
    }

    .article-content h4 {
        margin: 2rem 0 0.8rem;
        font-size: 1.2rem;
    }

    .article-content strong {
        color: #f8fafc;
        font-weight: 700;
    }

    .article-content a {
        color: #818cf8;
        font-weight: 600;
        text-decoration: underline;
        text-decoration-color: rgba(129, 140, 248, 0.35);
        text-underline-offset: 4px;
    }

    .article-content a:hover {
        color: #a5b4fc;
    }

    .article-content ul,
    .article-content ol {
        margin: 1.4rem 0;
        padding-left: 1.6rem;
    }

    .article-content ul {
        list-style: disc;
    }

    .article-content ol {
        list-style: decimal;
    }

    .article-content li {
        margin: 0.55rem 0;
        padding-left: 0.3rem;
    }

    .article-content li::marker {
        color: #818cf8;
        font-weight: 700;
    }

    .article-content blockquote {
        margin: 2rem 0;
        border-left: 4px solid #8b5cf6;
        border-radius: 0 1rem 1rem 0;
        background: rgba(139, 92, 246, 0.08);
        padding: 1.1rem 1.4rem;
        color: #c4b5fd;
        font-style: italic;
    }

    .article-content blockquote p {
        margin: 0;
    }

    .article-content img {
        display: block;
        max-width: 100%;
        height: auto;
        margin: 2.2rem auto;
        border: 1px solid #334155;
        border-radius: 1rem;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.28);
    }

    .article-content figure {
        margin: 2.2rem 0;
    }

    .article-content figcaption {
        margin-top: 0.75rem;
        color: #64748b;
        font-size: 0.8rem;
        text-align: center;
    }

    .article-content hr {
        margin: 2.5rem 0;
        border: 0;
        border-top: 1px solid #1e293b;
    }

    .article-content code {
        border: 1px solid #334155;
        border-radius: 0.4rem;
        background: #020617;
        padding: 0.15rem 0.42rem;
        color: #c4b5fd;
        font-size: 0.88em;
    }

    .article-content pre {
        margin: 2rem 0;
        overflow-x: auto;
        border: 1px solid #334155;
        border-radius: 1rem;
        background: #020617;
        padding: 1.25rem;
        color: #e2e8f0;
        line-height: 1.7;
    }

    .article-content pre code {
        border: 0;
        background: transparent;
        padding: 0;
        color: inherit;
    }

    .article-content table {
        width: 100%;
        margin: 2rem 0;
        border-collapse: collapse;
        overflow: hidden;
        border: 1px solid #334155;
        border-radius: 0.9rem;
    }

    .article-content th,
    .article-content td {
        border: 1px solid #334155;
        padding: 0.85rem 1rem;
        text-align: left;
    }

    .article-content th {
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
    }

    .article-content td {
        background: rgba(2, 6, 23, 0.45);
    }

    #article-toc::-webkit-scrollbar {
        width: 5px;
    }

    #article-toc::-webkit-scrollbar-thumb {
        border-radius: 9999px;
        background: #334155;
    }

    @media (max-width: 640px) {
        .article-content {
            font-size: 1rem;
            line-height: 1.82;
        }

        .article-content h1 {
            font-size: 1.8rem;
        }

        .article-content h2 {
            font-size: 1.55rem;
        }

        .article-content h3 {
            font-size: 1.3rem;
        }

        .article-content table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const page = document.getElementById('article-detail-page');
    const content = document.getElementById('article-content');
    const progress = document.getElementById('reading-progress');
    const tocCard = document.getElementById('toc-card');
    const toc = document.getElementById('article-toc');
    const copyButton = document.getElementById('copy-article-link');
    const copyText = document.getElementById('copy-article-link-text');
    const toast = document.getElementById('article-toast');
    const toastMessage = document.getElementById('article-toast-message');

    const shareUrl = page?.dataset.shareUrl || window.location.href;
    const shareTitle = page?.dataset.shareTitle || document.title;

    function slugify(value) {
        return String(value || '')
            .toLowerCase()
            .trim()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function showToast(message) {
        toastMessage.textContent = message;
        toast.classList.remove('hidden');

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 200);
        }, 1800);
    }

    function updateProgress() {
        if (!content || !progress) {
            return;
        }

        const top = content.getBoundingClientRect().top + window.scrollY;
        const height = content.offsetHeight;
        const current = window.scrollY + window.innerHeight - top;
        const value = Math.min(Math.max(current / height, 0), 1);

        progress.style.width = `${value * 100}%`;
    }

    function buildToc() {
        if (!content || !toc || !tocCard) {
            return;
        }

        const headings = Array.from(
            content.querySelectorAll('h2, h3')
        );

        if (headings.length < 2) {
            return;
        }

        const used = new Set();

        headings.forEach((heading, index) => {
            let base = heading.id || slugify(heading.textContent) || `bagian-${index + 1}`;
            let id = base;
            let suffix = 2;

            while (used.has(id)) {
                id = `${base}-${suffix++}`;
            }

            used.add(id);
            heading.id = id;

            const link = document.createElement('a');
            link.href = `#${id}`;
            link.textContent = heading.textContent.trim();

            const sub = heading.tagName.toLowerCase() === 'h3';

            link.className = sub
                ? 'toc-link block rounded-xl py-2 pl-7 pr-3 text-[11px] font-medium leading-5 text-slate-500 transition hover:bg-slate-800 hover:text-indigo-300'
                : 'toc-link block rounded-xl px-3 py-2.5 text-xs font-bold leading-5 text-slate-400 transition hover:bg-slate-800 hover:text-indigo-300';

            toc.appendChild(link);
        });

        tocCard.classList.remove('hidden');

        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    document.querySelectorAll('.toc-link').forEach(link => {
                        const active = link.getAttribute('href') === `#${entry.target.id}`;

                        link.classList.toggle('bg-indigo-500/10', active);
                        link.classList.toggle('text-indigo-300', active);
                    });
                });
            },
            {
                rootMargin: '-18% 0px -70% 0px',
                threshold: 0,
            }
        );

        headings.forEach(heading => observer.observe(heading));
    }

    async function copyLink() {
        try {
            await navigator.clipboard.writeText(shareUrl);
        } catch {
            const textarea = document.createElement('textarea');
            textarea.value = shareUrl;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            textarea.remove();
        }

        copyText.textContent = 'Tersalin';
        showToast('Link artikel berhasil disalin.');

        setTimeout(() => {
            copyText.textContent = 'Copy Link';
        }, 1800);
    }

    function openShare(type) {
        const url = encodeURIComponent(shareUrl);
        const title = encodeURIComponent(shareTitle);

        const targets = {
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
            twitter: `https://twitter.com/intent/tweet?url=${url}&text=${title}`,
            whatsapp: `https://wa.me/?text=${title}%20${url}`,
        };

        if (!targets[type]) {
            return;
        }

        window.open(
            targets[type],
            '_blank',
            'noopener,noreferrer,width=720,height=560'
        );
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);

    copyButton?.addEventListener('click', copyLink);

    document.querySelectorAll('.share-button').forEach(button => {
        button.addEventListener('click', () => {
            openShare(button.dataset.share);
        });
    });

    buildToc();
    updateProgress();
});
</script>
@endpush