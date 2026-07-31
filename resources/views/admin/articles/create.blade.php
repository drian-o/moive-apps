@extends('layouts.admin')

@section('title', 'Tambah Artikel')
@section('page-title', 'Tambah Artikel')

@section('content')
<div
    id="article-create-app"
    class="mx-auto w-full max-w-[1500px]"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 via-indigo-500 to-blue-600 shadow-lg shadow-indigo-950/40">
                    <x-heroicon-o-document-plus class="relative z-10 h-6 w-6 text-white"/>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Tambah Artikel
                    </h1>

                    <p class="text-sm text-slate-500">
                        Article Publishing Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-2xl text-sm leading-6 text-slate-400">
                Tulis konten, atur metadata SEO, unggah thumbnail, lalu simpan sebagai draft atau langsung publish.
            </p>
        </div>

        <a
            href="{{ route('admin.articles.index') }}"
            class="flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-bold text-slate-300 transition hover:border-slate-600 hover:bg-slate-800 hover:text-white"
        >
            <x-heroicon-o-arrow-left class="h-5 w-5"/>
            Kembali ke Articles
        </a>
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
                        Beberapa data belum valid
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
        id="article-form"
        action="{{ route('admin.articles.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_390px]">
            {{-- Main editor --}}
            <div class="space-y-6">
                {{-- Basic information --}}
                <section class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="pointer-events-none absolute inset-0 overflow-hidden">
                        <div class="absolute -left-28 -top-28 h-64 w-64 rounded-full bg-violet-500/10 blur-3xl"></div>
                    </div>

                    <div class="relative flex items-center justify-between border-b border-slate-800 px-5 py-4 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/10">
                                <x-heroicon-o-pencil-square class="h-5 w-5 text-violet-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    Informasi Artikel
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Judul, slug, dan ringkasan utama.
                                </p>
                            </div>
                        </div>

                        <span class="rounded-md bg-violet-500/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-violet-400">
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
                                    <span id="title-count">{{ mb_strlen(old('title', '')) }}</span>/200
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
                                    value="{{ old('title') }}"
                                    maxlength="200"
                                    autocomplete="off"
                                    placeholder="Masukkan judul artikel yang menarik..."
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
                            <div class="mb-2 flex items-center justify-between gap-3">
                                <label
                                    for="slug"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Slug
                                </label>

                                <button
                                    id="generate-slug"
                                    type="button"
                                    class="text-xs font-semibold text-violet-400 transition hover:text-violet-300"
                                >
                                    Generate ulang
                                </button>
                            </div>

                            <div class="group relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="font-mono text-sm text-slate-600">/</span>
                                </div>

                                <input
                                    id="slug"
                                    type="text"
                                    name="slug"
                                    value="{{ old('slug') }}"
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
                                    Gunakan huruf kecil, angka, dan tanda minus.
                                </p>

                                <p class="truncate font-mono text-[11px] text-violet-400/70">
                                    /<span id="slug-preview">{{ old('slug', 'judul-artikel') }}</span>
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
                                    <span id="excerpt-count">{{ mb_strlen(old('excerpt', '')) }}</span>/300
                                </span>
                            </div>

                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="4"
                                maxlength="300"
                                placeholder="Ringkasan singkat artikel yang akan muncul pada daftar artikel..."
                                class="w-full resize-none rounded-2xl border bg-slate-950/70 px-4 py-3.5 text-sm leading-6 text-white outline-none transition placeholder:text-slate-600 focus:ring-4
                                    {{ $errors->has('excerpt')
                                        ? 'border-red-500/70 focus:border-red-500 focus:ring-red-500/10'
                                        : 'border-slate-700 focus:border-violet-500/70 focus:ring-violet-500/10'
                                    }}"
                            >{{ old('excerpt') }}</textarea>

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
                                    Tulis dan format konten menggunakan editor.
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
                        >{{ old('content') }}</textarea>

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

                    <div class="relative flex items-center justify-between border-b border-slate-800 px-5 py-4 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10">
                                <x-heroicon-o-magnifying-glass-circle class="h-5 w-5 text-cyan-400"/>
                            </div>

                            <div>
                                <h2 class="font-bold text-white">
                                    SEO Metadata
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500">
                                    Optimalkan tampilan artikel di mesin pencari.
                                </p>
                            </div>
                        </div>

                        <span class="rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
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
                                        <span id="meta-title-count">{{ mb_strlen(old('meta_title', '')) }}</span>/60
                                    </span>
                                </div>

                                <input
                                    id="meta_title"
                                    type="text"
                                    name="meta_title"
                                    value="{{ old('meta_title') }}"
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
                                    value="{{ old('meta_keywords') }}"
                                    placeholder="seo, artikel, website"
                                    class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                                >

                                <p class="mt-2 text-xs text-slate-600">
                                    Pisahkan setiap keyword dengan koma.
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
                                    <span id="meta-description-count">{{ mb_strlen(old('meta_description', '')) }}</span>/160
                                </span>
                            </div>

                            <textarea
                                id="meta_description"
                                name="meta_description"
                                rows="4"
                                maxlength="300"
                                placeholder="Deskripsi singkat yang menarik untuk hasil pencarian Google..."
                                class="w-full resize-none rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm leading-6 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                            >{{ old('meta_description') }}</textarea>

                            @error('meta_description')
                                <p class="mt-2 text-xs font-medium text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Google preview --}}
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
                                    {{ config('app.url') }}/artikel/<span id="google-preview-slug">{{ old('slug', 'judul-artikel') }}</span>
                                </p>

                                <h3
                                    id="google-preview-title"
                                    class="mt-1 line-clamp-1 text-lg font-medium text-blue-400"
                                >
                                    {{ old('meta_title') ?: old('title') ?: 'Judul artikel akan tampil di sini' }}
                                </h3>

                                <p
                                    id="google-preview-description"
                                    class="mt-1 line-clamp-2 text-sm leading-6 text-slate-400"
                                >
                                    {{ old('meta_description') ?: old('excerpt') ?: 'Deskripsi artikel akan tampil di sini setelah Anda mengisi meta description atau excerpt.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                {{-- Publish settings --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10">
                            <x-heroicon-o-paper-airplane class="h-5 w-5 text-emerald-400"/>
                        </div>

                        <div>
                            <h2 class="font-bold text-white">
                                Publish Settings
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Status dan aksi penyimpanan.
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
                                        @selected(old('status', 'draft') === 'draft')
                                    >
                                        Draft
                                    </option>

                                    <option
                                        value="published"
                                        @selected(old('status') === 'published')
                                    >
                                        Publish
                                    </option>
                                </select>

                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                    <x-heroicon-o-chevron-down class="h-4 w-4 text-slate-600"/>
                                </div>
                            </div>
                        </div>

                        <div
                            id="status-info"
                            class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4"
                        >
                            <div class="flex items-start gap-3">
                                <x-heroicon-o-pencil-square
                                    id="status-info-icon"
                                    class="mt-0.5 h-5 w-5 shrink-0 text-amber-400"
                                />

                                <div>
                                    <p
                                        id="status-info-title"
                                        class="text-sm font-bold text-amber-300"
                                    >
                                        Simpan sebagai Draft
                                    </p>

                                    <p
                                        id="status-info-text"
                                        class="mt-1 text-xs leading-5 text-amber-200/60"
                                    >
                                        Artikel disimpan tetapi belum tampil untuk pembaca.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-3">
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
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
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
                                    Simpan Artikel
                                </span>
                            </button>

                            <a
                                href="{{ route('admin.articles.index') }}"
                                class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-5 py-3 text-sm font-bold text-slate-300 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white"
                            >
                                Batal
                            </a>
                        </div>
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
                                    Gambar utama artikel.
                                </p>
                            </div>
                        </div>

                        <span class="rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            Optional
                        </span>
                    </div>

                    <div class="p-5">
                        <label
                            id="thumbnail-drop-zone"
                            for="thumbnail"
                            class="group relative flex aspect-video cursor-pointer flex-col items-center justify-center overflow-hidden rounded-2xl border border-dashed border-slate-700 bg-slate-950/60 text-center transition hover:border-sky-500/60 hover:bg-sky-500/5"
                        >
                            <img
                                id="thumbnail-preview"
                                src=""
                                alt="Thumbnail preview"
                                class="absolute inset-0 hidden h-full w-full object-cover"
                            >

                            <div
                                id="thumbnail-overlay"
                                class="absolute inset-0 hidden bg-gradient-to-t from-black/70 via-black/20 to-transparent"
                            ></div>

                            <div
                                id="thumbnail-placeholder"
                                class="relative z-10 flex flex-col items-center px-6"
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
                                class="absolute bottom-3 left-3 z-20 hidden rounded-lg bg-black/60 px-3 py-1.5 text-xs font-bold text-white backdrop-blur"
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
                            class="mt-3 hidden items-center gap-3 rounded-xl border border-slate-800 bg-slate-950/50 p-3"
                        >
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-500/10">
                                <x-heroicon-o-photo class="h-4 w-4 text-sky-400"/>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p
                                    id="thumbnail-file-name"
                                    class="truncate text-xs font-bold text-slate-300"
                                ></p>

                                <p
                                    id="thumbnail-file-size"
                                    class="mt-0.5 text-[11px] text-slate-600"
                                ></p>
                            </div>

                            <button
                                id="remove-thumbnail"
                                type="button"
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-500/10 hover:text-red-400"
                                title="Hapus thumbnail"
                            >
                                <x-heroicon-o-x-mark class="h-5 w-5"/>
                            </button>
                        </div>

                        @error('thumbnail')
                            <p class="mt-2 text-xs font-medium text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </section>

                {{-- Publishing checklist --}}
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                    <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10">
                            <x-heroicon-o-clipboard-document-check class="h-5 w-5 text-amber-400"/>
                        </div>

                        <div>
                            <h2 class="font-bold text-white">
                                Publishing Checklist
                            </h2>

                            <p class="mt-0.5 text-xs text-slate-500">
                                Pastikan data penting sudah diisi.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 p-5">
                        @php
                            $checklist = [
                                ['id' => 'check-title', 'label' => 'Judul artikel terisi'],
                                ['id' => 'check-slug', 'label' => 'Slug sudah tersedia'],
                                ['id' => 'check-content', 'label' => 'Isi artikel ditulis'],
                                ['id' => 'check-excerpt', 'label' => 'Excerpt sudah dibuat'],
                                ['id' => 'check-thumbnail', 'label' => 'Thumbnail dipilih'],
                                ['id' => 'check-seo', 'label' => 'Metadata SEO diisi'],
                            ];
                        @endphp

                        @foreach($checklist as $item)
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
    const form = document.getElementById('article-form');

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
    const thumbnailFileInfo =
        document.getElementById('thumbnail-file-info');
    const thumbnailFileName =
        document.getElementById('thumbnail-file-name');
    const thumbnailFileSize =
        document.getElementById('thumbnail-file-size');
    const removeThumbnailButton =
        document.getElementById('remove-thumbnail');

    const contentWordCount =
        document.getElementById('content-word-count');
    const contentReadingTime =
        document.getElementById('content-reading-time');

    let editorInstance = null;
    let slugEditedManually =
        slugInput.value.trim().length > 0;
    let metaTitleEditedManually =
        metaTitleInput.value.trim().length > 0;
    let thumbnailSelected = false;

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
        return element.textContent || element.innerText || '';
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
        const title =
            metaTitleInput.value.trim() ||
            titleInput.value.trim() ||
            'Judul artikel akan tampil di sini';

        const description =
            metaDescriptionInput.value.trim() ||
            excerptInput.value.trim() ||
            'Deskripsi artikel akan tampil di sini setelah Anda mengisi meta description atau excerpt.';

        googlePreviewTitle.textContent = title;
        googlePreviewDescription.textContent = description;
    }

    function updateContentStats(value) {
        const text = stripHtml(value).trim();
        const words = text
            ? text.split(/\s+/).filter(Boolean).length
            : 0;

        contentWordCount.textContent =
            words.toLocaleString('id-ID');

        contentReadingTime.textContent =
            words > 0 ? Math.max(1, Math.ceil(words / 200)) : 0;

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
            thumbnailSelected
        );

        setChecklist(
            'check-seo',
            Boolean(
                metaTitleInput.value.trim() ||
                metaDescriptionInput.value.trim() ||
                document.getElementById('meta_keywords').value.trim()
            )
        );
    }

    function updateStatusInfo() {
        const published =
            statusInput.value === 'published';

        statusInfo.className = published
            ? 'rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-4'
            : 'rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4';

        statusInfoIcon.className = published
            ? 'mt-0.5 h-5 w-5 shrink-0 text-emerald-400'
            : 'mt-0.5 h-5 w-5 shrink-0 text-amber-400';

        statusInfoTitle.className = published
            ? 'text-sm font-bold text-emerald-300'
            : 'text-sm font-bold text-amber-300';

        statusInfoText.className = published
            ? 'mt-1 text-xs leading-5 text-emerald-200/60'
            : 'mt-1 text-xs leading-5 text-amber-200/60';

        statusInfoTitle.textContent = published
            ? 'Publish Sekarang'
            : 'Simpan sebagai Draft';

        statusInfoText.textContent = published
            ? 'Artikel akan langsung tersedia setelah berhasil disimpan.'
            : 'Artikel disimpan tetapi belum tampil untuk pembaca.';

        submitText.textContent = published
            ? 'Publish Artikel'
            : 'Simpan Draft';
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
            `${formatFileSize(file.size)} · ${file.type}`;

        thumbnailFileInfo.classList.remove('hidden');
        thumbnailFileInfo.classList.add('flex');

        thumbnailSelected = true;
        updateChecklist();
    }

    function clearThumbnail() {
        thumbnailInput.value = '';
        thumbnailPreview.src = '';
        thumbnailPreview.classList.add('hidden');
        thumbnailOverlay.classList.add('hidden');
        thumbnailPlaceholder.classList.remove('hidden');
        thumbnailChangeLabel.classList.add('hidden');

        thumbnailFileInfo.classList.add('hidden');
        thumbnailFileInfo.classList.remove('flex');

        thumbnailFileName.textContent = '';
        thumbnailFileSize.textContent = '';

        thumbnailSelected = false;
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

            const contentTextarea =
                document.getElementById('content');

            contentTextarea.addEventListener('input', () => {
                updateContentStats(contentTextarea.value);
            });

            updateContentStats(contentTextarea.value);
        });

    titleInput.addEventListener('input', () => {
        if (!slugEditedManually) {
            slugInput.value =
                slugify(titleInput.value);
        }

        if (!metaTitleEditedManually) {
            metaTitleInput.value =
                titleInput.value.substring(0, 100);
        }

        updateSlugPreview();
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    slugInput.addEventListener('input', () => {
        slugEditedManually =
            slugInput.value.trim().length > 0;

        slugInput.value =
            slugify(slugInput.value);

        updateSlugPreview();
        updateChecklist();
    });

    document
        .getElementById('generate-slug')
        .addEventListener('click', () => {
            slugInput.value =
                slugify(titleInput.value);

            slugEditedManually = true;

            updateSlugPreview();
            updateChecklist();

            slugInput.focus();
        });

    excerptInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    metaTitleInput.addEventListener('input', () => {
        metaTitleEditedManually =
            metaTitleInput.value.trim().length > 0;

        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    metaDescriptionInput.addEventListener('input', () => {
        updateCounters();
        updateGooglePreview();
        updateChecklist();
    });

    document
        .getElementById('meta_keywords')
        .addEventListener('input', updateChecklist);

    statusInput.addEventListener(
        'change',
        updateStatusInfo
    );

    thumbnailInput.addEventListener('change', () => {
        showThumbnail(thumbnailInput.files?.[0]);
    });

    removeThumbnailButton.addEventListener(
        'click',
        clearThumbnail
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
                ? 'Mempublikasikan...'
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