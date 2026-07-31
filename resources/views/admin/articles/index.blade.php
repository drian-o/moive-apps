@extends('layouts.admin')

@section('title', 'Articles')
@section('page-title', 'Articles')

@php
    $articleCollection = $articles->getCollection();

    $publishedOnPage = $articleCollection
        ->where('status', 'published')
        ->count();

    $draftOnPage = $articleCollection
        ->where('status', '!=', 'published')
        ->count();

    $indexedOnPage = $articleCollection
        ->where('google_indexed', true)
        ->count();
@endphp

@section('content')
<div
    id="articles-app"
    class="mx-auto w-full max-w-[1500px]"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 via-indigo-500 to-blue-600 shadow-lg shadow-indigo-950/40">
                    <x-heroicon-o-document-text class="relative z-10 h-6 w-6 text-white"/>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Articles
                    </h1>

                    <p class="text-sm text-slate-500">
                        Content Management Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-2xl text-sm leading-6 text-slate-400">
                Kelola artikel, status publikasi, thumbnail, dan status Google Index dari satu dashboard.
            </p>
        </div>

        <a
            href="{{ route('admin.articles.create') }}"
            class="group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-950/40 transition hover:-translate-y-0.5 hover:from-violet-500 hover:to-indigo-500"
        >
            <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

            <x-heroicon-o-plus class="relative h-5 w-5"/>

            <span class="relative">
                Tambah Artikel
            </span>
        </a>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div
            id="success-alert"
            class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 shadow-lg shadow-emerald-950/10"
        >
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500/15">
                <x-heroicon-o-check-circle class="h-5 w-5 text-emerald-400"/>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-emerald-300">
                    Berhasil
                </p>

                <p class="mt-1 text-sm text-emerald-200/70">
                    {{ session('success') }}
                </p>
            </div>

            <button
                type="button"
                id="close-success-alert"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-emerald-300/60 transition hover:bg-emerald-500/10 hover:text-emerald-300"
                aria-label="Tutup notifikasi"
            >
                <x-heroicon-o-x-mark class="h-5 w-5"/>
            </button>
        </div>
    @endif

    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-indigo-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-indigo-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Total Artikel
                    </p>

                    <p class="mt-3 text-3xl font-black tracking-tight text-white">
                        {{ number_format($articles->total()) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Seluruh artikel tersimpan
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400 transition group-hover:bg-indigo-500 group-hover:text-white">
                    <x-heroicon-o-document-duplicate class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-emerald-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-emerald-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Published
                    </p>

                    <p
                        id="publishedCount"
                        class="mt-3 text-3xl font-black tracking-tight text-emerald-400"
                    >
                        {{ $publishedOnPage }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Pada halaman ini
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 transition group-hover:bg-emerald-500 group-hover:text-white">
                    <x-heroicon-o-check-badge class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-amber-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-amber-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Draft
                    </p>

                    <p
                        id="draftCount"
                        class="mt-3 text-3xl font-black tracking-tight text-amber-400"
                    >
                        {{ $draftOnPage }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Belum dipublikasikan
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400 transition group-hover:bg-amber-500 group-hover:text-white">
                    <x-heroicon-o-pencil-square class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-cyan-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-cyan-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Google Indexed
                    </p>

                    <p
                        id="indexedCount"
                        class="mt-3 text-3xl font-black tracking-tight text-cyan-400"
                    >
                        {{ $indexedOnPage }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Pada halaman ini
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                    <x-heroicon-o-magnifying-glass-circle class="h-5 w-5"/>
                </div>
            </div>
        </article>
    </div>

    {{-- Main workspace --}}
    <div class="relative mt-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30">
        {{-- Decorative background --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-72 w-72 rounded-full bg-violet-600/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-32 h-72 w-72 rounded-full bg-blue-600/10 blur-3xl"></div>
        </div>

        {{-- Toolbar --}}
        <div class="relative flex flex-col gap-4 border-b border-slate-800 px-5 py-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                </div>

                <div class="hidden h-6 w-px bg-slate-700 sm:block"></div>

                <div>
                    <h2 class="font-bold text-white">
                        Daftar Artikel
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Cari dan filter artikel pada halaman ini.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 transition group-focus-within:text-violet-400"/>
                    </div>

                    <input
                        id="article-search"
                        type="search"
                        placeholder="Cari judul atau slug..."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-violet-500/70 focus:ring-4 focus:ring-violet-500/10 sm:w-64"
                    >
                </div>

                <select
                    id="article-status-filter"
                    class="rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-300 outline-none transition focus:border-violet-500"
                >
                    <option value="all">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="indexed">Google Indexed</option>
                </select>
            </div>
        </div>

        {{-- Desktop table --}}
        <div class="relative hidden overflow-x-auto lg:block">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950/55">
                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Article
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Detail
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Status
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Google
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Publish
                        </th>

                        <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="article-table-body"
                    class="divide-y divide-slate-800"
                >
                    @forelse($articles as $article)
                        @php
                            $isPublished = $article->status === 'published';
                            $isIndexed = (bool) $article->google_indexed;
                            $searchText = strtolower($article->title.' '.$article->slug);
                        @endphp

                        <tr
                            class="article-row group transition hover:bg-slate-800/35"
                            data-search="{{ $searchText }}"
                            data-status="{{ $isPublished ? 'published' : 'draft' }}"
                            data-indexed="{{ $isIndexed ? '1' : '0' }}"
                        >
                            <td class="px-5 py-4">
                                <div class="relative h-20 w-32 overflow-hidden rounded-2xl border border-slate-700 bg-slate-950 shadow-lg shadow-black/20">
                                    @if($article->thumbnail)
                                        <img
                                            src="{{ asset('storage/'.$article->thumbnail) }}"
                                            alt="{{ $article->title }}"
                                            loading="lazy"
                                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 text-slate-600">
                                            <x-heroicon-o-photo class="h-6 w-6"/>

                                            <span class="mt-1 text-[10px] font-bold">
                                                No Image
                                            </span>
                                        </div>
                                    @endif

                                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                </div>
                            </td>

                            <td class="min-w-[320px] px-5 py-4">
                                <div class="max-w-lg">
                                    <h3 class="line-clamp-2 font-bold leading-6 text-slate-200 transition group-hover:text-white">
                                        {{ $article->title }}
                                    </h3>

                                    <button
                                        type="button"
                                        class="copy-slug mt-2 inline-flex max-w-full items-center gap-2 rounded-lg border border-slate-700 bg-slate-950/60 px-2.5 py-1 font-mono text-[11px] text-slate-500 transition hover:border-violet-500/30 hover:bg-violet-500/10 hover:text-violet-300"
                                        data-slug="{{ $article->slug }}"
                                        title="Copy slug"
                                    >
                                        <span class="truncate">
                                            /{{ $article->slug }}
                                        </span>

                                        <x-heroicon-o-clipboard class="h-3.5 w-3.5 shrink-0"/>
                                    </button>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-center">
                                @if($isPublished)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-bold text-emerald-400">
                                        <span class="relative flex h-2 w-2">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                                            <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                        </span>

                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-amber-500/20 bg-amber-500/10 px-3 py-1 text-xs font-bold text-amber-400">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-center">
                                @if($isIndexed)
                                    <span
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400"
                                        title="Sudah terindeks Google"
                                    >
                                        <x-heroicon-o-check-circle class="h-5 w-5"/>
                                    </span>
                                @else
                                    <span
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-700 bg-slate-950/60 text-slate-600"
                                        title="Belum terindeks"
                                    >
                                        <x-heroicon-o-minus class="h-5 w-5"/>
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-center">
                                @if($article->published_at)
                                    <div class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2">
                                        <x-heroicon-o-calendar-days class="h-4 w-4 text-slate-500"/>

                                        <span class="text-xs font-semibold text-slate-300">
                                            {{ optional($article->published_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-600">
                                        Belum dijadwalkan
                                    </span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.articles.edit', $article) }}"
                                        class="flex h-9 items-center gap-2 rounded-xl border border-blue-500/20 bg-blue-500/10 px-3 text-xs font-bold text-blue-400 transition hover:bg-blue-500 hover:text-white"
                                    >
                                        <x-heroicon-o-pencil-square class="h-4 w-4"/>
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="delete-article flex h-9 items-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-3 text-xs font-bold text-red-400 transition hover:bg-red-500 hover:text-white"
                                        data-action="{{ route('admin.articles.destroy', $article) }}"
                                        data-title="{{ $article->title }}"
                                    >
                                        <x-heroicon-o-trash class="h-4 w-4"/>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                                    <x-heroicon-o-document-plus class="h-8 w-8 text-slate-500"/>
                                </div>

                                <h3 class="mt-4 text-base font-bold text-slate-300">
                                    Belum ada artikel
                                </h3>

                                <p class="mt-2 text-sm text-slate-600">
                                    Buat artikel pertama untuk mulai mengisi website.
                                </p>

                                <a
                                    href="{{ route('admin.articles.create') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-500"
                                >
                                    <x-heroicon-o-plus class="h-4 w-4"/>
                                    Tambah Artikel
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div
                id="desktop-empty-filter"
                class="hidden px-6 py-20 text-center"
            >
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                    <x-heroicon-o-magnifying-glass class="h-8 w-8 text-slate-500"/>
                </div>

                <h3 class="mt-4 text-base font-bold text-slate-300">
                    Artikel tidak ditemukan
                </h3>

                <p class="mt-2 text-sm text-slate-600">
                    Coba ubah kata pencarian atau filter status.
                </p>
            </div>
        </div>

        {{-- Mobile cards --}}
        <div
            id="article-mobile-list"
            class="relative divide-y divide-slate-800 lg:hidden"
        >
            @forelse($articles as $article)
                @php
                    $isPublished = $article->status === 'published';
                    $isIndexed = (bool) $article->google_indexed;
                    $searchText = strtolower($article->title.' '.$article->slug);
                @endphp

                <article
                    class="article-mobile-card p-4"
                    data-search="{{ $searchText }}"
                    data-status="{{ $isPublished ? 'published' : 'draft' }}"
                    data-indexed="{{ $isIndexed ? '1' : '0' }}"
                >
                    <div class="flex gap-4">
                        <div class="h-20 w-28 shrink-0 overflow-hidden rounded-2xl border border-slate-700 bg-slate-950">
                            @if($article->thumbnail)
                                <img
                                    src="{{ asset('storage/'.$article->thumbnail) }}"
                                    alt="{{ $article->title }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center text-slate-600">
                                    <x-heroicon-o-photo class="h-6 w-6"/>
                                    <span class="mt-1 text-[10px] font-bold">
                                        No Image
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="line-clamp-2 text-sm font-bold leading-5 text-white">
                                {{ $article->title }}
                            </h3>

                            <p class="mt-1 truncate font-mono text-[11px] text-slate-600">
                                /{{ $article->slug }}
                            </p>

                            <div class="mt-3 flex flex-wrap gap-2">
                                @if($isPublished)
                                    <span class="rounded-full bg-emerald-500/10 px-2.5 py-1 text-[10px] font-bold text-emerald-400">
                                        Published
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-500/10 px-2.5 py-1 text-[10px] font-bold text-amber-400">
                                        Draft
                                    </span>
                                @endif

                                @if($isIndexed)
                                    <span class="rounded-full bg-cyan-500/10 px-2.5 py-1 text-[10px] font-bold text-cyan-400">
                                        Indexed
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-3 border-t border-slate-800 pt-4">
                        <span class="flex items-center gap-2 text-xs text-slate-500">
                            <x-heroicon-o-calendar-days class="h-4 w-4"/>

                            {{ optional($article->published_at)->format('d M Y') ?? 'Belum publish' }}
                        </span>

                        <div class="flex gap-2">
                            <a
                                href="{{ route('admin.articles.edit', $article) }}"
                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-blue-400 transition hover:bg-blue-500 hover:text-white"
                                title="Edit"
                            >
                                <x-heroicon-o-pencil-square class="h-4 w-4"/>
                            </a>

                            <button
                                type="button"
                                class="delete-article flex h-9 w-9 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 transition hover:bg-red-500 hover:text-white"
                                data-action="{{ route('admin.articles.destroy', $article) }}"
                                data-title="{{ $article->title }}"
                                title="Hapus"
                            >
                                <x-heroicon-o-trash class="h-4 w-4"/>
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="px-6 py-20 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                        <x-heroicon-o-document-plus class="h-8 w-8 text-slate-500"/>
                    </div>

                    <h3 class="mt-4 font-bold text-slate-300">
                        Belum ada artikel
                    </h3>
                </div>
            @endforelse

            <div
                id="mobile-empty-filter"
                class="hidden px-6 py-20 text-center"
            >
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                    <x-heroicon-o-magnifying-glass class="h-8 w-8 text-slate-500"/>
                </div>

                <h3 class="mt-4 font-bold text-slate-300">
                    Artikel tidak ditemukan
                </h3>
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative flex flex-col gap-2 border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-xs text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span id="article-result-info">
                Menampilkan {{ $articles->count() }} dari {{ $articles->total() }} artikel
            </span>

            <span>
                Halaman {{ $articles->currentPage() }} dari {{ $articles->lastPage() }}
            </span>
        </div>
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900/70 p-4">
            {{ $articles->onEachSide(1)->links() }}
        </div>
    @endif
</div>

{{-- Delete confirmation modal --}}
<div
    id="deleteArticleModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/85 p-4 backdrop-blur-md"
>
    <div
        id="deleteArticlePanel"
        class="w-full max-w-md translate-y-4 overflow-hidden rounded-3xl border border-red-500/20 bg-slate-900 opacity-0 shadow-2xl shadow-black/60 transition duration-200"
    >
        <div class="p-6 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-500/10">
                <x-heroicon-o-trash class="h-8 w-8 text-red-400"/>
            </div>

            <h3 class="mt-5 text-lg font-black text-white">
                Hapus Artikel?
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Artikel
                <span
                    id="deleteArticleTitle"
                    class="font-semibold text-slate-300"
                ></span>
                akan dihapus permanen.
            </p>

            <form
                id="deleteArticleForm"
                method="POST"
                action=""
                class="mt-6 grid grid-cols-2 gap-3"
            >
                @csrf
                @method('DELETE')

                <button
                    id="cancelDeleteArticle"
                    type="button"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-bold text-slate-300 transition hover:bg-slate-700"
                >
                    Batal
                </button>

                <button
                    id="confirmDeleteArticle"
                    type="submit"
                    class="flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-500 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg
                        id="deleteArticleSpinner"
                        class="hidden h-5 w-5 animate-spin"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-20"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>

                        <path
                            class="opacity-100"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                    </svg>

                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Toast --}}
<div
    id="article-toast"
    class="pointer-events-none fixed right-5 top-5 z-[70] hidden w-[calc(100%-2.5rem)] max-w-sm translate-x-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 opacity-0 shadow-2xl shadow-black/30 backdrop-blur transition duration-200"
>
    <div class="flex items-start gap-3">
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-400">
            <x-heroicon-o-check class="h-4 w-4"/>
        </div>

        <p
            id="article-toast-message"
            class="pt-1 text-sm font-semibold text-emerald-300"
        ></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput =
        document.getElementById('article-search');

    const statusFilter =
        document.getElementById('article-status-filter');

    const desktopRows = Array.from(
        document.querySelectorAll('.article-row')
    );

    const mobileCards = Array.from(
        document.querySelectorAll('.article-mobile-card')
    );

    const desktopEmpty =
        document.getElementById('desktop-empty-filter');

    const mobileEmpty =
        document.getElementById('mobile-empty-filter');

    const resultInfo =
        document.getElementById('article-result-info');

    const deleteModal =
        document.getElementById('deleteArticleModal');

    const deletePanel =
        document.getElementById('deleteArticlePanel');

    const deleteForm =
        document.getElementById('deleteArticleForm');

    const deleteTitle =
        document.getElementById('deleteArticleTitle');

    const cancelDelete =
        document.getElementById('cancelDeleteArticle');

    const confirmDelete =
        document.getElementById('confirmDeleteArticle');

    const deleteSpinner =
        document.getElementById('deleteArticleSpinner');

    const toast =
        document.getElementById('article-toast');

    const toastMessage =
        document.getElementById('article-toast-message');

    function itemMatches(element) {
        const keyword = searchInput.value
            .trim()
            .toLowerCase();

        const selectedStatus = statusFilter.value;

        const searchText =
            element.dataset.search || '';

        const status =
            element.dataset.status || '';

        const indexed =
            element.dataset.indexed === '1';

        const matchesKeyword =
            !keyword ||
            searchText.includes(keyword);

        const matchesStatus =
            selectedStatus === 'all' ||
            selectedStatus === status ||
            (
                selectedStatus === 'indexed' &&
                indexed
            );

        return matchesKeyword && matchesStatus;
    }

    function filterArticles() {
        let visibleDesktop = 0;
        let visibleMobile = 0;

        desktopRows.forEach(row => {
            const visible = itemMatches(row);

            row.classList.toggle('hidden', !visible);

            if (visible) {
                visibleDesktop++;
            }
        });

        mobileCards.forEach(card => {
            const visible = itemMatches(card);

            card.classList.toggle('hidden', !visible);

            if (visible) {
                visibleMobile++;
            }
        });

        desktopEmpty?.classList.toggle(
            'hidden',
            visibleDesktop > 0 || desktopRows.length === 0
        );

        mobileEmpty?.classList.toggle(
            'hidden',
            visibleMobile > 0 || mobileCards.length === 0
        );

        if (resultInfo) {
            const visibleCount = window.innerWidth >= 1024
                ? visibleDesktop
                : visibleMobile;

            resultInfo.textContent =
                `Menampilkan ${visibleCount} artikel pada halaman ini`;
        }
    }

    function openDeleteModal(action, title) {
        deleteForm.action = action;
        deleteTitle.textContent = `"${title}"`;

        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            deletePanel.classList.remove(
                'translate-y-4',
                'opacity-0'
            );
        });
    }

    function closeDeleteModal() {
        deletePanel.classList.add(
            'translate-y-4',
            'opacity-0'
        );

        setTimeout(() => {
            deleteModal.classList.remove('flex');
            deleteModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 180);
    }

    function showToast(message) {
        toastMessage.textContent = message;

        toast.classList.remove('hidden');

        requestAnimationFrame(() => {
            toast.classList.remove(
                'translate-x-4',
                'opacity-0'
            );
        });

        setTimeout(() => {
            toast.classList.add(
                'translate-x-4',
                'opacity-0'
            );

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 200);
        }, 1600);
    }

    searchInput?.addEventListener(
        'input',
        filterArticles
    );

    statusFilter?.addEventListener(
        'change',
        filterArticles
    );

    document
        .querySelectorAll('.delete-article')
        .forEach(button => {
            button.addEventListener('click', () => {
                openDeleteModal(
                    button.dataset.action,
                    button.dataset.title
                );
            });
        });

    document
        .querySelectorAll('.copy-slug')
        .forEach(button => {
            button.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(
                        button.dataset.slug || ''
                    );

                    showToast('Slug berhasil disalin.');
                } catch {
                    // Clipboard bisa ditolak browser.
                }
            });
        });

    cancelDelete?.addEventListener(
        'click',
        closeDeleteModal
    );

    deleteModal?.addEventListener('click', event => {
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });

    deleteForm?.addEventListener('submit', () => {
        confirmDelete.disabled = true;
        deleteSpinner.classList.remove('hidden');
    });

    document
        .getElementById('close-success-alert')
        ?.addEventListener('click', () => {
            document
                .getElementById('success-alert')
                ?.remove();
        });

    document.addEventListener('keydown', event => {
        if (
            event.key === 'Escape' &&
            !deleteModal.classList.contains('hidden')
        ) {
            closeDeleteModal();
        }
    });
});
</script>
@endpush