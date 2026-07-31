@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')

@php
    $currentStatus = old('status', $article->status);
    $currentTitle = old('title', $article->title);
    $currentSlug = old('slug', $article->slug);
    $currentExcerpt = old('excerpt', $article->excerpt);
    $currentMetaTitle = old('meta_title', $article->meta_title);
    $currentMetaKeywords = old('meta_keywords', $article->meta_keywords);
    $currentMetaDescription = old('meta_description', $article->meta_description);

    $hasThumbnail = filled($article->thumbnail);
    $thumbnailUrl = $hasThumbnail
        ? asset('storage/'.$article->thumbnail)
        : null;

    $publishedAt = optional($article->published_at)->format('d M Y, H:i');
@endphp

@section('content')
<div
    id="article-edit-app"
    class="mx-auto w-full max-w-[1500px]"
    data-original-slug="{{ $article->slug }}"
    data-original-thumbnail="{{ $thumbnailUrl }}"
>
    {{-- Heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 via-indigo-500 to-blue-600 shadow-lg shadow-indigo-950/40">
                    <x-heroicon-o-pencil-square class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Edit Artikel
                    </h1>

                    <p class="text-sm text-slate-500">
                        Update Content Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Perbarui isi artikel, thumbnail, metadata SEO, dan status publikasi tanpa meninggalkan dashboard.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if($article->status === 'published')
                <a
                    href="{{ route('articles.show', $article->slug) }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-cyan-500/20 bg-cyan-500/10 px-4 py-3 text-sm font-bold text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                >
                    <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4"/>
                    Lihat Artikel
                </a>
            @endif

            <a
                href="{{ route('admin.articles.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-bold text-slate-300 transition hover:border-slate-600 hover:bg-slate-800 hover:text-white"
            >
                <x-heroicon-o-arrow-left class="h-4 w-4"/>
                Kembali
            </a>
        </div>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 p-4 shadow-lg shadow-red-950/10">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-500/15">
                    <x-heroicon-o-exclamation-triangle class="h-5 w-5 text-red-400"/>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-bold text-red-300">
                        Periksa kembali data artikel
                    </p>

                    <ul class="mt-2 space-y-1 text-sm leading-6 text-red-200/75">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form
        id="article-edit-form"
        action="{{ route('admin.articles.update', $article) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
            {{-- Main column --}}
            <div class="space-y-6">
                {{-- Main information --}}
                <section class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="pointer-events-none absolute inset-0 overflow-hidden">
                        <div class="absolute -left-28 -top-28 h-64 w-64 rounded-full bg-violet-500/10 blur-3xl"></div>
                    </div>

                    <div class="relative flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/10">
                                <x-heroicon-o-document-text class="h-5 w-5 text-violet-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    Informasi Artikel
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Judul, URL artikel, dan ringkasan singkat.
                                </p>
                            </div>
                        </div>

                        <span class="w-fit rounded-md bg-violet-500/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-violet-400">
                            Required
                        </span>
                    </div>

                    <div class="relative space-y-5 p-5 sm:p-6">
                        {{-- Title --}}
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label
                                    for="title"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Judul Artikel
                                </label>

                                <span class="text-[11px] text-slate-600">
                                    <span id="title-count">{{ mb_strlen($currentTitle) }}</span>/200
                                </span>
                            </div>

                            <div class="group relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <x-heroicon-o-document-text class="h-5 w-5 text-slate-600 transition group-focus-within:text-violet-400"/>
                                </div>

                                <input
                                    id="title"
                                    type="text"
                                    name="title"
                                    value="{{ $currentTitle }}"
                                    maxlength="200"
                                    autocomplete="off"
                                    placeholder="Masukkan judul artikel..."
                                    required
                                    class="w-full rounded-2xl border bg-slate-950/70 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:ring-4
                                        {{ $errors->has('title')
                                            ? 'border-red-500/70 focus:border-red-500 focus:ring-red-500/10'
                                            : 'border-slate-700 focus:border-violet-500/70 focus:ring-violet-500/10'
                                        }}"
                                >
                            </div>

                            @error('title')
                                <p class="mt-2 text-xs font-medium text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <div class="mb-2 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <label
                                    for="slug"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Slug
                                </label>

                                <div class="flex items-center gap-3">
                                    <button
                                        id="restore-original-slug"
                                        type="button"
                                        class="text-xs font-semibold text-slate-500 transition hover:text-slate-300"
                                    >
                                        Kembalikan
                                    </button>

                                    <button
                                        id="generate-slug"
                                        type="button"
                                        class="text-xs font-semibold text-violet-400 transition hover:text-violet-300"
                                    >
                                        Generate dari judul
                                    </button>
                                </div>
                            </div>

                            <div class="group relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="font-mono text-sm text-slate-600">/</span>
                                </div>

                                <input
                                    id="slug"
                                    type="text"
                                    name="slug"
                                    value="{{ $currentSlug }}"
                                    maxlength="220"
                                    autocomplete="off"
                                    placeholder="judul-artikel"
                                    required
                                    class="w-full rounded-2xl border bg-slate-950/70 py-3.5 pl-10 pr-4 font-mono text-sm text-white outline-none transition placeholder:text-slate-600 focus:ring-4
                                        {{ $errors->has('slug')
                                            ? 'border-red-500/70 focus:border-red-500 focus:ring-red-500/10'
                                            : 'border-slate-700 focus:border-violet-500/70 focus:ring-violet-500/10'
                                        }}"
                                >
                            </div>

                            <div class="mt-2 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xs text-slate-600">
                                    Mengubah slug dapat memengaruhi URL lama artikel.
                                </p>

                                <p class="max-w-full truncate font-mono text-[11px] text-violet-400/70">
                                    /<span id="slug-preview">{{ $currentSlug }}</span>
                                </p>
                            </div>

                            @error('slug')
                                <p class="mt-2 text-xs font-medium text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Excerpt --}}
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label
                                    for="excerpt"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Excerpt
                                </label>

                                <span class="text-[11px] text-slate-600">
                                    <span id="excerpt-count">{{ mb_strlen($currentExcerpt ?? '') }}</span>/300
                                </span>
                            </div>

                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="4"
                                maxlength="300"
                                placeholder="Ringkasan singkat artikel..."
                                class="w-full resize-none rounded-2xl border bg-slate-950/70 px-4 py-3.5 text-sm leading-6 text-white outline-none transition placeholder:text-slate-600 focus:ring-4
                                    {{ $errors->has('excerpt')
                                        ? 'border-red-500/70 focus:border-red-500 focus:ring-red-500/10'
                                        : 'border-slate-700 focus:border-violet-500/70 focus:ring-violet-500/10'
                                    }}"
                            >{{ $currentExcerpt }}</textarea>

                            @error('excerpt')
                                <p class="mt-2 text-xs font-medium text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Content editor --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10">
                                <x-heroicon-o-bars-3-bottom-left class="h-5 w-5 text-blue-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    Isi Artikel
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Edit konten utama menggunakan rich text editor.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[11px] text-slate-600">
                            <span>
                                <span id="content-word-count">0</span> kata
                            </span>

                            <span class="h-3 w-px bg-slate-700"></span>

                            <span>
                                <span id="content-reading-time">0</span> menit baca
                            </span>
                        </div>
                    </div>

                    <div class="p-4 sm:p-6">
                        <textarea
                            id="content"
                            name="content"
                            rows="18"
                            class="w-full rounded-2xl border bg-slate-950 p-4 text-white
                                {{ $errors->has('content')
                                    ? 'border-red-500/70'
                                    : 'border-slate-700'
                                }}"
                        >{{ old('content', $article->content) }}</textarea>

                        @error('content')
                            <p class="mt-2 text-xs font-medium text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </section>

                {{-- SEO --}}
                <section class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="pointer-events-none absolute inset-0 overflow-hidden">
                        <div class="absolute -bottom-32 -right-32 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>
                    </div>

                    <div class="relative flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10">
                                <x-heroicon-o-magnifying-glass-circle class="h-5 w-5 text-cyan-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    SEO Metadata
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Optimalkan judul dan deskripsi hasil pencarian.
                                </p>
                            </div>
                        </div>

                        <span class="w-fit rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            Optional
                        </span>
                    </div>

                    <div class="relative space-y-5 p-5 sm:p-6">
                        <div class="grid gap-5 lg:grid-cols-2">
                            {{-- Meta title --}}
                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <label
                                        for="meta_title"
                                        class="text-sm font-bold text-slate-300"
                                    >
                                        Meta Title
                                    </label>

                                    <span
                                        id="meta-title-counter"
                                        class="text-[11px] text-slate-600"
                                    >
                                        <span id="meta-title-count">{{ mb_strlen($currentMetaTitle ?? '') }}</span>/60
                                    </span>
                                </div>

                                <input
                                    id="meta_title"
                                    type="text"
                                    name="meta_title"
                                    value="{{ $currentMetaTitle }}"
                                    maxlength="100"
                                    placeholder="Judul SEO untuk Google..."
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                                >

                                @error('meta_title')
                                    <p class="mt-2 text-xs font-medium text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Meta keywords --}}
                            <div>
                                <label
                                    for="meta_keywords"
                                    class="mb-2 block text-sm font-bold text-slate-300"
                                >
                                    Meta Keywords
                                </label>

                                <input
                                    id="meta_keywords"
                                    type="text"
                                    name="meta_keywords"
                                    value="{{ $currentMetaKeywords }}"
                                    placeholder="seo, artikel, website"
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                                >

                                <p class="mt-2 text-xs text-slate-600">
                                    Pisahkan keyword menggunakan koma.
                                </p>

                                @error('meta_keywords')
                                    <p class="mt-2 text-xs font-medium text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Meta description --}}
                        <div>
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label
                                    for="meta_description"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Meta Description
                                </label>

                                <span
                                    id="meta-description-counter"
                                    class="text-[11px] text-slate-600"
                                >
                                    <span id="meta-description-count">{{ mb_strlen($currentMetaDescription ?? '') }}</span>/160
                                </span>
                            </div>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="4"
                                maxlength="300"
                                placeholder="Deskripsi singkat untuk hasil pencarian Google..."
                                class="w-full resize-none rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm leading-6 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                            >{{ $currentMetaDescription }}</textarea>

                            @error('meta_description')
                                <p class="mt-2 text-xs font-medium text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Search preview --}}
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-4">
                            <div class="mb-4 flex items-center justify-between">
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                                    Google Search Preview
                                </p>

                                <span class="rounded-md bg-cyan-500/10 px-2 py-1 text-[10px] font-bold text-cyan-400">
                                    Preview
                                </span>
                            </div>

                            <div class="max-w-2xl">
                                <p class="truncate text-sm text-emerald-400">
                                    {{ config('app.url') }}/artikel/<span id="google-preview-slug">{{ $currentSlug }}</span>
                                </p>

                                <h3
                                    id="google-preview-title"
                                    class="mt-1 line-clamp-1 text-lg font-medium text-blue-400"
                                >
                                    {{ $currentMetaTitle ?: $currentTitle }}
                                </h3>

                                <p
                                    id="google-preview-description"
                                    class="mt-1 line-clamp-2 text-sm leading-6 text-slate-400"
                                >
                                    {{ $currentMetaDescription ?: $currentExcerpt ?: 'Deskripsi artikel akan tampil di bagian ini.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                {{-- Update settings --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10">
                            <x-heroicon-o-arrow-path class="h-5 w-5 text-emerald-400"/>
                        </div>

                        <div>
                            <h2 class="font-bold text-white">
                                Update Settings
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Status dan aksi pembaruan artikel.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 p-5">
                        <div>
                            <label
                                for="status"
                                class="mb-2 block text-sm font-bold text-slate-300"
                            >
                                Status Artikel
                            </label>

                            <div class="relative">
                                <select
                                    id="status"
                                    name="status"
                                    class="w-full appearance-none rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 pr-10 text-sm font-semibold text-white outline-none transition focus:border-emerald-500/70 focus:ring-4 focus:ring-emerald-500/10"
                                >
                                    <option
                                        value="draft"
                                        @selected($currentStatus === 'draft')
                                    >
                                        Draft
                                    </option>

                                    <option
                                        value="published"
                                        @selected($currentStatus === 'published')
                                    >
                                        Published
                                    </option>
                                </select>

                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                    <x-heroicon-o-chevron-down class="h-4 w-4 text-slate-600"/>
                                </div>
                            </div>
                        </div>

                        <div
                            id="status-info"
                            class="rounded-2xl border border-slate-700 bg-slate-950/50 p-4"
                        >
                            <div class="flex items-start gap-3">
                                <div
                                    id="status-info-icon-wrap"
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-800"
                                >
                                    <x-heroicon-o-pencil-square
                                        id="status-info-icon"
                                        class="h-5 w-5 text-slate-400"
                                    />
                                </div>

                                <div>
                                    <p
                                        id="status-info-title"
                                        class="text-sm font-bold text-slate-300"
                                    ></p>

                                    <p
                                        id="status-info-text"
                                        class="mt-1 text-xs leading-5 text-slate-500"
                                    ></p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/45 p-4">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-slate-600">
                                        ID Artikel
                                    </span>

                                    <span class="max-w-[190px] truncate font-mono text-[11px] text-slate-400">
                                        {{ $article->getKey() }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-slate-600">
                                        Status saat ini
                                    </span>

                                    <span class="text-xs font-bold {{ $article->status === 'published' ? 'text-emerald-400' : 'text-amber-400' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-slate-600">
                                        Terbit
                                    </span>

                                    <span class="text-right text-xs font-semibold text-slate-400">
                                        {{ $publishedAt ?: '-' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-xs text-slate-600">
                                        Google Indexed
                                    </span>

                                    <span class="text-xs font-bold {{ $article->google_indexed ? 'text-cyan-400' : 'text-slate-500' }}">
                                        {{ $article->google_indexed ? 'Ya' : 'Belum' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button
                            id="submit-article"
                            type="submit"
                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-950/40 transition hover:-translate-y-0.5 hover:from-violet-500 hover:to-indigo-500 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

                            <svg
                                id="submit-spinner"
                                class="relative hidden h-5 w-5 animate-spin"
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
                                    d="M4 12a8 8 0 018-8v4a4 4 0 0 0-4 4H4z"
                                ></path>
                            </svg>

                            <x-heroicon-o-check
                                id="submit-icon"
                                class="relative h-5 w-5"
                            />

                            <span
                                id="submit-text"
                                class="relative"
                            >
                                Update Artikel
                            </span>
                        </button>

                        <a
                            href="{{ route('admin.articles.index') }}"
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-5 py-3 text-sm font-bold text-slate-300 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white"
                        >
                            Batal
                        </a>
                    </div>
                </section>

                {{-- Thumbnail --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/10">
                                <x-heroicon-o-photo class="h-5 w-5 text-sky-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    Thumbnail
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Ganti gambar utama artikel.
                                </p>
                            </div>
                        </div>

                        @if($hasThumbnail)
                            <span class="rounded-md bg-emerald-500/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                Tersedia
                            </span>
                        @else
                            <span class="rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                Kosong
                            </span>
                        @endif
                    </div>

                    <div class="p-5">
                        <label
                            id="thumbnail-drop-zone"
                            for="thumbnail"
                            class="group relative flex aspect-video cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border border-dashed border-slate-700 bg-slate-950/60 text-center transition hover:border-sky-500/60 hover:bg-sky-500/5"
                        >
                            <img
                                id="thumbnail-preview"
                                src="{{ $thumbnailUrl }}"
                                alt="Thumbnail preview"
                                class="absolute inset-0 h-full w-full object-cover {{ $hasThumbnail ? '' : 'hidden' }}"
                            >

                            <div
                                id="thumbnail-overlay"
                                class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent {{ $hasThumbnail ? '' : 'hidden' }}"
                            ></div>

                            <div
                                id="thumbnail-placeholder"
                                class="relative z-10 flex flex-col items-center px-6 {{ $hasThumbnail ? 'hidden' : '' }}"
                            >
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800 transition group-hover:border-sky-500/30 group-hover:bg-sky-500/10">
                                    <x-heroicon-o-cloud-arrow-up class="h-6 w-6 text-slate-400 transition group-hover:text-sky-400"/>
                                </div>

                                <p class="mt-3 text-sm font-bold text-slate-300">
                                    Pilih atau tarik gambar
                                </p>

                                <p class="mt-1 text-xs text-slate-600">
                                    JPG, PNG, WEBP · Maks. 5 MB
                                </p>
                            </div>

                            <div
                                id="thumbnail-change-label"
                                class="absolute bottom-3 left-3 z-20 rounded-lg bg-black/60 px-3 py-1.5 text-xs font-bold text-white backdrop-blur {{ $hasThumbnail ? '' : 'hidden' }}"
                            >
                                Klik untuk mengganti
                            </div>
                        </label>

                        <input
                            id="thumbnail"
                            type="file"
                            name="thumbnail"
                            accept="image/jpeg,image/png,image/webp"
                            class="hidden"
                        >

                        <div
                            id="thumbnail-file-info"
                            class="mt-3 flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950/50 p-3"
                        >
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-500/10">
                                <x-heroicon-o-photo class="h-4 w-4 text-sky-400"/>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p
                                    id="thumbnail-file-name"
                                    class="truncate text-xs font-bold text-slate-300"
                                >
                                    {{ $hasThumbnail ? basename($article->thumbnail) : 'Belum ada thumbnail' }}
                                </p>

                                <p
                                    id="thumbnail-file-size"
                                    class="mt-0.5 text-[11px] text-slate-600"
                                >
                                    {{ $hasThumbnail ? 'Thumbnail saat ini' : 'Pilih file baru untuk mengganti' }}
                                </p>
                            </div>

                            <button
                                id="reset-thumbnail"
                                type="button"
                                class="hidden h-8 shrink-0 items-center justify-center rounded-lg border border-slate-700 px-2.5 text-[11px] font-bold text-slate-400 transition hover:border-sky-500/30 hover:bg-sky-500/10 hover:text-sky-400"
                            >
                                Reset
                            </button>
                        </div>

                        <p class="mt-3 text-[11px] leading-5 text-slate-600">
                            Thumbnail lama tetap digunakan selama kamu tidak memilih file baru.
                        </p>

                        @error('thumbnail')
                            <p class="mt-2 text-xs font-medium text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </section>

                {{-- Checklist --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10">
                            <x-heroicon-o-clipboard-document-check class="h-5 w-5 text-amber-400"/>
                        </div>

                        <div>
                            <h2 class="font-bold text-white">
                                Update Checklist
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Pemeriksaan singkat sebelum menyimpan.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 p-5">
                        @foreach([
                            ['id' => 'check-title', 'label' => 'Judul artikel valid'],
                            ['id' => 'check-slug', 'label' => 'Slug artikel tersedia'],
                            ['id' => 'check-content', 'label' => 'Isi artikel tersedia'],
                            ['id' => 'check-excerpt', 'label' => 'Excerpt sudah terisi'],
                            ['id' => 'check-thumbnail', 'label' => 'Thumbnail tersedia'],
                            ['id' => 'check-seo', 'label' => 'Metadata SEO tersedia'],
                        ] as $item)
                            <div class="flex items-center gap-3">
                                <span
                                    id="{{ $item['id'] }}"
                                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-slate-700 bg-slate-950 text-slate-600 transition"
                                >
                                    <x-heroicon-o-check class="h-3.5 w-3.5"/>
                                </span>

                                <span class="text-xs text-slate-500">
                                    {{ $item['label'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Wrapper CKEditor */
    .ck.ck-editor {
        --ck-color-base-background: #020617;
        --ck-color-base-foreground: #0f172a;
        --ck-color-base-border: #334155;
        --ck-color-toolbar-background: #0f172a;
        --ck-color-toolbar-border: #334155;
        --ck-color-text: #e2e8f0;
        --ck-color-focus-border: #38bdf8;
        --ck-color-button-default-hover-background: #1e293b;
        --ck-color-button-default-active-background: #334155;
        --ck-color-button-on-background: #334155;
        --ck-color-button-on-color: #ffffff;
        --ck-color-list-background: #0f172a;
        --ck-color-panel-background: #0f172a;
        --ck-color-input-background: #020617;
        --ck-color-input-text: #ffffff;
    }

    /* Toolbar */
    body .ck.ck-toolbar {
        padding: 8px !important;
        background: #0f172a !important;
        border-color: #334155 !important;
        border-radius: 12px 12px 0 0 !important;
    }

    /* Tombol toolbar */
    body .ck.ck-toolbar .ck-button {
        color: #cbd5e1 !important;
        border-radius: 7px !important;
    }

    body .ck.ck-toolbar .ck-button .ck-icon {
        color: #cbd5e1 !important;
    }

    body .ck.ck-toolbar .ck-button:hover {
        background: #1e293b !important;
        color: #ffffff !important;
    }

    body .ck.ck-toolbar .ck-button.ck-on {
        background: #334155 !important;
        color: #ffffff !important;
    }

    /* Area penulisan */
    body .ck.ck-editor__main > .ck-editor__editable,
    body .ck.ck-editor__editable_inline {
        min-height: 560px !important;
        padding: 24px !important;
        background: #020617 !important;
        color: #ffffff !important;
        border-color: #334155 !important;
        caret-color: #ffffff !important;
        box-shadow: none !important;
    }

    body .ck.ck-editor__main > .ck-editor__editable.ck-focused {
        background: #020617 !important;
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1) !important;
    }

    /* Teks di dalam editor */
    body .ck-content,
    body .ck-content p,
    body .ck-content li,
    body .ck-content span,
    body .ck-content div {
        color: #e2e8f0 !important;
    }

    body .ck-content h1,
    body .ck-content h2,
    body .ck-content h3,
    body .ck-content h4 {
        color: #ffffff !important;
    }

    body .ck-content strong {
        color: #ffffff !important;
    }

    body .ck-content a {
        color: #38bdf8 !important;
    }

    /* Placeholder */
    body .ck.ck-editor__editable .ck-placeholder::before {
        color: #64748b !important;
    }

    /* Dropdown */
    body .ck.ck-dropdown__panel,
    body .ck.ck-list,
    body .ck.ck-balloon-panel {
        background: #0f172a !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    body .ck.ck-list__item .ck-button {
        color: #cbd5e1 !important;
    }

    body .ck.ck-list__item .ck-button:hover,
    body .ck.ck-list__item .ck-button.ck-on {
        background: #1e293b !important;
        color: #ffffff !important;
    }

    /* Input dialog link */
    body .ck.ck-input {
        background: #020617 !important;
        color: #ffffff !important;
        border-color: #334155 !important;
    }

    body .ck.ck-label {
        color: #94a3b8 !important;
    }

    /* Table */
    body .ck-content table td,
    body .ck-content table th {
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }

    body .ck-content table th {
        background: #0f172a !important;
    }

    /* Powered by CKEditor */
    body .ck-powered-by {
        background: #0f172a !important;
        color: #64748b !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('article-edit-app');
    const form = document.getElementById('article-edit-form');

    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('title-count');

    const slugInput = document.getElementById('slug');
    const slugPreview = document.getElementById('slug-preview');
    const googlePreviewSlug =
        document.getElementById('google-preview-slug');

    const excerptInput = document.getElementById('excerpt');
    const excerptCount = document.getElementById('excerpt-count');

    const metaTitleInput = document.getElementById('meta_title');
    const metaTitleCount =
        document.getElementById('meta-title-count');
    const metaTitleCounter =
        document.getElementById('meta-title-counter');

    const metaKeywordsInput =
        document.getElementById('meta_keywords');

    const metaDescriptionInput =
        document.getElementById('meta_description');
    const metaDescriptionCount =
        document.getElementById('meta-description-count');
    const metaDescriptionCounter =
        document.getElementById('meta-description-counter');

    const googlePreviewTitle =
        document.getElementById('google-preview-title');
    const googlePreviewDescription =
        document.getElementById('google-preview-description');

    const statusInput = document.getElementById('status');
    const statusInfo = document.getElementById('status-info');
    const statusInfoIconWrap =
        document.getElementById('status-info-icon-wrap');
    const statusInfoIcon =
        document.getElementById('status-info-icon');
    const statusInfoTitle =
        document.getElementById('status-info-title');
    const statusInfoText =
        document.getElementById('status-info-text');

    const submitButton =
        document.getElementById('submit-article');
    const submitSpinner =
        document.getElementById('submit-spinner');
    const submitIcon =
        document.getElementById('submit-icon');
    const submitText =
        document.getElementById('submit-text');

    const thumbnailInput =
        document.getElementById('thumbnail');
    const thumbnailDropZone =
        document.getElementById('thumbnail-drop-zone');
    const thumbnailPreview =
        document.getElementById('thumbnail-preview');
    const thumbnailOverlay =
        document.getElementById('thumbnail-overlay');
    const thumbnailPlaceholder =
        document.getElementById('thumbnail-placeholder');
    const thumbnailChangeLabel =
        document.getElementById('thumbnail-change-label');
    const thumbnailFileName =
        document.getElementById('thumbnail-file-name');
    const thumbnailFileSize =
        document.getElementById('thumbnail-file-size');
    const resetThumbnailButton =
        document.getElementById('reset-thumbnail');

    const contentWordCount =
        document.getElementById('content-word-count');
    const contentReadingTime =
        document.getElementById('content-reading-time');

    const originalSlug = app.dataset.originalSlug || '';
    const originalThumbnail =
        app.dataset.originalThumbnail || '';

    let editorInstance = null;
    let thumbnailChanged = false;

    function slugify(value) {
        return String(value || '')
            .toLowerCase()
            .trim()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .replace(/-{2,}/g, '-');
    }

    function stripHtml(value) {
        const element = document.createElement('div');
        element.innerHTML = value || '';

        return element.textContent ||
            element.innerText ||
            '';
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    function setChecklist(id, completed) {
        const element = document.getElementById(id);

        if (!element) {
            return;
        }

        element.className = completed
            ? 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 transition'
            : 'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-slate-700 bg-slate-950 text-slate-600 transition';
    }

    function updateSlugPreview() {
        const slug =
            slugInput.value.trim() || 'judul-artikel';

        slugPreview.textContent = slug;
        googlePreviewSlug.textContent = slug;
    }

    function updateGooglePreview() {
        googlePreviewTitle.textContent =
            metaTitleInput.value.trim() ||
            titleInput.value.trim() ||
            'Judul artikel akan tampil di sini';

        googlePreviewDescription.textContent =
            metaDescriptionInput.value.trim() ||
            excerptInput.value.trim() ||
            'Deskripsi artikel akan tampil di bagian ini.';
    }

    function updateContentStats(value) {
        const text = stripHtml(value).trim();

        const words = text
            ? text.split(/\s+/).filter(Boolean).length
            : 0;

        contentWordCount.textContent =
            words.toLocaleString('id-ID');

        contentReadingTime.textContent =
            words > 0
                ? Math.max(1, Math.ceil(words / 200))
                : 0;

        setChecklist('check-content', words >= 10);
    }

    function updateCounters() {
        titleCount.textContent =
            titleInput.value.length.toLocaleString('id-ID');

        excerptCount.textContent =
            excerptInput.value.length.toLocaleString('id-ID');

        const metaTitleLength =
            metaTitleInput.value.length;

        metaTitleCount.textContent =
            metaTitleLength.toLocaleString('id-ID');

        metaTitleCounter.className =
            metaTitleLength > 60
                ? 'text-[11px] font-semibold text-amber-400'
                : 'text-[11px] text-slate-600';

        const metaDescriptionLength =
            metaDescriptionInput.value.length;

        metaDescriptionCount.textContent =
            metaDescriptionLength.toLocaleString('id-ID');

        metaDescriptionCounter.className =
            metaDescriptionLength > 160
                ? 'text-[11px] font-semibold text-amber-400'
                : 'text-[11px] text-slate-600';
    }

    function updateChecklist() {
        setChecklist(
            'check-title',
            titleInput.value.trim().length >= 5
        );

        setChecklist(
            'check-slug',
            slugInput.value.trim().length >= 3
        );

        setChecklist(
            'check-excerpt',
            excerptInput.value.trim().length >= 20
        );

        setChecklist(
            'check-thumbnail',
            Boolean(originalThumbnail) || thumbnailChanged
        );

        setChecklist(
            'check-seo',
            Boolean(
                metaTitleInput.value.trim() ||
                metaDescriptionInput.value.trim() ||
                metaKeywordsInput.value.trim()
            )
        );
    }

    function updateStatusInfo() {
        const published =
            statusInput.value === 'published';

        statusInfo.className = published
            ? 'rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-4'
            : 'rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4';

        statusInfoIconWrap.className = published
            ? 'flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10'
            : 'flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-500/10';

        statusInfoIcon.className = published
            ? 'h-5 w-5 text-emerald-400'
            : 'h-5 w-5 text-amber-400';

        statusInfoTitle.className = published
            ? 'text-sm font-bold text-emerald-300'
            : 'text-sm font-bold text-amber-300';

        statusInfoText.className = published
            ? 'mt-1 text-xs leading-5 text-emerald-200/60'
            : 'mt-1 text-xs leading-5 text-amber-200/60';

        statusInfoTitle.textContent = published
            ? 'Artikel Dipublikasikan'
            : 'Artikel Disimpan sebagai Draft';

        statusInfoText.textContent = published
            ? 'Perubahan akan langsung tampil setelah berhasil diperbarui.'
            : 'Artikel tidak akan terlihat oleh pengunjung sampai dipublikasikan.';

        submitText.textContent = published
            ? 'Update & Publish'
            : 'Update Draft';
    }

    function showThumbnail(file) {
        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        if (!allowedTypes.includes(file.type)) {
            thumbnailInput.value = '';
            alert('Thumbnail harus berupa JPG, PNG, atau WEBP.');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            thumbnailInput.value = '';
            alert('Ukuran thumbnail maksimal 5 MB.');
            return;
        }

        const objectUrl = URL.createObjectURL(file);

        thumbnailPreview.src = objectUrl;
        thumbnailPreview.classList.remove('hidden');
        thumbnailOverlay.classList.remove('hidden');
        thumbnailPlaceholder.classList.add('hidden');
        thumbnailChangeLabel.classList.remove('hidden');

        thumbnailFileName.textContent = file.name;
        thumbnailFileSize.textContent =
            `${formatFileSize(file.size)} · File baru`;

        resetThumbnailButton.classList.remove('hidden');
        resetThumbnailButton.classList.add('flex');

        thumbnailChanged = true;
        updateChecklist();
    }

    function resetThumbnail() {
        thumbnailInput.value = '';
        thumbnailChanged = false;

        if (originalThumbnail) {
            thumbnailPreview.src = originalThumbnail;
            thumbnailPreview.classList.remove('hidden');
            thumbnailOverlay.classList.remove('hidden');
            thumbnailPlaceholder.classList.add('hidden');
            thumbnailChangeLabel.classList.remove('hidden');

            thumbnailFileName.textContent =
                originalThumbnail.split('/').pop() ||
                'Thumbnail saat ini';

            thumbnailFileSize.textContent =
                'Thumbnail saat ini';
        } else {
            thumbnailPreview.src = '';
            thumbnailPreview.classList.add('hidden');
            thumbnailOverlay.classList.add('hidden');
            thumbnailPlaceholder.classList.remove('hidden');
            thumbnailChangeLabel.classList.add('hidden');

            thumbnailFileName.textContent =
                'Belum ada thumbnail';

            thumbnailFileSize.textContent =
                'Pilih file baru untuk mengganti';
        }

        resetThumbnailButton.classList.add('hidden');
        resetThumbnailButton.classList.remove('flex');

        updateChecklist();
    }

    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'blockQuote',
                'insertTable',
                '|',
                'undo',
                'redo'
            ]
        })
        .then(editor => {
            editorInstance = editor;
            updateContentStats(editor.getData());

            editor.model.document.on('change:data', () => {
                updateContentStats(editor.getData());
            });
        })
        .catch(error => {
            console.error('CKEditor error:', error);

            const textarea =
                document.getElementById('content');

            textarea.addEventListener('input', () => {
                updateContentStats(textarea.value);
            });

            updateContentStats(textarea.value);
        });

    titleInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    slugInput.addEventListener('input', () => {
        slugInput.value = slugify(slugInput.value);
        updateSlugPreview();
        updateChecklist();
    });

    document
        .getElementById('generate-slug')
        .addEventListener('click', () => {
            slugInput.value =
                slugify(titleInput.value);

            updateSlugPreview();
            updateChecklist();
            slugInput.focus();
        });

    document
        .getElementById('restore-original-slug')
        .addEventListener('click', () => {
            slugInput.value = originalSlug;
            updateSlugPreview();
            updateChecklist();
        });

    excerptInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    metaTitleInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    metaDescriptionInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    metaKeywordsInput.addEventListener(
        'input',
        updateChecklist
    );

    statusInput.addEventListener(
        'change',
        updateStatusInfo
    );

    thumbnailInput.addEventListener('change', () => {
        showThumbnail(thumbnailInput.files?.[0]);
    });

    resetThumbnailButton.addEventListener(
        'click',
        resetThumbnail
    );

    ['dragenter', 'dragover'].forEach(eventName => {
        thumbnailDropZone.addEventListener(
            eventName,
            event => {
                event.preventDefault();

                thumbnailDropZone.classList.add(
                    'border-sky-500',
                    'bg-sky-500/10'
                );
            }
        );
    });

    ['dragleave', 'drop'].forEach(eventName => {
        thumbnailDropZone.addEventListener(
            eventName,
            event => {
                event.preventDefault();

                thumbnailDropZone.classList.remove(
                    'border-sky-500',
                    'bg-sky-500/10'
                );
            }
        );
    });

    thumbnailDropZone.addEventListener('drop', event => {
        const file = event.dataTransfer.files?.[0];

        if (!file) {
            return;
        }

        const transfer = new DataTransfer();
        transfer.items.add(file);
        thumbnailInput.files = transfer.files;

        showThumbnail(file);
    });

    form.addEventListener('submit', () => {
        if (editorInstance) {
            document.getElementById('content').value =
                editorInstance.getData();
        }

        submitButton.disabled = true;
        submitSpinner.classList.remove('hidden');
        submitIcon.classList.add('hidden');

        submitText.textContent =
            statusInput.value === 'published'
                ? 'Memperbarui Artikel...'
                : 'Menyimpan Draft...';
    });

    updateSlugPreview();
    updateCounters();
    updateGooglePreview();
    updateChecklist();
    updateStatusInfo();
});
</script>
@endpush