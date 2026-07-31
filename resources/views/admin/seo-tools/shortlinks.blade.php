@extends('layouts.admin')

@section('title', 'Shortlinks')
@section('page-title', 'Shortlinks')

@section('content')
<div
    id="shortlinks-app"
    class="mx-auto w-full max-w-[1500px]"
    data-list-url="{{ route('admin.seo-tools.shortlinks.list') }}"
    data-store-url="{{ route('admin.seo-tools.shortlinks.store') }}"
    data-detail-url="{{ route('admin.seo-tools.shortlinks.detail', ['id' => '__ID__']) }}"
    data-update-url="{{ route('admin.seo-tools.shortlinks.update', ['id' => '__ID__']) }}"
    data-delete-url="{{ route('admin.seo-tools.shortlinks.delete', ['id' => '__ID__']) }}"
    data-links-url="{{ route('admin.seo-tools.links') }}"
    data-analytics-url="{{ route('admin.seo-tools.analytics') }}"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-sky-400 via-blue-500 to-indigo-600 shadow-lg shadow-blue-950/40">
                    <x-heroicon-o-link class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Shortlinks
                    </h1>

                    <p class="text-sm text-slate-500">
                        Nawala Shortlink Management
                    </p>
                </div>
            </div>

            <p class="max-w-2xl text-sm leading-6 text-slate-400">
                Buat, kelola, dan pantau seluruh shortlink dari satu dashboard.
            </p>
        </div>

        <button
            id="btnCreate"
            type="button"
            class="group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-950/40 transition hover:-translate-y-0.5 hover:from-sky-500 hover:to-blue-500"
        >
            <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

            <x-heroicon-o-plus class="relative h-5 w-5"/>

            <span class="relative">
                Tambah Shortlink
            </span>
        </button>
    </div>

    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-sky-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-sky-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-600">
                        Total Shortlink
                    </p>

                    <p
                        id="totalShortlink"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Seluruh data tersimpan
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-500/10 text-sky-400 transition group-hover:bg-sky-500 group-hover:text-white">
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
                        id="activeShortlink"
                        class="mt-3 text-3xl font-black tracking-tight text-emerald-400"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Siap menerima trafik
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
                        id="inactiveShortlink"
                        class="mt-3 text-3xl font-black tracking-tight text-red-400"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Sedang dinonaktifkan
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
                        Availability
                    </p>

                    <p
                        id="availabilityRate"
                        class="mt-3 text-3xl font-black tracking-tight text-violet-400"
                    >
                        0%
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Persentase shortlink aktif
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400 transition group-hover:bg-violet-500 group-hover:text-white">
                    <x-heroicon-o-chart-bar class="h-5 w-5"/>
                </div>
            </div>
        </article>
    </div>

    {{-- Table workspace --}}
    <div class="relative mt-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-72 w-72 rounded-full bg-sky-600/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-32 h-72 w-72 rounded-full bg-indigo-600/10 blur-3xl"></div>
        </div>

        {{-- Table header --}}
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
                        Daftar Shortlink
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Cari, filter, edit, atau buka statistik shortlink.
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 transition group-focus-within:text-sky-400"/>
                    </div>

                    <input
                        id="searchInput"
                        type="search"
                        placeholder="Cari nama atau slug..."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-sky-500/70 focus:ring-4 focus:ring-sky-500/10 sm:w-64"
                    >
                </div>

                <select
                    id="statusFilter"
                    class="rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-sm text-slate-300 outline-none transition focus:border-sky-500"
                >
                    <option value="all">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>

                <button
                    id="btnRefresh"
                    type="button"
                    class="flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-3 text-sm font-semibold text-slate-400 transition hover:border-sky-500/30 hover:bg-sky-500/10 hover:text-sky-400"
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
                            ID
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Shortlink
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Slug
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
                        <td colspan="5" class="px-6 py-16">
                            <div class="flex flex-col items-center justify-center text-center">
                                <svg class="h-7 w-7 animate-spin text-sky-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>

                                <p class="mt-3 text-sm font-semibold text-slate-400">
                                    Memuat shortlink...
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Table footer --}}
        <div class="relative flex flex-col gap-2 border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-xs text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span id="resultInfo">
                Menampilkan 0 data
            </span>

            <span>
                Data diperbarui secara realtime dari API
            </span>
        </div>
    </div>
</div>

{{-- Create / edit modal --}}
<div
    id="shortlinkModal"
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
            <div class="absolute -left-28 -top-28 h-64 w-64 rounded-full bg-sky-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
        </div>

        {{-- Modal header --}}
        <div class="relative flex items-center justify-between border-b border-slate-800 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 shadow-lg shadow-blue-950/40">
                    <x-heroicon-o-link class="h-5 w-5 text-white"/>
                </div>

                <div>
                    <h2
                        id="modalTitle"
                        class="font-bold text-white"
                    >
                        Tambah Shortlink
                    </h2>

                    <p
                        id="modalSubtitle"
                        class="mt-1 text-xs text-slate-500"
                    >
                        Buat shortlink baru untuk kebutuhan redirect.
                    </p>
                </div>
            </div>

            <button
                id="closeModal"
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-red-500/10 hover:text-red-400"
                aria-label="Tutup modal"
            >
                <x-heroicon-o-x-mark class="h-6 w-6"/>
            </button>
        </div>

        {{-- Modal body --}}
        <div class="relative space-y-5 p-6">
            <input type="hidden" id="shortlink_id">

            <div>
                <label
                    for="name"
                    class="mb-2 block text-sm font-bold text-slate-300"
                >
                    Nama Shortlink
                </label>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <x-heroicon-o-tag class="h-5 w-5 text-slate-600 transition group-focus-within:text-sky-400"/>
                    </div>

                    <input
                        id="name"
                        type="text"
                        maxlength="150"
                        autocomplete="off"
                        placeholder="Contoh: Campaign Juli"
                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 py-3.5 pl-12 pr-4 text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-sky-500/70 focus:ring-4 focus:ring-sky-500/10"
                    >
                </div>

                <p
                    id="nameError"
                    class="mt-2 hidden text-xs font-medium text-red-400"
                ></p>
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between gap-3">
                    <label
                        for="slug"
                        class="text-sm font-bold text-slate-300"
                    >
                        Slug
                    </label>

                    <button
                        id="generateSlug"
                        type="button"
                        class="text-xs font-semibold text-sky-400 transition hover:text-sky-300"
                    >
                        Generate otomatis
                    </button>
                </div>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <span class="font-mono text-sm text-slate-600">/</span>
                    </div>

                    <input
                        id="slug"
                        type="text"
                        maxlength="150"
                        autocomplete="off"
                        placeholder="campaign-juli"
                        class="w-full rounded-2xl border border-slate-700 bg-slate-950/70 py-3.5 pl-10 pr-4 font-mono text-sm text-white outline-none transition placeholder:text-slate-600 focus:border-sky-500/70 focus:ring-4 focus:ring-sky-500/10"
                    >
                </div>

                <p class="mt-2 text-xs text-slate-600">
                    Gunakan huruf kecil, angka, dan tanda minus.
                </p>

                <p
                    id="slugError"
                    class="mt-2 hidden text-xs font-medium text-red-400"
                ></p>
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between">
                    <label
                        for="description"
                        class="text-sm font-bold text-slate-300"
                    >
                        Deskripsi
                    </label>

                    <span class="text-[11px] text-slate-600">
                        <span id="descriptionCount">0</span>/500
                    </span>
                </div>

                <textarea
                    id="description"
                    rows="4"
                    maxlength="500"
                    placeholder="Catatan atau penjelasan singkat..."
                    class="w-full resize-none rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3.5 text-sm leading-6 text-white outline-none transition placeholder:text-slate-600 focus:border-sky-500/70 focus:ring-4 focus:ring-sky-500/10"
                ></textarea>
            </div>

            {{-- Status toggle --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950/50 p-4">
                <label class="flex cursor-pointer items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10">
                            <x-heroicon-o-signal class="h-5 w-5 text-emerald-400"/>
                        </div>

                        <div>
                            <p class="text-sm font-bold text-slate-300">
                                Status Shortlink
                            </p>

                            <p
                                id="statusHelp"
                                class="mt-1 text-xs text-slate-600"
                            >
                                Shortlink akan langsung aktif.
                            </p>
                        </div>
                    </div>

                    <div class="relative">
                        <input
                            id="is_active"
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
                class="flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-950/30 transition hover:-translate-y-0.5 hover:from-sky-500 hover:to-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
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
                    Simpan Shortlink
                </span>
            </button>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
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
                Hapus Shortlink?
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Data
                <span
                    id="deleteTargetName"
                    class="font-semibold text-slate-300"
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

{{-- Toast --}}
<div
    id="toastContainer"
    class="pointer-events-none fixed right-5 top-5 z-[80] flex w-[calc(100%-2.5rem)] max-w-sm flex-col gap-3"
></div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('shortlinks-app');

    if (!app) {
        return;
    }

    const routes = {
        list: app.dataset.listUrl,
        store: app.dataset.storeUrl,
        detail: app.dataset.detailUrl,
        update: app.dataset.updateUrl,
        delete: app.dataset.deleteUrl,
        links: app.dataset.linksUrl,
        analytics: app.dataset.analyticsUrl,
    };

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    const table = document.getElementById('tableBody');
    const resultInfo = document.getElementById('resultInfo');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const refreshButton = document.getElementById('btnRefresh');
    const refreshIcon = document.getElementById('refreshIcon');

    const totalShortlink = document.getElementById('totalShortlink');
    const activeShortlink = document.getElementById('activeShortlink');
    const inactiveShortlink = document.getElementById('inactiveShortlink');
    const availabilityRate = document.getElementById('availabilityRate');

    const modal = document.getElementById('shortlinkModal');
    const modalPanel = document.getElementById('modalPanel');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubtitle = document.getElementById('modalSubtitle');

    const idInput = document.getElementById('shortlink_id');
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const descriptionInput = document.getElementById('description');
    const activeInput = document.getElementById('is_active');
    const descriptionCount = document.getElementById('descriptionCount');
    const statusHelp = document.getElementById('statusHelp');
    const nameError = document.getElementById('nameError');
    const slugError = document.getElementById('slugError');

    const createButton = document.getElementById('btnCreate');
    const saveButton = document.getElementById('btnSave');
    const saveText = document.getElementById('saveText');
    const saveIcon = document.getElementById('saveIcon');
    const saveSpinner = document.getElementById('saveSpinner');
    const generateSlugButton = document.getElementById('generateSlug');

    const deleteModal = document.getElementById('deleteModal');
    const deleteTargetName = document.getElementById('deleteTargetName');
    const cancelDeleteButton = document.getElementById('cancelDelete');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    const deleteSpinner = document.getElementById('deleteSpinner');

    const toastContainer = document.getElementById('toastContainer');

    let shortlinks = [];
    let deleteTarget = null;
    let isLoading = false;
    let slugEditedManually = false;

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

    function slugify(value) {
        return String(value ?? '')
            .toLowerCase()
            .trim()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .replace(/-{2,}/g, '-');
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
                border: 'border-sky-500/20',
                background: 'bg-sky-500/10',
                text: 'text-sky-300',
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

    function setStats(items) {
        const total = items.length;
        const active = items.filter(item => Boolean(item.is_active)).length;
        const inactive = total - active;
        const rate = total > 0
            ? Math.round((active / total) * 100)
            : 0;

        totalShortlink.textContent = total.toLocaleString('id-ID');
        activeShortlink.textContent = active.toLocaleString('id-ID');
        inactiveShortlink.textContent = inactive.toLocaleString('id-ID');
        availabilityRate.textContent = `${rate}%`;
    }

    function setLoadingState(loading) {
        isLoading = loading;
        refreshButton.disabled = loading;
        refreshIcon.classList.toggle('animate-spin', loading);
    }

    function renderLoading() {
        table.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-16">
                    <div class="flex flex-col items-center justify-center text-center">
                        <svg class="h-7 w-7 animate-spin text-sky-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>

                        <p class="mt-3 text-sm font-semibold text-slate-400">
                            Memuat shortlink...
                        </p>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderEmpty(title = 'Belum ada shortlink', description = 'Klik Tambah Shortlink untuk membuat data pertama.') {
        table.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-16">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800 text-2xl">
                            🔗
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

    function getFilteredShortlinks() {
        const keyword = searchInput.value.trim().toLowerCase();
        const status = statusFilter.value;

        return shortlinks.filter(item => {
            const matchesKeyword =
                !keyword ||
                String(item.name ?? '').toLowerCase().includes(keyword) ||
                String(item.slug ?? '').toLowerCase().includes(keyword) ||
                String(item.description ?? '').toLowerCase().includes(keyword);

            const matchesStatus =
                status === 'all' ||
                (status === 'active' && Boolean(item.is_active)) ||
                (status === 'inactive' && !Boolean(item.is_active));

            return matchesKeyword && matchesStatus;
        });
    }

    function renderTable() {
        const items = getFilteredShortlinks();

        resultInfo.textContent =
            `Menampilkan ${items.length.toLocaleString('id-ID')} dari ${shortlinks.length.toLocaleString('id-ID')} data`;

        if (items.length === 0) {
            const isFiltered =
                searchInput.value.trim() ||
                statusFilter.value !== 'all';

            renderEmpty(
                isFiltered ? 'Data tidak ditemukan' : 'Belum ada shortlink',
                isFiltered
                    ? 'Coba ubah kata pencarian atau filter status.'
                    : 'Klik Tambah Shortlink untuk membuat data pertama.'
            );

            return;
        }

        table.innerHTML = items.map(item => {
            const id = escapeHtml(item.id);
            const name = escapeHtml(item.name || 'Tanpa nama');
            const slug = escapeHtml(item.slug || '-');
            const description = escapeHtml(
                item.description || 'Tidak ada deskripsi'
            );

            const statusBadge = item.is_active
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

            const linksUrl = new URL(routes.links, window.location.origin);
            linksUrl.searchParams.set('shortlink', item.id);

            const analyticsUrl = new URL(
                routes.analytics,
                window.location.origin
            );
            analyticsUrl.searchParams.set('shortlink', item.id);

            return `
                <tr class="group transition hover:bg-slate-800/35">
                    <td class="whitespace-nowrap px-5 py-4">
                        <span class="rounded-lg border border-slate-700 bg-slate-950/60 px-2.5 py-1 font-mono text-xs text-slate-500">
                            #${id}
                        </span>
                    </td>

                    <td class="min-w-[240px] px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500/15 to-blue-500/10 text-sky-400 transition group-hover:from-sky-500 group-hover:to-blue-600 group-hover:text-white">
                                🔗
                            </div>

                            <div class="min-w-0">
                                <p class="truncate font-bold text-slate-200">
                                    ${name}
                                </p>

                                <p class="mt-1 max-w-md truncate text-xs text-slate-600" title="${description}">
                                    ${description}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="min-w-[190px] px-5 py-4">
                        <button
                            type="button"
                            class="copy-slug group/slug inline-flex max-w-[230px] items-center gap-2 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 font-mono text-xs text-sky-300 transition hover:border-sky-500/30 hover:bg-sky-500/10"
                            data-slug="${slug}"
                            title="Copy slug"
                        >
                            <span class="truncate">/${slug}</span>
                            <span class="text-slate-600 transition group-hover/slug:text-sky-400">⧉</span>
                        </button>
                    </td>

                    <td class="whitespace-nowrap px-5 py-4">
                        ${statusBadge}
                    </td>

                    <td class="whitespace-nowrap px-5 py-4">
                        <div class="flex justify-end gap-2">
                            <a
                                href="${escapeHtml(linksUrl.toString())}"
                                class="flex h-9 items-center gap-2 rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 text-xs font-bold text-sky-400 transition hover:bg-sky-500 hover:text-white"
                                title="Kelola links"
                            >
                                Links
                            </a>

                            <a
                                href="${escapeHtml(analyticsUrl.toString())}"
                                class="flex h-9 items-center gap-2 rounded-xl border border-violet-500/20 bg-violet-500/10 px-3 text-xs font-bold text-violet-400 transition hover:bg-violet-500 hover:text-white"
                                title="Lihat history"
                            >
                                History
                            </a>

                            <button
                                type="button"
                                class="edit-shortlink flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500/20 bg-amber-500/10 text-amber-400 transition hover:bg-amber-500 hover:text-slate-950"
                                data-id="${id}"
                                title="Edit"
                            >
                                ✎
                            </button>

                            <button
                                type="button"
                                class="delete-shortlink flex h-9 w-9 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 transition hover:bg-red-500 hover:text-white"
                                data-id="${id}"
                                data-name="${name}"
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
        table.querySelectorAll('.edit-shortlink')
            .forEach(button => {
                button.addEventListener('click', () => {
                    editData(button.dataset.id);
                });
            });

        table.querySelectorAll('.delete-shortlink')
            .forEach(button => {
                button.addEventListener('click', () => {
                    openDeleteModal({
                        id: button.dataset.id,
                        name: button.dataset.name,
                    });
                });
            });

        table.querySelectorAll('.copy-slug')
            .forEach(button => {
                button.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(
                            button.dataset.slug || ''
                        );

                        showToast('Slug berhasil disalin.', 'success');
                    } catch {
                        showToast('Slug tidak dapat disalin.', 'error');
                    }
                });
            });
    }

    async function loadData(showLoader = true) {
        if (isLoading) {
            return;
        }

        setLoadingState(true);

        if (showLoader) {
            renderLoading();
        }

        try {
            const response = await fetch(routes.list, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(
                    result.message || 'Gagal mengambil data shortlink.'
                );
            }

            shortlinks = Array.isArray(result.data)
                ? result.data
                : [];

            setStats(shortlinks);
            renderTable();
        } catch (error) {
            shortlinks = [];
            setStats(shortlinks);

            renderEmpty(
                'Gagal mengambil data',
                error.message || 'Terjadi kesalahan saat menghubungi server.'
            );

            resultInfo.textContent = 'Data gagal dimuat';
            showToast(error.message, 'error');
        } finally {
            setLoadingState(false);
        }
    }

    function clearValidation() {
        [nameInput, slugInput].forEach(input => {
            input.classList.remove(
                'border-red-500',
                'focus:border-red-500'
            );
        });

        [nameError, slugError].forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
    }

    function showFieldError(field, message) {
        const map = {
            name: {
                input: nameInput,
                error: nameError,
            },
            slug: {
                input: slugInput,
                error: slugError,
            },
        };

        const target = map[field];

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

    function resetForm() {
        idInput.value = '';
        nameInput.value = '';
        slugInput.value = '';
        descriptionInput.value = '';
        activeInput.checked = true;
        descriptionCount.textContent = '0';
        slugEditedManually = false;

        modalTitle.textContent = 'Tambah Shortlink';
        modalSubtitle.textContent =
            'Buat shortlink baru untuk kebutuhan redirect.';

        saveText.textContent = 'Simpan Shortlink';
        statusHelp.textContent = 'Shortlink akan langsung aktif.';

        clearValidation();
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

            nameInput.focus();
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
                ? 'Update Shortlink'
                : 'Simpan Shortlink';
    }

    async function saveData() {
        clearValidation();

        const id = idInput.value;
        const payload = {
            name: nameInput.value.trim(),
            slug: slugify(slugInput.value),
            description: descriptionInput.value.trim(),
            is_active: activeInput.checked,
        };

        if (!payload.name) {
            showFieldError('name', 'Nama shortlink wajib diisi.');
        }

        if (!payload.slug) {
            showFieldError('slug', 'Slug wajib diisi.');
        }

        if (!payload.name || !payload.slug) {
            return;
        }

        slugInput.value = payload.slug;
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

            if (!response.ok || result.success === false) {
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

                console.error('Create shortlink failed:', result);

                throw new Error(
                    result.message ||
                    result.error ||
                    'Nawala API gagal membuat shortlink.'
                );
            }

            closeModal();
            await loadData(false);

            showToast(
                id
                    ? 'Shortlink berhasil diperbarui.'
                    : 'Shortlink berhasil dibuat.',
                'success'
            );
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            setSaveLoading(false);
        }
    }

    async function editData(id) {
        resetForm();

        modalTitle.textContent = 'Edit Shortlink';
        modalSubtitle.textContent =
            'Perbarui informasi dan status shortlink.';
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
                    result.message || 'Gagal mengambil detail shortlink.'
                );
            }

            const data = result.data ?? result;

            idInput.value = data.id ?? id;
            nameInput.value = data.name ?? '';
            slugInput.value = data.slug ?? '';
            descriptionInput.value = data.description ?? '';
            activeInput.checked = Boolean(data.is_active);
            descriptionCount.textContent =
                descriptionInput.value.length.toLocaleString('id-ID');

            slugEditedManually = true;

            statusHelp.textContent = activeInput.checked
                ? 'Shortlink sedang aktif.'
                : 'Shortlink sedang dinonaktifkan.';

            saveText.textContent = 'Update Shortlink';
        } catch (error) {
            closeModal();
            showToast(error.message, 'error');
        } finally {
            saveButton.disabled = false;
        }
    }

    function openDeleteModal(target) {
        deleteTarget = target;
        deleteTargetName.textContent = `"${target.name}"`;

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

    async function deleteData() {
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
                    result.message || 'Gagal menghapus shortlink.'
                );
            }

            closeDeleteModal();
            await loadData(false);

            showToast(
                'Shortlink berhasil dihapus.',
                'success'
            );
        } catch (error) {
            showToast(error.message, 'error');
        } finally {
            confirmDeleteButton.disabled = false;
            deleteSpinner.classList.add('hidden');
        }
    }

    createButton.addEventListener('click', () => {
        resetForm();
        openModal();
    });

    document.getElementById('btnClose')
        .addEventListener('click', closeModal);

    document.getElementById('closeModal')
        .addEventListener('click', closeModal);

    saveButton.addEventListener('click', saveData);

    generateSlugButton.addEventListener('click', () => {
        slugInput.value = slugify(nameInput.value);
        slugEditedManually = true;
        slugInput.focus();
    });

    nameInput.addEventListener('input', () => {
        if (!slugEditedManually) {
            slugInput.value = slugify(nameInput.value);
        }
    });

    slugInput.addEventListener('input', () => {
        slugEditedManually = slugInput.value.trim().length > 0;
    });

    descriptionInput.addEventListener('input', () => {
        descriptionCount.textContent =
            descriptionInput.value.length.toLocaleString('id-ID');
    });

    activeInput.addEventListener('change', () => {
        statusHelp.textContent = activeInput.checked
            ? 'Shortlink akan langsung aktif.'
            : 'Shortlink akan disimpan sebagai nonaktif.';
    });

    searchInput.addEventListener('input', renderTable);
    statusFilter.addEventListener('change', renderTable);

    refreshButton.addEventListener('click', () => {
        loadData(false);
    });

    cancelDeleteButton.addEventListener(
        'click',
        closeDeleteModal
    );

    confirmDeleteButton.addEventListener(
        'click',
        deleteData
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
            saveData();
        }
    });

    loadData();
});
</script>
@endpush