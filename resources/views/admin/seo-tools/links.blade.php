@extends('layouts.admin')

@section('title', 'Links')
@section('page-title', 'Links')

@section('content')
<div
    id="links-app"
    class="mx-auto w-full max-w-[1500px]"
    data-list-url="{{ route('admin.seo-tools.links.list') }}"
    data-options-url="{{ route('admin.seo-tools.shortlinks.options') }}"
    data-store-url="{{ route('admin.seo-tools.links.store') }}"
    data-detail-url="{{ route('admin.seo-tools.links.detail', ['id' => '__ID__']) }}"
    data-update-url="{{ route('admin.seo-tools.links.update', ['id' => '__ID__']) }}"
    data-delete-url="{{ route('admin.seo-tools.links.delete', ['id' => '__ID__']) }}"
    data-shortlink-domain="https://go.nawala.link"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-400 via-sky-500 to-blue-600 shadow-lg shadow-sky-950/40">
                    <x-heroicon-o-globe-alt class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Links Manager
                    </h1>

                    <p class="text-sm text-slate-500">
                        Shortlink Destination Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-2xl text-sm leading-6 text-slate-400">
                Kelola URL tujuan, priority, status, dan shortlink yang terhubung dari satu dashboard.
            </p>
        </div>

        <button
            id="btnCreate"
            type="button"
            class="group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-950/40 transition hover:-translate-y-0.5 hover:from-cyan-500 hover:to-blue-500"
        >
            <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

            <x-heroicon-o-plus class="relative h-5 w-5"/>

            <span class="relative">
                Tambah Link
            </span>
        </button>
    </div>

    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-cyan-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-cyan-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                        Total Links
                    </p>

                    <p
                        id="totalLinks"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Hasil yang sedang ditampilkan
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                    <x-heroicon-o-link class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-emerald-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-emerald-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                        Aktif
                    </p>

                    <p
                        id="activeLinks"
                        class="mt-3 text-3xl font-black tracking-tight text-emerald-400"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Siap digunakan
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 transition group-hover:bg-emerald-500 group-hover:text-white">
                    <x-heroicon-o-check-circle class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-red-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-red-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                        Nonaktif
                    </p>

                    <p
                        id="inactiveLinks"
                        class="mt-3 text-3xl font-black tracking-tight text-red-400"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Sedang dimatikan
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500/10 text-red-400 transition group-hover:bg-red-500 group-hover:text-white">
                    <x-heroicon-o-pause-circle class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-violet-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-violet-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                        Avg. Priority
                    </p>

                    <p
                        id="averagePriority"
                        class="mt-3 text-3xl font-black tracking-tight text-violet-400"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Rata-rata urutan redirect
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400 transition group-hover:bg-violet-500 group-hover:text-white">
                    <x-heroicon-o-chart-bar class="h-5 w-5"/>
                </div>
            </div>
        </article>
    </div>

    {{-- Main table workspace --}}
    <div class="relative mt-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-72 w-72 rounded-full bg-cyan-600/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-32 h-72 w-72 rounded-full bg-blue-600/10 blur-3xl"></div>
        </div>

        {{-- Window bar --}}
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
                        Destination Links
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Cari, filter, buka, edit, atau hapus URL tujuan.
                    </p>
                </div>
            </div>

            {{-- Filters --}}
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 transition group-focus-within:text-cyan-400"/>
                    </div>

                    <input
                        id="search"
                        type="search"
                        placeholder="Cari URL, domain..."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10 sm:w-64"
                    >
                </div>

                <select
                    id="status"
                    class="rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-300 outline-none transition focus:border-cyan-500"
                >
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>

                <button
                    id="btnRefresh"
                    type="button"
                    class="flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-3 text-sm font-semibold text-slate-400 transition hover:border-cyan-500/30 hover:bg-cyan-500/10 hover:text-cyan-400 disabled:opacity-50"
                    title="Refresh data"
                >
                    <x-heroicon-o-arrow-path id="refreshIcon" class="h-4 w-4"/>
                    <span class="sm:hidden">Refresh</span>
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="relative overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950/55">
                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Destination URL
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Shortlink
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Domain
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Priority
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Status
                        </th>

                        <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="tableBody"
                    class="divide-y divide-slate-800"
                >
                    <tr>
                        <td colspan="6" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <svg class="h-7 w-7 animate-spin text-cyan-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>

                                <p class="mt-3 text-sm font-semibold text-slate-400">
                                    Memuat data links...
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="relative flex flex-col gap-2 border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-xs text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span id="resultInfo">
                Menampilkan 0 data
            </span>

            <span>
                Filter diproses melalui endpoint API
            </span>
        </div>
    </div>
</div>

{{-- Create/edit modal --}}
<div
    id="linkModal"
    class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-slate-950/80 p-4 backdrop-blur-md"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modalTitle"
>
    <div
        id="modalPanel"
        class="relative my-auto w-full max-w-2xl translate-y-4 overflow-hidden rounded-3xl border border-slate-700 bg-slate-900 opacity-0 shadow-2xl shadow-black/60 transition duration-200"
    >
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-28 -top-28 h-64 w-64 rounded-full bg-cyan-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>
        </div>

        {{-- Modal header --}}
        <div class="relative flex items-center justify-between border-b border-slate-800 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 shadow-lg shadow-blue-950/40">
                    <x-heroicon-o-link class="h-5 w-5 text-white"/>
                </div>

                <div>
                    <h2
                        id="modalTitle"
                        class="font-bold text-white"
                    >
                        Tambah Link
                    </h2>

                    <p
                        id="modalSubtitle"
                        class="mt-1 text-xs text-slate-500"
                    >
                        Hubungkan URL tujuan dengan shortlink.
                    </p>
                </div>
            </div>

            <button
                id="closeModalButton"
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-red-500/10 hover:text-red-400"
                aria-label="Tutup modal"
            >
                <x-heroicon-o-x-mark class="h-6 w-6"/>
            </button>
        </div>

        {{-- Modal body --}}
        <div class="relative space-y-5 p-6">
            <input type="hidden" id="link_id">

            {{-- Shortlink --}}
            <div>
                <label
                    for="shortlink_id"
                    class="mb-2 block text-sm font-bold text-slate-300"
                >
                    Shortlink
                </label>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-heroicon-o-link class="h-5 w-5 text-slate-600 transition group-focus-within:text-cyan-400"/>
                    </div>

                    <select
                        id="shortlink_id"
                        class="w-full appearance-none rounded-2xl border border-slate-700 bg-slate-950/70 py-3.5 pl-12 pr-10 text-sm text-white outline-none transition focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                    >
                        <option value="">Memuat shortlink...</option>
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                        <x-heroicon-o-chevron-down class="h-4 w-4 text-slate-600"/>
                    </div>
                </div>

                <p
                    id="shortlinkError"
                    class="mt-2 hidden text-xs font-medium text-red-400"
                ></p>
            </div>

            {{-- URL --}}
            <div>
                <label
                    for="url"
                    class="mb-2 block text-sm font-bold text-slate-300"
                >
                    Destination URL
                </label>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-heroicon-o-globe-alt class="h-5 w-5 text-slate-600 transition group-focus-within:text-cyan-400"/>
                    </div>

                    <input
                        id="url"
                        type="url"
                        autocomplete="url"
                        placeholder="https://example.com/landing-page"
                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10"
                    >
                </div>

                <div class="mt-2 flex items-center justify-between gap-3">
                    <p class="text-xs text-slate-600">
                        Gunakan URL lengkap dengan http:// atau https://
                    </p>

                    <button
                        id="pasteUrl"
                        type="button"
                        class="shrink-0 text-xs font-semibold text-cyan-400 transition hover:text-cyan-300"
                    >
                        Paste URL
                    </button>
                </div>

                <p
                    id="urlError"
                    class="mt-2 hidden text-xs font-medium text-red-400"
                ></p>
            </div>

            {{-- Domain --}}
            <div>
                <label
                    for="domain"
                    class="mb-2 block text-sm font-bold text-slate-300"
                >
                    Domain Terdeteksi
                </label>

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-heroicon-o-server-stack class="h-5 w-5 text-slate-600"/>
                    </div>

                    <input
                        id="domain"
                        type="text"
                        readonly
                        placeholder="Domain akan terisi otomatis"
                        class="w-full cursor-not-allowed rounded-2xl border border-slate-800 bg-slate-950/40 py-3.5 pl-12 pr-4 text-sm text-slate-400 outline-none placeholder:text-slate-700"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                {{-- Priority --}}
                <div>
                    <label
                        for="priority"
                        class="mb-2 block text-sm font-bold text-slate-300"
                    >
                        Priority
                    </label>

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <x-heroicon-o-chart-bar class="h-5 w-5 text-slate-600"/>
                        </div>

                        <input
                            id="priority"
                            type="number"
                            min="1"
                            step="1"
                            value="1"
                            class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition focus:border-violet-500/70 focus:ring-4 focus:ring-violet-500/10"
                        >
                    </div>

                    <p
                        id="priorityError"
                        class="mt-2 hidden text-xs font-medium text-red-400"
                    ></p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-300">
                        Status
                    </label>

                    <label class="flex min-h-[52px] cursor-pointer items-center justify-between rounded-2xl border border-slate-800 bg-slate-950/50 px-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10">
                                <x-heroicon-o-signal class="h-5 w-5 text-emerald-400"/>
                            </div>

                            <div>
                                <p
                                    id="statusLabel"
                                    class="text-sm font-bold text-slate-300"
                                >
                                    Aktif
                                </p>

                                <p class="mt-0.5 text-[11px] text-slate-600">
                                    Redirect dapat digunakan
                                </p>
                            </div>
                        </div>

                        <div class="relative">
                            <input
                                id="modal_status"
                                type="checkbox"
                                checked
                                class="peer sr-only"
                            >

                            <div class="h-6 w-11 rounded-full bg-slate-700 transition peer-checked:bg-emerald-500"></div>

                            <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Preview --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-4">
                <div class="mb-3 flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-slate-600">
                        Redirect Preview
                    </p>

                    <span class="rounded-md bg-cyan-500/10 px-2 py-1 text-[10px] font-bold text-cyan-400">
                        Live
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400">
                        <x-heroicon-o-arrow-top-right-on-square class="h-4 w-4"/>
                    </div>

                    <div class="min-w-0">
                        <p
                            id="previewShortlink"
                            class="truncate font-mono text-xs text-cyan-300"
                        >
                            Pilih shortlink
                        </p>

                        <p
                            id="previewDestination"
                            class="mt-1 truncate text-xs text-slate-600"
                        >
                            Masukkan destination URL
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal footer --}}
        <div class="relative flex flex-col-reverse gap-3 border-t border-slate-800 bg-slate-950/30 px-6 py-5 sm:flex-row sm:justify-end">
            <button
                id="btnClose"
                type="button"
                class="rounded-xl border border-slate-700 bg-slate-800/70 px-5 py-3 text-sm font-bold text-slate-300 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white"
            >
                Batal
            </button>

            <button
                id="btnSave"
                type="button"
                class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-950/30 transition hover:-translate-y-0.5 hover:from-cyan-500 hover:to-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <svg
                    id="saveSpinner"
                    class="hidden h-5 w-5 animate-spin"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <x-heroicon-o-check id="saveIcon" class="h-5 w-5"/>

                <span id="saveText">
                    Simpan Link
                </span>
            </button>
        </div>
    </div>
</div>

{{-- Delete confirmation --}}
<div
    id="deleteModal"
    class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/85 p-4 backdrop-blur-md"
>
    <div class="w-full max-w-md overflow-hidden rounded-3xl border border-red-500/20 bg-slate-900 shadow-2xl shadow-black/60">
        <div class="p-6 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-500/10">
                <x-heroicon-o-trash class="h-8 w-8 text-red-400"/>
            </div>

            <h3 class="mt-5 text-lg font-black text-white">
                Hapus Link?
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                URL
                <span
                    id="deleteTargetName"
                    class="break-all font-semibold text-slate-300"
                ></span>
                akan dihapus permanen.
            </p>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <button
                    id="cancelDelete"
                    type="button"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm font-bold text-slate-300 transition hover:bg-slate-700"
                >
                    Batal
                </button>

                <button
                    id="confirmDelete"
                    type="button"
                    class="flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-red-500 disabled:opacity-50"
                >
                    <svg
                        id="deleteSpinner"
                        class="hidden h-5 w-5 animate-spin"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Opening overlay --}}
<div
    id="loadingOverlay"
    class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/90 p-4 backdrop-blur-md"
>
    <div class="relative w-full max-w-md overflow-hidden rounded-3xl border border-cyan-500/20 bg-slate-900 p-8 text-center shadow-2xl shadow-black/60">
        <div class="pointer-events-none absolute -left-20 -top-20 h-52 w-52 rounded-full bg-cyan-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-52 w-52 rounded-full bg-blue-500/15 blur-3xl"></div>

        <div class="relative">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 shadow-lg shadow-blue-950/50">
                <x-heroicon-o-arrow-top-right-on-square class="h-7 w-7 text-white"/>
            </div>

            <div class="mt-6 flex justify-center gap-2">
                <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-cyan-400"></span>
                <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-cyan-400 [animation-delay:150ms]"></span>
                <span class="h-2.5 w-2.5 animate-bounce rounded-full bg-cyan-400 [animation-delay:300ms]"></span>
            </div>

            <h2 class="mt-6 text-xl font-black text-white">
                Membuka Shortlink
            </h2>

            <p
                id="openingUrl"
                class="mt-2 break-all text-sm leading-6 text-slate-500"
            >
                Mohon tunggu sebentar...
            </p>
        </div>
    </div>
</div>

{{-- Toast container --}}
<div
    id="toastContainer"
    class="pointer-events-none fixed right-5 top-5 z-[80] flex w-[calc(100%-2.5rem)] max-w-sm flex-col gap-3"
></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('links-app');

    if (!app) {
        return;
    }

    const routes = {
        list: app.dataset.listUrl,
        options: app.dataset.optionsUrl,
        store: app.dataset.storeUrl,
        detail: app.dataset.detailUrl,
        update: app.dataset.updateUrl,
        delete: app.dataset.deleteUrl,
    };

    const shortlinkDomain =
        (app.dataset.shortlinkDomain || '').replace(/\/+$/, '');

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    const tableBody = document.getElementById('tableBody');
    const resultInfo = document.getElementById('resultInfo');

    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('status');
    const refreshButton = document.getElementById('btnRefresh');
    const refreshIcon = document.getElementById('refreshIcon');

    const totalLinks = document.getElementById('totalLinks');
    const activeLinks = document.getElementById('activeLinks');
    const inactiveLinks = document.getElementById('inactiveLinks');
    const averagePriority = document.getElementById('averagePriority');

    const modal = document.getElementById('linkModal');
    const modalPanel = document.getElementById('modalPanel');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');

    const idInput = document.getElementById('link_id');
    const shortlinkInput = document.getElementById('shortlink_id');
    const urlInput = document.getElementById('url');
    const domainInput = document.getElementById('domain');
    const priorityInput = document.getElementById('priority');
    const statusInput = document.getElementById('modal_status');

    const shortlinkError = document.getElementById('shortlinkError');
    const urlError = document.getElementById('urlError');
    const priorityError = document.getElementById('priorityError');

    const previewShortlink = document.getElementById('previewShortlink');
    const previewDestination = document.getElementById('previewDestination');
    const statusLabel = document.getElementById('statusLabel');

    const createButton = document.getElementById('btnCreate');
    const closeModalButton = document.getElementById('closeModalButton');
    const cancelButton = document.getElementById('btnClose');
    const saveButton = document.getElementById('btnSave');
    const saveText = document.getElementById('saveText');
    const saveIcon = document.getElementById('saveIcon');
    const saveSpinner = document.getElementById('saveSpinner');
    const pasteUrlButton = document.getElementById('pasteUrl');

    const deleteModal = document.getElementById('deleteModal');
    const deleteTargetName = document.getElementById('deleteTargetName');
    const cancelDeleteButton = document.getElementById('cancelDelete');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    const deleteSpinner = document.getElementById('deleteSpinner');

    const loadingOverlay = document.getElementById('loadingOverlay');
    const openingUrl = document.getElementById('openingUrl');
    const toastContainer = document.getElementById('toastContainer');

    let links = [];
    let shortlinks = [];
    let deleteTarget = null;
    let loadingLinks = false;
    let searchTimer = null;

    function routeWithId(template, id) {
        return template.replace('__ID__', encodeURIComponent(id));
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function showToast(message, type = 'success') {
        const styles = {
            success: {
                border: 'border-emerald-500/20',
                background: 'bg-emerald-500/10',
                text: 'text-emerald-300',
                icon: '✓',
            },
            error: {
                border: 'border-red-500/20',
                background: 'bg-red-500/10',
                text: 'text-red-300',
                icon: '!',
            },
            info: {
                border: 'border-cyan-500/20',
                background: 'bg-cyan-500/10',
                text: 'text-cyan-300',
                icon: 'i',
            },
        };

        const style = styles[type] ?? styles.info;
        const toast = document.createElement('div');

        toast.className = `
            pointer-events-auto flex translate-x-4 items-start gap-3
            rounded-2xl border p-4 opacity-0 shadow-2xl shadow-black/30
            backdrop-blur transition duration-200
            ${style.border} ${style.background}
        `;

        toast.innerHTML = `
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-black/15 font-black ${style.text}">
                ${style.icon}
            </div>

            <p class="flex-1 pt-1 text-sm font-semibold leading-5 ${style.text}">
                ${escapeHtml(message)}
            </p>

            <button type="button" class="toast-close text-slate-500 transition hover:text-white">
                ×
            </button>
        `;

        toastContainer.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-4', 'opacity-0');
        });

        const removeToast = () => {
            toast.classList.add('translate-x-4', 'opacity-0');

            setTimeout(() => {
                toast.remove();
            }, 200);
        };

        toast.querySelector('.toast-close')
            ?.addEventListener('click', removeToast);

        setTimeout(removeToast, 3500);
    }

    function getRowsFromResponse(json) {
        if (Array.isArray(json)) {
            return json;
        }

        if (Array.isArray(json?.data)) {
            return json.data;
        }

        if (Array.isArray(json?.data?.data)) {
            return json.data.data;
        }

        return [];
    }

    function setLoadingState(loading) {
        loadingLinks = loading;
        refreshButton.disabled = loading;
        refreshIcon.classList.toggle('animate-spin', loading);
    }

    function setStats(rows) {
        const total = rows.length;
        const active = rows.filter(
            item => item.status === 'active'
        ).length;
        const inactive = total - active;

        const priorityTotal = rows.reduce(
            (sum, item) => sum + Number(item.priority || 0),
            0
        );

        const average = total > 0
            ? (priorityTotal / total).toFixed(1)
            : '0';

        totalLinks.textContent = total.toLocaleString('id-ID');
        activeLinks.textContent = active.toLocaleString('id-ID');
        inactiveLinks.textContent = inactive.toLocaleString('id-ID');
        averagePriority.textContent = average;
    }

    function renderLoading() {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-16">
                    <div class="flex flex-col items-center justify-center text-center">
                        <svg class="h-7 w-7 animate-spin text-cyan-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>

                        <p class="mt-3 text-sm font-semibold text-slate-400">
                            Memuat data links...
                        </p>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderEmpty(
        title = 'Belum ada link',
        description = 'Klik Tambah Link untuk membuat URL tujuan pertama.'
    ) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-16">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800 text-2xl">
                            🌐
                        </div>

                        <h3 class="mt-4 font-bold text-slate-300">
                            ${escapeHtml(title)}
                        </h3>

                        <p class="mt-2 max-w-sm text-sm leading-6 text-slate-600">
                            ${escapeHtml(description)}
                        </p>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderTable() {
        resultInfo.textContent =
            `Menampilkan ${links.length.toLocaleString('id-ID')} data`;

        if (links.length === 0) {
            renderEmpty(
                searchInput.value || statusFilter.value
                    ? 'Data tidak ditemukan'
                    : 'Belum ada link',
                searchInput.value || statusFilter.value
                    ? 'Coba ubah kata pencarian atau filter status.'
                    : 'Klik Tambah Link untuk membuat URL tujuan pertama.'
            );

            return;
        }

        tableBody.innerHTML = links.map(item => {
            const id = escapeHtml(item.id);
            const destinationUrl = escapeHtml(item.url || '-');
            const domain = escapeHtml(item.domain || '-');
            const priority = escapeHtml(item.priority ?? 1);
            const status = item.status === 'active'
                ? 'active'
                : 'inactive';

            const shortlinkName = escapeHtml(
                item.shortlink?.name ||
                item.shortlink_name ||
                'Shortlink'
            );

            const shortlinkSlug = escapeHtml(
                item.shortlink?.slug ||
                item.shortlink_slug ||
                '-'
            );

            const shortlinkUrl =
                shortlinkSlug !== '-'
                    ? `${shortlinkDomain}/${shortlinkSlug}`
                    : '';

            const statusBadge = status === 'active'
                ? `
                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-bold text-emerald-400">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        </span>
                        Aktif
                    </span>
                `
                : `
                    <span class="inline-flex items-center gap-2 rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                        Nonaktif
                    </span>
                `;

            return `
                <tr class="group transition hover:bg-slate-800/35">
                    <td class="min-w-[300px] px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500/15 to-blue-500/10 text-cyan-400 transition group-hover:from-cyan-500 group-hover:to-blue-600 group-hover:text-white">
                                ↗
                            </div>

                            <div class="min-w-0">
                                <a
                                    href="${destinationUrl}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="block max-w-md truncate font-semibold text-slate-200 transition hover:text-cyan-400"
                                    title="${destinationUrl}"
                                >
                                    ${destinationUrl}
                                </a>

                                <button
                                    type="button"
                                    class="copy-value mt-1 text-xs text-slate-600 transition hover:text-cyan-400"
                                    data-copy="${destinationUrl}"
                                >
                                    Copy destination
                                </button>
                            </div>
                        </div>
                    </td>

                    <td class="min-w-[230px] px-5 py-4">
                        ${
                            shortlinkUrl
                                ? `
                                    <button
                                        type="button"
                                        class="open-shortlink group/short inline-flex max-w-[260px] items-center gap-2 rounded-xl border border-indigo-500/20 bg-indigo-500/10 px-3 py-2 text-left transition hover:bg-indigo-500 hover:text-white"
                                        data-url="${escapeHtml(shortlinkUrl)}"
                                    >
                                        <span class="min-w-0">
                                            <span class="block truncate text-xs font-bold text-indigo-300 group-hover/short:text-white">
                                                ${shortlinkName}
                                            </span>

                                            <span class="mt-0.5 block truncate font-mono text-[10px] text-indigo-400/60 group-hover/short:text-indigo-100">
                                                ${escapeHtml(shortlinkUrl.replace(/^https?:\/\//, ''))}
                                            </span>
                                        </span>

                                        <span class="shrink-0">↗</span>
                                    </button>
                                `
                                : `
                                    <span class="text-xs text-slate-600">
                                        Tidak tersedia
                                    </span>
                                `
                        }
                    </td>

                    <td class="px-5 py-4">
                        <span class="inline-flex items-center rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 font-mono text-xs text-slate-400">
                            ${domain}
                        </span>
                    </td>

                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-xl border border-violet-500/20 bg-violet-500/10 px-2 text-sm font-black text-violet-400">
                            ${priority}
                        </span>
                    </td>

                    <td class="whitespace-nowrap px-5 py-4">
                        ${statusBadge}
                    </td>

                    <td class="whitespace-nowrap px-5 py-4">
                        <div class="flex justify-end gap-2">
                            <a
                                href="${destinationUrl}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                                title="Buka destination"
                            >
                                ↗
                            </a>

                            <button
                                type="button"
                                class="edit-link flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500/20 bg-amber-500/10 text-amber-400 transition hover:bg-amber-500 hover:text-slate-950"
                                data-id="${id}"
                                title="Edit"
                            >
                                ✎
                            </button>

                            <button
                                type="button"
                                class="delete-link flex h-9 w-9 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 transition hover:bg-red-500 hover:text-white"
                                data-id="${id}"
                                data-url="${destinationUrl}"
                                title="Hapus"
                            >
                                ×
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        bindTableActions();
    }

    function bindTableActions() {
        tableBody.querySelectorAll('.edit-link')
            .forEach(button => {
                button.addEventListener('click', () => {
                    editLink(button.dataset.id);
                });
            });

        tableBody.querySelectorAll('.delete-link')
            .forEach(button => {
                button.addEventListener('click', () => {
                    openDeleteModal({
                        id: button.dataset.id,
                        url: button.dataset.url,
                    });
                });
            });

        tableBody.querySelectorAll('.open-shortlink')
            .forEach(button => {
                button.addEventListener('click', () => {
                    openShortlink(button.dataset.url);
                });
            });

        tableBody.querySelectorAll('.copy-value')
            .forEach(button => {
                button.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(
                            button.dataset.copy || ''
                        );

                        showToast(
                            'Destination URL berhasil disalin.',
                            'success'
                        );
                    } catch {
                        showToast(
                            'URL tidak dapat disalin.',
                            'error'
                        );
                    }
                });
            });
    }

    async function loadLinks(showLoader = true) {
        if (loadingLinks) {
            return;
        }

        setLoadingState(true);

        if (showLoader) {
            renderLoading();
        }

        try {
            const listUrl = new URL(
                routes.list,
                window.location.origin
            );

            const search = searchInput.value.trim();
            const status = statusFilter.value;

            if (search) {
                listUrl.searchParams.set('search', search);
            }

            if (status) {
                listUrl.searchParams.set('status', status);
            }

            const response = await fetch(listUrl.toString(), {
                headers: {
                    Accept: 'application/json',
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Gagal memuat data links.'
                );
            }

            links = getRowsFromResponse(result);

            setStats(links);
            renderTable();
        } catch (error) {
            links = [];
            setStats(links);

            renderEmpty(
                'Gagal memuat data',
                error.message || 'Terjadi kesalahan saat menghubungi server.'
            );

            resultInfo.textContent = 'Data gagal dimuat';
            showToast(error.message, 'error');
        } finally {
            setLoadingState(false);
        }
    }

    async function loadShortlinks() {
        try {
            const response = await fetch(routes.options, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Gagal memuat pilihan shortlink.'
                );
            }

            shortlinks = getRowsFromResponse(result);

            shortlinkInput.innerHTML =
                '<option value="">Pilih Shortlink...</option>';

            shortlinks.forEach(item => {
                const option = document.createElement('option');

                option.value = item.id;
                option.textContent = item.slug
                    ? `${item.name} — /${item.slug}`
                    : item.name;

                option.dataset.slug = item.slug || '';

                shortlinkInput.appendChild(option);
            });
        } catch (error) {
            shortlinks = [];

            shortlinkInput.innerHTML =
                '<option value="">Gagal memuat shortlink</option>';

            showToast(error.message, 'error');
        }
    }

    function clearValidation() {
        [
            shortlinkInput,
            urlInput,
            priorityInput,
        ].forEach(input => {
            input.classList.remove(
                'border-red-500',
                'focus:border-red-500'
            );
        });

        [
            shortlinkError,
            urlError,
            priorityError,
        ].forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
    }

    function showFieldError(field, message) {
        const fields = {
            shortlink_id: {
                input: shortlinkInput,
                error: shortlinkError,
            },
            url: {
                input: urlInput,
                error: urlError,
            },
            priority: {
                input: priorityInput,
                error: priorityError,
            },
        };

        const target = fields[field];

        if (!target) {
            return;
        }

        target.input.classList.add(
            'border-red-500',
            'focus:border-red-500'
        );

        target.error.textContent = message;
        target.error.classList.remove('hidden');
    }

    function normalizeUrl(value) {
        const trimmed = value.trim();

        if (!trimmed) {
            return '';
        }

        if (/^https?:\/\//i.test(trimmed)) {
            return trimmed;
        }

        return `https://${trimmed}`;
    }

    function updateDomain() {
        const value = normalizeUrl(urlInput.value);

        try {
            const parsedUrl = new URL(value);
            domainInput.value = parsedUrl.hostname;
        } catch {
            domainInput.value = '';
        }

        updatePreview();
    }

    function updatePreview() {
        const selectedOption =
            shortlinkInput.options[shortlinkInput.selectedIndex];

        const slug = selectedOption?.dataset?.slug || '';

        previewShortlink.textContent = slug
            ? `${shortlinkDomain}/${slug}`
            : 'Pilih shortlink';

        previewDestination.textContent =
            urlInput.value.trim() || 'Masukkan destination URL';

        statusLabel.textContent = statusInput.checked
            ? 'Aktif'
            : 'Nonaktif';
    }

    function resetForm() {
        idInput.value = '';
        shortlinkInput.value = '';
        urlInput.value = '';
        domainInput.value = '';
        priorityInput.value = 1;
        statusInput.checked = true;

        modalTitle.textContent = 'Tambah Link';
        modalSubtitle.textContent =
            'Hubungkan URL tujuan dengan shortlink.';
        saveText.textContent = 'Simpan Link';

        clearValidation();
        updatePreview();
    }

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            modalPanel.classList.remove(
                'translate-y-4',
                'opacity-0'
            );

            shortlinkInput.focus();
        });
    }

    function closeModal() {
        modalPanel.classList.add(
            'translate-y-4',
            'opacity-0'
        );

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 180);
    }

    function setSaveLoading(loading) {
        saveButton.disabled = loading;
        saveSpinner.classList.toggle('hidden', !loading);
        saveIcon.classList.toggle('hidden', loading);

        saveText.textContent = loading
            ? 'Menyimpan...'
            : idInput.value
                ? 'Update Link'
                : 'Simpan Link';
    }

    async function saveLink() {
        clearValidation();

        const id = idInput.value;
        const normalizedUrl = normalizeUrl(urlInput.value);

        const payload = {
            shortlink_id: shortlinkInput.value,
            url: normalizedUrl,
            domain: domainInput.value,
            priority: Number(priorityInput.value),
            status: statusInput.checked
                ? 'active'
                : 'inactive',
        };

        let valid = true;

        if (!payload.shortlink_id) {
            showFieldError(
                'shortlink_id',
                'Shortlink wajib dipilih.'
            );
            valid = false;
        }

        try {
            const parsedUrl = new URL(payload.url);

            if (!['http:', 'https:'].includes(parsedUrl.protocol)) {
                throw new Error();
            }
        } catch {
            showFieldError(
                'url',
                'Masukkan URL yang valid.'
            );
            valid = false;
        }

        if (
            !Number.isInteger(payload.priority) ||
            payload.priority < 1
        ) {
            showFieldError(
                'priority',
                'Priority minimal bernilai 1.'
            );
            valid = false;
        }

        if (!valid) {
            return;
        }

        urlInput.value = payload.url;
        updateDomain();
        payload.domain = domainInput.value;

        setSaveLoading(true);

        try {
            const response = await fetch(
                id
                    ? routeWithId(routes.update, id)
                    : routes.store,
                {
                    method: id ? 'PUT' : 'POST',

                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },

                    body: JSON.stringify(payload),
                }
            );

            const result = await response.json();

            if (!response.ok) {
                if (result.errors) {
                    Object.entries(result.errors)
                        .forEach(([field, messages]) => {
                            showFieldError(
                                field,
                                Array.isArray(messages)
                                    ? messages[0]
                                    : messages
                            );
                        });
                }

                throw new Error(
                    result.message || 'Gagal menyimpan link.'
                );
            }

            closeModal();
            await loadLinks(false);

            showToast(
                id
                    ? 'Link berhasil diperbarui.'
                    : 'Link berhasil dibuat.',
                'success'
            );
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            setSaveLoading(false);
        }
    }

    async function editLink(id) {
        resetForm();

        modalTitle.textContent = 'Edit Link';
        modalSubtitle.textContent =
            'Perbarui destination, priority, atau status.';
        saveText.textContent = 'Memuat...';
        saveButton.disabled = true;

        openModal();

        try {
            const response = await fetch(
                routeWithId(routes.detail, id),
                {
                    headers: {
                        Accept: 'application/json',
                    },
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Gagal mengambil detail link.'
                );
            }

            const data = result.data ?? result;

            idInput.value = data.id ?? id;
            shortlinkInput.value =
                data.shortlink_id ||
                data.shortlink?.id ||
                '';
            urlInput.value = data.url ?? '';
            domainInput.value = data.domain ?? '';
            priorityInput.value = data.priority ?? 1;
            statusInput.checked =
                (data.status ?? 'active') === 'active';

            updateDomain();
            updatePreview();

            saveText.textContent = 'Update Link';
        } catch (error) {
            closeModal();
            showToast(error.message, 'error');
        } finally {
            saveButton.disabled = false;
        }
    }

    function openDeleteModal(target) {
        deleteTarget = target;
        deleteTargetName.textContent = `"${target.url}"`;

        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        deleteTarget = null;

        deleteModal.classList.remove('flex');
        deleteModal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }

    async function deleteLink() {
        if (!deleteTarget) {
            return;
        }

        confirmDeleteButton.disabled = true;
        deleteSpinner.classList.remove('hidden');

        try {
            const response = await fetch(
                routeWithId(routes.delete, deleteTarget.id),
                {
                    method: 'DELETE',

                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                }
            );

            const result = await response.json();

            if (!response.ok || result.success === false) {
                throw new Error(
                    result.message || 'Gagal menghapus link.'
                );
            }

            closeDeleteModal();
            await loadLinks(false);

            showToast(
                'Link berhasil dihapus.',
                'success'
            );
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            confirmDeleteButton.disabled = false;
            deleteSpinner.classList.add('hidden');
        }
    }

    function openShortlink(url) {
        if (!url) {
            return;
        }

        openingUrl.textContent = url;
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        setTimeout(() => {
            window.open(
                url,
                '_blank',
                'noopener,noreferrer'
            );

            loadingOverlay.classList.remove('flex');
            loadingOverlay.classList.add('hidden');
        }, 650);
    }

    createButton.addEventListener('click', () => {
        resetForm();
        openModal();
    });

    closeModalButton.addEventListener(
        'click',
        closeModal
    );

    cancelButton.addEventListener(
        'click',
        closeModal
    );

    saveButton.addEventListener(
        'click',
        saveLink
    );

    urlInput.addEventListener(
        'input',
        updateDomain
    );

    shortlinkInput.addEventListener(
        'change',
        updatePreview
    );

    statusInput.addEventListener(
        'change',
        updatePreview
    );

    pasteUrlButton.addEventListener('click', async () => {
        try {
            const value =
                await navigator.clipboard.readText();

            if (value) {
                urlInput.value = value.trim();
                updateDomain();
                urlInput.focus();
            }
        } catch {
            showToast(
                'Browser tidak mengizinkan membaca clipboard.',
                'error'
            );
        }
    });

    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadLinks();
        }, 350);
    });

    statusFilter.addEventListener('change', () => {
        loadLinks();
    });

    refreshButton.addEventListener('click', () => {
        loadLinks(false);
    });

    cancelDeleteButton.addEventListener(
        'click',
        closeDeleteModal
    );

    confirmDeleteButton.addEventListener(
        'click',
        deleteLink
    );

    modal.addEventListener('click', event => {
        if (event.target === modal) {
            closeModal();
        }
    });

    deleteModal.addEventListener('click', event => {
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            if (!deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
                return;
            }

            if (!modal.classList.contains('hidden')) {
                closeModal();
            }
        }

        if (
            event.ctrlKey &&
            event.key === 'Enter' &&
            !modal.classList.contains('hidden')
        ) {
            event.preventDefault();
            saveLink();
        }
    });

    Promise.all([
        loadShortlinks(),
        loadLinks(),
    ]);
});
</script>
@endpush