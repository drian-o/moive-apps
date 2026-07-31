@extends('layouts.admin')

@section('title', 'Google Indexing API')
@section('page-title', 'Google Indexing API')

@php
    $isConnected = (bool) data_get($googleSetting, 'is_connected');
    $clientEmail = data_get($googleSetting, 'credential.client_email', '-');
    $projectId = data_get($googleSetting, 'credential.project_id', '-');
    $lastTestAt = data_get($googleSetting, 'last_test_at');
    $submitResult = session('submit_result');
@endphp

@section('content')
<div
    id="google-indexing-app"
    class="mx-auto w-full max-w-[1500px]"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-sky-400 via-blue-500 to-indigo-600 shadow-lg shadow-blue-950/40">
                    <x-heroicon-o-bolt class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Google Indexing API
                    </h1>

                    <p class="text-sm text-slate-500">
                        Service Account & URL Submission Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Kelola kredensial Google, periksa koneksi, dan kirim URL dari satu dashboard.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-2">
                <span class="text-xs text-slate-500">Project</span>
                <span class="ml-2 text-xs font-semibold text-sky-400">
                    {{ $projectId !== '-' ? $projectId : 'Not configured' }}
                </span>
            </div>

            @if($isConnected)
                <div class="flex items-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>

                    <span class="text-xs font-bold text-emerald-400">
                        Connected
                    </span>
                </div>
            @else
                <div class="flex items-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-2">
                    <span class="h-2 w-2 rounded-full bg-red-500"></span>

                    <span class="text-xs font-bold text-red-400">
                        Disconnected
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Flash / validation --}}
    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 p-4">
            <div class="flex items-start gap-3">
                <x-heroicon-o-exclamation-triangle class="mt-0.5 h-5 w-5 shrink-0 text-red-400"/>

                <div>
                    <p class="text-sm font-bold text-red-300">
                        Ada data yang perlu diperbaiki.
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-red-200/80">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4">
            <div class="flex items-center gap-3">
                <x-heroicon-o-check-circle class="h-5 w-5 shrink-0 text-emerald-400"/>
                <p class="text-sm font-semibold text-emerald-300">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 p-4">
            <div class="flex items-center gap-3">
                <x-heroicon-o-x-circle class="h-5 w-5 shrink-0 text-red-400"/>
                <p class="text-sm font-semibold text-red-300">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    {{-- Main credentials workspace --}}
    <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-sky-600/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-32 h-80 w-80 rounded-full bg-indigo-600/10 blur-3xl"></div>
        </div>

        {{-- Window bar --}}
        <div class="relative flex flex-col gap-4 border-b border-slate-800 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                </div>

                <div class="hidden h-6 w-px bg-slate-700 sm:block"></div>

                <div>
                    <h2 class="font-bold text-white">
                        Service Account Console
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Status kredensial dan konfigurasi koneksi Google.
                    </p>
                </div>
            </div>

            <div class="flex w-fit items-center gap-2 rounded-full border border-slate-700 bg-slate-950/60 px-3 py-1.5">
                <x-heroicon-o-shield-check class="h-4 w-4 {{ $isConnected ? 'text-emerald-400' : 'text-slate-500' }}"/>

                <span class="text-xs font-semibold {{ $isConnected ? 'text-emerald-400' : 'text-slate-400' }}">
                    {{ $isConnected ? 'Credential verified' : 'Credential not verified' }}
                </span>
            </div>
        </div>

        <div class="relative grid grid-cols-1 xl:grid-cols-[1fr_1.15fr_1fr]">
            {{-- Connection status --}}
            <section class="border-b border-slate-800 p-5 sm:p-6 xl:border-b-0 xl:border-r">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-white">
                            Connection Status
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Informasi Service Account aktif.
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $isConnected ? 'bg-emerald-500/10' : 'bg-slate-800' }}">
                        <x-heroicon-o-server-stack class="h-5 w-5 {{ $isConnected ? 'text-emerald-400' : 'text-slate-500' }}"/>
                    </div>
                </div>

                @if($googleSetting)
                    <div class="space-y-3">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                                        Client Email
                                    </p>

                                    <p
                                        id="client-email-value"
                                        class="mt-2 break-all text-sm font-medium leading-6 text-slate-200"
                                    >
                                        {{ $clientEmail }}
                                    </p>
                                </div>

                                @if($clientEmail !== '-')
                                    <button
                                        type="button"
                                        class="copy-value flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-500 transition hover:bg-sky-500/10 hover:text-sky-400"
                                        data-copy="{{ $clientEmail }}"
                                        title="Copy client email"
                                    >
                                        <x-heroicon-o-clipboard class="h-4 w-4"/>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1 2xl:grid-cols-2">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                                    Project ID
                                </p>

                                <p class="mt-2 break-all text-sm font-semibold text-white">
                                    {{ $projectId }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                                    Last Test
                                </p>

                                <p class="mt-2 text-sm font-semibold text-white">
                                    {{ $lastTestAt ? optional($lastTestAt)->format('d M Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl border {{ $isConnected ? 'border-emerald-500/20 bg-emerald-500/5' : 'border-amber-500/20 bg-amber-500/5' }} p-4">
                            <div class="flex items-start gap-3">
                                @if($isConnected)
                                    <x-heroicon-o-check-circle class="mt-0.5 h-5 w-5 shrink-0 text-emerald-400"/>
                                @else
                                    <x-heroicon-o-exclamation-triangle class="mt-0.5 h-5 w-5 shrink-0 text-amber-400"/>
                                @endif

                                <div>
                                    <p class="text-sm font-bold {{ $isConnected ? 'text-emerald-300' : 'text-amber-300' }}">
                                        {{ $isConnected ? 'Koneksi siap digunakan' : 'Kredensial perlu diuji' }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 {{ $isConnected ? 'text-emerald-200/60' : 'text-amber-200/60' }}">
                                        {{ $isConnected
                                            ? 'Service Account sudah terhubung dan siap menerima permintaan.'
                                            : 'Tekan Test Connection setelah mengunggah file JSON.'
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex min-h-[310px] flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-6 text-center">
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-800">
                            <x-heroicon-o-key class="h-7 w-7 text-slate-500"/>
                        </div>

                        <h4 class="font-bold text-slate-300">
                            Service Account belum tersedia
                        </h4>

                        <p class="mt-2 max-w-xs text-sm leading-6 text-slate-600">
                            Unggah file credential JSON terlebih dahulu.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Credential manager --}}
            <section class="border-b border-slate-800 p-5 sm:p-6 xl:border-b-0 xl:border-r">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-white">
                            Credential Manager
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Unggah atau perbarui file Service Account JSON.
                        </p>
                    </div>

                    <span class="rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        JSON only
                    </span>
                </div>

                <form
                    id="credential-upload-form"
                    action="{{ route('admin.google-indexing.upload') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <label
                        id="credential-drop-zone"
                        for="credential"
                        class="group flex min-h-[205px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-950/50 px-6 py-7 text-center transition hover:border-sky-500/60 hover:bg-sky-500/5"
                    >
                        <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800/80 transition group-hover:border-sky-500/30 group-hover:bg-sky-500/10">
                            <x-heroicon-o-cloud-arrow-up class="h-7 w-7 text-slate-400 transition group-hover:text-sky-400"/>
                        </div>

                        <p class="text-sm font-bold text-slate-300">
                            Pilih atau tarik file JSON
                        </p>

                        <p class="mt-2 text-xs leading-5 text-slate-600">
                            File credential Service Account Google.
                        </p>

                        <div
                            id="credential-preview"
                            class="mt-4 hidden w-full items-center gap-3 rounded-xl border border-sky-500/20 bg-sky-500/10 p-3 text-left"
                        >
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-500/15">
                                <x-heroicon-o-document-text class="h-5 w-5 text-sky-400"/>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p
                                    id="credential-file-name"
                                    class="truncate text-xs font-bold text-sky-200"
                                ></p>

                                <p
                                    id="credential-file-size"
                                    class="mt-0.5 text-[11px] text-sky-300/60"
                                ></p>
                            </div>
                        </div>
                    </label>

                    <input
                        id="credential"
                        type="file"
                        name="credential"
                        accept=".json,application/json"
                        class="hidden"
                    >

                    <button
                        type="submit"
                        data-loading-text="Uploading..."
                        class="submit-with-loading mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-950/30 transition hover:-translate-y-0.5 hover:from-sky-500 hover:to-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <x-heroicon-o-arrow-up-tray class="button-icon h-5 w-5"/>
                        <span class="button-label">
                            Upload Credential
                        </span>
                    </button>
                </form>

                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <form
                        action="{{ route('admin.google-indexing.test') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            data-loading-text="Testing..."
                            {{ !$googleSetting ? 'disabled' : '' }}
                            class="submit-with-loading flex w-full items-center justify-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-400 transition hover:border-emerald-500/30 hover:bg-emerald-500 hover:text-white disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            <x-heroicon-o-signal class="button-icon h-5 w-5"/>
                            <span class="button-label">
                                Test Connection
                            </span>
                        </button>
                    </form>

                    <form
                        id="delete-credential-form"
                        action="{{ route('admin.google-indexing.delete') }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            {{ !$googleSetting ? 'disabled' : '' }}
                            class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-bold text-red-400 transition hover:border-red-500/30 hover:bg-red-500 hover:text-white disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            <x-heroicon-o-trash class="h-5 w-5"/>
                            Delete
                        </button>
                    </form>
                </div>
            </section>

            {{-- Setup guide --}}
            <section class="p-5 sm:p-6">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-white">
                            Setup Checklist
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Langkah singkat sebelum submit URL.
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10">
                        <x-heroicon-o-light-bulb class="h-5 w-5 text-amber-400"/>
                    </div>
                </div>

                <div class="space-y-3">
                    @php
                        $steps = [
                            ['Verifikasi domain di Google Search Console.', 'globe-alt'],
                            ['Tambahkan Client Email pada menu pengguna dan izin.', 'user-plus'],
                            ['Berikan hak akses yang sesuai pada Service Account.', 'shield-check'],
                            ['Pastikan URL dapat diakses dan memberikan HTTP 200.', 'check-badge'],
                            ['Masukkan URL pada form submission di bawah.', 'paper-airplane'],
                        ];
                    @endphp

                    @foreach($steps as $index => $step)
                        <div class="group flex gap-3 rounded-2xl border border-slate-800 bg-slate-950/50 p-3.5 transition hover:border-amber-500/20 hover:bg-amber-500/5">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-xs font-black text-amber-400">
                                {{ $index + 1 }}
                            </div>

                            <p class="pt-1 text-xs leading-5 text-slate-400 transition group-hover:text-slate-300">
                                {{ $step[0] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 rounded-2xl border border-sky-500/15 bg-sky-500/5 p-4">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-information-circle class="mt-0.5 h-5 w-5 shrink-0 text-sky-400"/>

                        <p class="text-xs leading-5 text-sky-200/65">
                            Simpan file credential dengan aman dan jangan membagikannya kepada pihak lain.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- URL submission workspace --}}
    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
        <div class="flex flex-col gap-4 border-b border-slate-800 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 shadow-lg shadow-indigo-950/40">
                    <x-heroicon-o-paper-airplane class="h-5 w-5 text-white"/>
                </div>

                <div>
                    <h2 class="font-bold text-white">
                        Submit URL
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Kirim satu URL menggunakan koneksi Service Account aktif.
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-slate-800 bg-slate-950/60 px-3 py-2 text-xs text-slate-500">
                Status:
                <span class="ml-1 font-bold {{ $isConnected ? 'text-emerald-400' : 'text-red-400' }}">
                    {{ $isConnected ? 'Ready' : 'Not ready' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1.05fr_.95fr]">
            {{-- URL form --}}
            <section class="border-b border-slate-800 p-5 sm:p-6 xl:border-b-0 xl:border-r">
                <form
                    id="url-submit-form"
                    action="{{ route('admin.google-indexing.submit') }}"
                    method="POST"
                >
                    @csrf

                    <label
                        for="indexing-url"
                        class="mb-2 block text-sm font-bold text-slate-300"
                    >
                        URL Target
                    </label>

                    <div class="group relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <x-heroicon-o-link class="h-5 w-5 text-slate-600 transition group-focus-within:text-indigo-400"/>
                        </div>

                        <input
                            id="indexing-url"
                            type="url"
                            name="url"
                            value="{{ old('url', data_get($submitResult, 'url')) }}"
                            placeholder="https://domain.com/halaman"
                            autocomplete="url"
                            required
                            class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 py-4 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-indigo-500/70 focus:ring-4 focus:ring-indigo-500/10"
                        >
                    </div>

                    <div class="mt-3 flex flex-wrap items-center justify-between gap-2 text-[11px] text-slate-600">
                        <span>Gunakan URL lengkap dengan protokol https://</span>

                        <button
                            id="paste-url"
                            type="button"
                            class="font-semibold text-indigo-400 transition hover:text-indigo-300"
                        >
                            Paste dari clipboard
                        </button>
                    </div>

                    <button
                        type="submit"
                        data-loading-text="Submitting..."
                        {{ !$isConnected ? 'disabled' : '' }}
                        class="submit-with-loading mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:-translate-y-0.5 hover:from-indigo-500 hover:to-violet-500 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <x-heroicon-o-paper-airplane class="button-icon h-5 w-5"/>
                        <span class="button-label">
                            Submit URL
                        </span>
                    </button>
                </form>

                @if(!$isConnected)
                    <div class="mt-4 rounded-2xl border border-amber-500/20 bg-amber-500/5 p-4">
                        <div class="flex items-start gap-3">
                            <x-heroicon-o-exclamation-triangle class="mt-0.5 h-5 w-5 shrink-0 text-amber-400"/>

                            <p class="text-xs leading-5 text-amber-200/70">
                                Upload dan test Service Account terlebih dahulu sebelum mengirim URL.
                            </p>
                        </div>
                    </div>
                @endif
            </section>

            {{-- Result --}}
            <section class="min-h-[360px] bg-slate-950/35 p-5 sm:p-6">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-white">
                            Submission Result
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Respons terakhir dari proses submission.
                        </p>
                    </div>

                    @if($submitResult)
                        <button
                            type="button"
                            id="copy-submit-response"
                            class="flex h-9 items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 text-xs font-semibold text-slate-400 transition hover:border-indigo-500/40 hover:text-indigo-400"
                        >
                            <x-heroicon-o-clipboard class="h-4 w-4"/>
                            Copy
                        </button>
                    @endif
                </div>

                @if($submitResult)
                    @if(data_get($submitResult, 'status') === 'success')
                        <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10">
                                    <x-heroicon-o-check-circle class="h-6 w-6 text-emerald-400"/>
                                </div>

                                <div class="min-w-0">
                                    <h4 class="font-bold text-emerald-300">
                                        URL berhasil dikirim
                                    </h4>

                                    <p class="mt-1 text-xs text-emerald-200/60">
                                        Permintaan telah diterima oleh endpoint.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-xl border border-emerald-500/10 bg-slate-950/50 p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                        Type
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-200">
                                        {{ data_get($submitResult, 'type', '-') }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-emerald-500/10 bg-slate-950/50 p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                        Time
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-200">
                                        {{ data_get($submitResult, 'time', '-') }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3 rounded-xl border border-emerald-500/10 bg-slate-950/50 p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                    URL
                                </p>

                                <p class="mt-1 break-all text-sm leading-6 text-slate-200">
                                    {{ data_get($submitResult, 'url', '-') }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <p class="text-xs font-bold text-slate-400">
                                        API Response
                                    </p>

                                    <span class="rounded-md bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                                        JSON
                                    </span>
                                </div>

                                <pre
                                    id="submit-response-json"
                                    class="max-h-64 overflow-auto rounded-xl border border-slate-800 bg-[#020617] p-4 text-xs leading-6 text-emerald-400"
                                >{{ json_encode(data_get($submitResult, 'response'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl border border-red-500/20 bg-red-500/5 p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500/10">
                                    <x-heroicon-o-x-circle class="h-6 w-6 text-red-400"/>
                                </div>

                                <div>
                                    <h4 class="font-bold text-red-300">
                                        Submit gagal
                                    </h4>

                                    <p class="mt-1 text-xs text-red-200/60">
                                        Periksa kredensial, izin, dan URL target.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 space-y-3">
                                <div class="rounded-xl border border-red-500/10 bg-slate-950/50 p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                        URL
                                    </p>

                                    <p class="mt-1 break-all text-sm leading-6 text-slate-200">
                                        {{ data_get($submitResult, 'url', '-') }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-red-500/10 bg-slate-950/50 p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                        Error
                                    </p>

                                    <p
                                        id="submit-response-json"
                                        class="mt-1 break-words text-sm leading-6 text-red-300"
                                    >
                                        {{ data_get($submitResult, 'message', 'Unknown error') }}
                                    </p>
                                </div>

                                <div class="rounded-xl border border-red-500/10 bg-slate-950/50 p-3">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                        Time
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-slate-200">
                                        {{ data_get($submitResult, 'time', '-') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="flex min-h-[285px] flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-6 text-center">
                        <div class="relative mb-4">
                            <div class="absolute inset-0 rounded-full bg-indigo-500/20 blur-xl"></div>

                            <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl border border-indigo-500/20 bg-indigo-500/10">
                                <x-heroicon-o-paper-airplane class="h-6 w-6 text-indigo-400"/>
                            </div>
                        </div>

                        <h4 class="font-bold text-slate-300">
                            Belum ada submission
                        </h4>

                        <p class="mt-2 max-w-sm text-sm leading-6 text-slate-600">
                            Hasil pengiriman URL akan tampil di panel ini.
                        </p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    {{-- Security notice --}}
    <div class="mt-4 flex items-start gap-3 rounded-xl border border-amber-500/15 bg-amber-500/5 px-4 py-3">
        <x-heroicon-o-lock-closed class="mt-0.5 h-4 w-4 shrink-0 text-amber-400"/>

        <p class="text-xs leading-5 text-amber-200/70">
            File Service Account adalah kredensial sensitif. Pastikan halaman ini hanya bisa diakses administrator.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const credentialInput = document.getElementById('credential');
    const dropZone = document.getElementById('credential-drop-zone');
    const credentialPreview = document.getElementById('credential-preview');
    const credentialFileName = document.getElementById('credential-file-name');
    const credentialFileSize = document.getElementById('credential-file-size');
    const deleteForm = document.getElementById('delete-credential-form');
    const pasteUrlButton = document.getElementById('paste-url');
    const urlInput = document.getElementById('indexing-url');
    const copyResponseButton = document.getElementById('copy-submit-response');
    const responseElement = document.getElementById('submit-response-json');

    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    function showCredentialFile(file) {
        if (!file) {
            return;
        }

        const isJson =
            file.type === 'application/json' ||
            file.name.toLowerCase().endsWith('.json');

        if (!isJson) {
            credentialInput.value = '';
            alert('File credential harus berformat JSON.');
            return;
        }

        credentialFileName.textContent = file.name;
        credentialFileSize.textContent = formatFileSize(file.size);

        credentialPreview.classList.remove('hidden');
        credentialPreview.classList.add('flex');
    }

    credentialInput?.addEventListener('change', () => {
        showCredentialFile(credentialInput.files?.[0]);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone?.addEventListener(eventName, event => {
            event.preventDefault();

            dropZone.classList.add(
                'border-sky-500',
                'bg-sky-500/10'
            );
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone?.addEventListener(eventName, event => {
            event.preventDefault();

            dropZone.classList.remove(
                'border-sky-500',
                'bg-sky-500/10'
            );
        });
    });

    dropZone?.addEventListener('drop', event => {
        const file = event.dataTransfer.files?.[0];

        if (!file) {
            return;
        }

        const transfer = new DataTransfer();
        transfer.items.add(file);
        credentialInput.files = transfer.files;

        showCredentialFile(file);
    });

    document
        .querySelectorAll('.submit-with-loading')
        .forEach(button => {
            button.closest('form')?.addEventListener('submit', () => {
                if (button.disabled) {
                    return;
                }

                const label = button.querySelector('.button-label');
                const icon = button.querySelector('.button-icon');

                button.disabled = true;

                if (label) {
                    label.textContent =
                        button.dataset.loadingText || 'Processing...';
                }

                if (icon) {
                    icon.classList.add('animate-spin');
                }
            });
        });

    deleteForm?.addEventListener('submit', event => {
        const confirmed = window.confirm(
            'Hapus Service Account dari sistem?'
        );

        if (!confirmed) {
            event.preventDefault();
        }
    });

    pasteUrlButton?.addEventListener('click', async () => {
        try {
            const clipboardText =
                await navigator.clipboard.readText();

            if (clipboardText) {
                urlInput.value = clipboardText.trim();
                urlInput.focus();
            }
        } catch {
            alert('Browser tidak mengizinkan membaca clipboard.');
        }
    });

    document
        .querySelectorAll('.copy-value')
        .forEach(button => {
            button.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(
                        button.dataset.copy || ''
                    );

                    const originalTitle = button.title;
                    button.title = 'Copied';

                    setTimeout(() => {
                        button.title = originalTitle;
                    }, 1200);
                } catch {
                    alert('Data tidak dapat disalin.');
                }
            });
        });

    copyResponseButton?.addEventListener('click', async () => {
        const text = responseElement?.textContent?.trim();

        if (!text) {
            return;
        }

        try {
            await navigator.clipboard.writeText(text);

            const oldHtml = copyResponseButton.innerHTML;

            copyResponseButton.innerHTML =
                '<span class="text-emerald-400">Copied</span>';

            setTimeout(() => {
                copyResponseButton.innerHTML = oldHtml;
            }, 1400);
        } catch {
            alert('Response tidak dapat disalin.');
        }
    });
});
</script>
@endpush