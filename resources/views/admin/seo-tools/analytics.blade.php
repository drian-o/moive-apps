@extends('layouts.admin')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
<div
    id="analytics-app"
    class="mx-auto w-full max-w-[1700px]"
    data-analytics-url="{{ route('admin.seo-tools.analytics.data') }}"
>
    {{-- Page header --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-400 via-sky-500 to-blue-600 shadow-lg shadow-cyan-950/40">
                    <x-heroicon-o-chart-bar class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Analytics
                    </h1>

                    <p class="text-sm text-slate-500">
                        Statistik klik shortlink Anda
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Pantau performa shortlink, sumber trafik, perangkat, lokasi, dan klik terbaru secara realtime.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div
                id="analytics-status"
                class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-2"
            >
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>

                <span class="text-xs font-semibold text-emerald-400">
                    Live Data
                </span>
            </div>

            <button
                id="refreshAnalytics"
                type="button"
                class="flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 text-xs font-bold text-slate-400 transition hover:border-cyan-500/30 hover:bg-cyan-500/10 hover:text-cyan-400 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <x-heroicon-o-arrow-path id="refreshAnalyticsIcon" class="h-4 w-4"/>
                Refresh
            </button>
        </div>
    </div>

    {{-- Overview toolbar --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-black text-white">
                Overview
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Monitor performa shortlink Anda.
            </p>
        </div>

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <x-heroicon-o-calendar-days class="h-4 w-4 text-slate-500"/>
            </div>

            <select
                id="periodFilter"
                class="appearance-none rounded-xl border border-slate-700 bg-slate-900 py-2.5 pl-10 pr-10 text-xs font-bold text-slate-300 outline-none transition focus:border-cyan-500"
            >
                <option value="7">7 Hari</option>
                <option value="14">14 Hari</option>
                <option value="30">30 Hari</option>
                <option value="all">Semua Waktu</option>
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <x-heroicon-o-chevron-down class="h-4 w-4 text-slate-600"/>
            </div>
        </div>
    </div>

    {{-- KPI cards --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-cyan-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-cyan-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Total Klik
                    </p>

                    <p
                        id="totalClicks"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Seluruh trafik tercatat
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400 transition group-hover:bg-cyan-500 group-hover:text-white">
                    <x-heroicon-o-cursor-arrow-rays class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-emerald-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-emerald-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Hari Ini
                    </p>

                    <p
                        id="todayClicks"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p
                        id="todayComparison"
                        class="mt-1 text-xs font-semibold text-slate-500"
                    >
                        Belum ada pembanding
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 transition group-hover:bg-emerald-500 group-hover:text-white">
                    <x-heroicon-o-arrow-trending-up class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-blue-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-blue-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p
                        id="periodCardLabel"
                        class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600"
                    >
                        7 Hari
                    </p>

                    <p
                        id="periodClicks"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p
                        id="periodComparison"
                        class="mt-1 text-xs font-semibold text-slate-500"
                    >
                        Belum ada pembanding
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 transition group-hover:bg-blue-500 group-hover:text-white">
                    <x-heroicon-o-eye class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:border-amber-500/30">
            <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-amber-500/10 blur-2xl"></div>

            <div class="relative flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Negara
                    </p>

                    <p
                        id="totalCountries"
                        class="mt-3 text-3xl font-black tracking-tight text-white"
                    >
                        0
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Lokasi unik terdeteksi
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400 transition group-hover:bg-amber-500 group-hover:text-white">
                    <x-heroicon-o-flag class="h-5 w-5"/>
                </div>
            </div>
        </article>
    </div>

    {{-- Trend chart --}}
    <section class="relative mt-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/10">
        <div class="flex items-center justify-between gap-4 border-b border-slate-800 px-5 py-4">
            <div>
                <h3 class="text-sm font-black text-white">
                    Trend Klik Harian
                </h3>

                <p class="mt-1 text-[11px] text-slate-600">
                    Distribusi jumlah klik berdasarkan tanggal.
                </p>
            </div>

            <span
                id="trendTotal"
                class="rounded-full border border-slate-700 bg-slate-950/60 px-3 py-1 text-[10px] font-bold text-slate-400"
            >
                0 total
            </span>
        </div>

        <div class="relative h-[300px] p-4 sm:p-5">
            <div
                id="chartEmptyState"
                class="absolute inset-0 z-10 hidden items-center justify-center text-center"
            >
                <div>
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-800">
                        <x-heroicon-o-chart-bar class="h-6 w-6 text-slate-500"/>
                    </div>

                    <p class="mt-3 text-sm font-bold text-slate-400">
                        Belum ada data klik
                    </p>
                </div>
            </div>

            <canvas id="trendChart"></canvas>
        </div>
    </section>

    {{-- Breakdown panels --}}
    <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-device-phone-mobile class="h-4 w-4 text-cyan-400"/>

                <h3 class="text-xs font-black text-white">
                    Device
                </h3>
            </div>

            <div id="deviceBreakdown" class="space-y-3 p-4"></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-globe-alt class="h-4 w-4 text-emerald-400"/>

                <h3 class="text-xs font-black text-white">
                    Browser
                </h3>
            </div>

            <div id="browserBreakdown" class="space-y-3 p-4"></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-computer-desktop class="h-4 w-4 text-fuchsia-400"/>

                <h3 class="text-xs font-black text-white">
                    OS
                </h3>
            </div>

            <div id="osBreakdown" class="space-y-3 p-4"></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-link class="h-4 w-4 text-sky-400"/>

                <h3 class="text-xs font-black text-white">
                    Referrer
                </h3>
            </div>

            <div id="referrerBreakdown" class="space-y-3 p-4"></div>
        </section>
    </div>

    {{-- Countries/cities and shortlinks --}}
    <div class="mt-4 grid gap-4 xl:grid-cols-2">
        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-map-pin class="h-4 w-4 text-cyan-400"/>

                <h3 class="text-xs font-black text-white">
                    Top Negara & Kota
                </h3>
            </div>

            <div class="grid gap-5 p-4 sm:grid-cols-2">
                <div>
                    <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                        Negara
                    </p>

                    <div id="countryBreakdown" class="space-y-3"></div>
                </div>

                <div>
                    <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                        Kota
                    </p>

                    <div id="cityBreakdown" class="space-y-3"></div>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
            <div class="flex items-center gap-2 border-b border-slate-800 px-4 py-3">
                <x-heroicon-o-arrow-trending-up class="h-4 w-4 text-cyan-400"/>

                <h3 class="text-xs font-black text-white">
                    Top Shortlinks
                </h3>
            </div>

            <div id="shortlinkBreakdown" class="space-y-3 p-4"></div>
        </section>
    </div>

    {{-- Recent clicks --}}
    <section class="mt-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-lg shadow-black/10">
        <div class="flex flex-col gap-3 border-b border-slate-800 px-5 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-sm font-black text-white">
                    Klik Terbaru
                </h3>

                <p class="mt-1 text-[11px] text-slate-600">
                    Aktivitas terbaru dari seluruh shortlink.
                </p>
            </div>

            <div class="group relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 transition group-focus-within:text-cyan-400"/>
                </div>

                <input
                    id="clickSearch"
                    type="search"
                    placeholder="Cari slug, negara, kota, browser..."
                    class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-4 text-xs text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-500/70 focus:ring-4 focus:ring-cyan-500/10 lg:w-80"
                >
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950/55">
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Slug
                        </th>

                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Device
                        </th>

                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Browser
                        </th>

                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            OS
                        </th>

                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Lokasi
                        </th>

                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Referrer
                        </th>

                        <th class="px-4 py-3 text-right text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                            Waktu
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="recentClicksBody"
                    class="divide-y divide-slate-800"
                >
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center text-slate-500">
                            Memuat data analytics...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-2 border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-[11px] text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span id="recentClicksInfo">
                Menampilkan 0 klik
            </span>

            <span>
                Urutan terbaru ke terlama
            </span>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('analytics-app');

    if (!app) {
        return;
    }

    const analyticsUrl = app.dataset.analyticsUrl;

    const periodFilter = document.getElementById('periodFilter');
    const refreshButton = document.getElementById('refreshAnalytics');
    const refreshIcon = document.getElementById('refreshAnalyticsIcon');
    const analyticsStatus = document.getElementById('analytics-status');

    const totalClicks = document.getElementById('totalClicks');
    const todayClicks = document.getElementById('todayClicks');
    const todayComparison = document.getElementById('todayComparison');
    const periodCardLabel = document.getElementById('periodCardLabel');
    const periodClicks = document.getElementById('periodClicks');
    const periodComparison = document.getElementById('periodComparison');
    const totalCountries = document.getElementById('totalCountries');
    const trendTotal = document.getElementById('trendTotal');
    const chartEmptyState = document.getElementById('chartEmptyState');

    const deviceBreakdown = document.getElementById('deviceBreakdown');
    const browserBreakdown = document.getElementById('browserBreakdown');
    const osBreakdown = document.getElementById('osBreakdown');
    const referrerBreakdown = document.getElementById('referrerBreakdown');
    const countryBreakdown = document.getElementById('countryBreakdown');
    const cityBreakdown = document.getElementById('cityBreakdown');
    const shortlinkBreakdown = document.getElementById('shortlinkBreakdown');

    const clickSearch = document.getElementById('clickSearch');
    const recentClicksBody = document.getElementById('recentClicksBody');
    const recentClicksInfo = document.getElementById('recentClicksInfo');

    let rawRows = [];
    let normalizedRows = [];
    let trendChart = null;
    let isLoading = false;

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function valueAt(source, paths, fallback = null) {
        for (const path of paths) {
            const parts = path.split('.');
            let current = source;

            for (const part of parts) {
                if (
                    current === null ||
                    current === undefined ||
                    typeof current !== 'object'
                ) {
                    current = undefined;
                    break;
                }

                current = current[part];
            }

            if (
                current !== undefined &&
                current !== null &&
                current !== ''
            ) {
                return current;
            }
        }

        return fallback;
    }

    function parseDate(value) {
        if (!value) {
            return null;
        }

        const date = new Date(value);

        return Number.isNaN(date.getTime())
            ? null
            : date;
    }

    function normalizeName(value, fallback = 'Unknown') {
        const text = String(value ?? '').trim();

        return text || fallback;
    }

    function normalizeRow(item) {
        const date = parseDate(
            valueAt(item, [
                'created_at',
                'clicked_at',
                'timestamp',
                'date',
                'createdAt',
            ])
        );

        const slug = normalizeName(
            valueAt(item, [
                'slug',
                'shortlink.slug',
                'shortlink_slug',
                'shortlink.name',
                'shortlink_name',
            ]),
            '-'
        );

        const country = normalizeName(
            valueAt(item, [
                'country',
                'country_name',
                'location.country',
                'geo.country',
            ]),
            'Unknown'
        );

        const city = normalizeName(
            valueAt(item, [
                'city',
                'city_name',
                'location.city',
                'geo.city',
            ]),
            'Unknown'
        );

        const device = normalizeName(
            valueAt(item, [
                'device',
                'device_type',
                'device.name',
                'user_agent.device',
            ]),
            'Unknown'
        );

        const browser = normalizeName(
            valueAt(item, [
                'browser',
                'browser_name',
                'browser.name',
                'user_agent.browser',
            ]),
            'Unknown'
        );

        const os = normalizeName(
            valueAt(item, [
                'os',
                'operating_system',
                'os_name',
                'user_agent.os',
            ]),
            'Unknown'
        );

        const referrer = normalizeName(
            valueAt(item, [
                'referrer',
                'referer',
                'referrer_url',
                'referer_url',
                'source',
            ]),
            'Direct'
        );

        return {
            raw: item,
            date,
            slug,
            country,
            city,
            device,
            browser,
            os,
            referrer,
        };
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

    function startOfDay(date) {
        const copy = new Date(date);
        copy.setHours(0, 0, 0, 0);
        return copy;
    }

    function addDays(date, amount) {
        const copy = new Date(date);
        copy.setDate(copy.getDate() + amount);
        return copy;
    }

    function dateKey(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    function formatDateLabel(date) {
        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
        }).format(date);
    }

    function formatDateTime(date) {
        if (!date) {
            return '-';
        }

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
        }).format(date);
    }

    function getPeriodDays() {
        return periodFilter.value === 'all'
            ? null
            : Number(periodFilter.value);
    }

    function filterByPeriod(rows, days, offsetPeriods = 0) {
        if (!days) {
            return rows;
        }

        const today = startOfDay(new Date());

        const endExclusive = addDays(
            today,
            1 - (days * offsetPeriods)
        );

        const startInclusive = addDays(
            endExclusive,
            -days
        );

        return rows.filter(row => {
            if (!row.date) {
                return false;
            }

            return (
                row.date >= startInclusive &&
                row.date < endExclusive
            );
        });
    }

    function getTodayRows(rows, dayOffset = 0) {
        const start = addDays(
            startOfDay(new Date()),
            dayOffset
        );

        const end = addDays(start, 1);

        return rows.filter(row => {
            return (
                row.date &&
                row.date >= start &&
                row.date < end
            );
        });
    }

    function setComparison(element, current, previous, suffix) {
        element.className =
            'mt-1 text-xs font-semibold text-slate-500';

        if (previous === 0 && current === 0) {
            element.textContent = 'Belum ada trafik';
            return;
        }

        if (previous === 0 && current > 0) {
            element.textContent = `+100% ${suffix}`;
            element.className =
                'mt-1 text-xs font-semibold text-emerald-400';
            return;
        }

        const change = Math.round(
            ((current - previous) / previous) * 100
        );

        if (change > 0) {
            element.textContent = `+${change}% ${suffix}`;
            element.className =
                'mt-1 text-xs font-semibold text-emerald-400';
            return;
        }

        if (change < 0) {
            element.textContent = `${change}% ${suffix}`;
            element.className =
                'mt-1 text-xs font-semibold text-red-400';
            return;
        }

        element.textContent = `0% ${suffix}`;
    }

    function countBy(rows, key) {
        return rows.reduce((result, row) => {
            const value = normalizeName(row[key], 'Unknown');
            result[value] = (result[value] || 0) + 1;
            return result;
        }, {});
    }

    function sortedEntries(counts, limit = null) {
        const entries = Object.entries(counts)
            .sort((a, b) => b[1] - a[1]);

        return limit
            ? entries.slice(0, limit)
            : entries;
    }

    function renderBreakdown(
        container,
        counts,
        options = {}
    ) {
        const {
            limit = 5,
            barClass = 'bg-cyan-400',
            emptyText = 'Belum ada data',
            labelFormatter = value => value,
        } = options;

        const entries = sortedEntries(counts, limit);
        const maximum = entries[0]?.[1] || 0;

        if (entries.length === 0) {
            container.innerHTML = `
                <div class="flex min-h-[90px] items-center justify-center text-center">
                    <p class="text-xs text-slate-600">
                        ${escapeHtml(emptyText)}
                    </p>
                </div>
            `;
            return;
        }

        container.innerHTML = entries.map(([label, value]) => {
            const percent = maximum > 0
                ? Math.max((value / maximum) * 100, 2)
                : 0;

            return `
                <div>
                    <div class="mb-1.5 flex items-center justify-between gap-3">
                        <span
                            class="min-w-0 truncate text-[11px] font-medium text-slate-400"
                            title="${escapeHtml(label)}"
                        >
                            ${escapeHtml(labelFormatter(label))}
                        </span>

                        <span class="shrink-0 text-[11px] font-black text-slate-200">
                            ${Number(value).toLocaleString('id-ID')}
                        </span>
                    </div>

                    <div class="h-1.5 overflow-hidden rounded-full bg-slate-800">
                        <div
                            class="h-full rounded-full ${barClass} transition-all duration-500"
                            style="width: ${percent}%"
                        ></div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function shortReferrer(value) {
        if (value === 'Direct') {
            return 'Direct';
        }

        try {
            const url = new URL(value);
            return `${url.hostname}${url.pathname === '/' ? '' : url.pathname}`;
        } catch {
            return value;
        }
    }

    function buildTrendRows(rows, days) {
        if (days) {
            const today = startOfDay(new Date());
            const start = addDays(today, -(days - 1));

            return Array.from({ length: days }, (_, index) => {
                const date = addDays(start, index);
                const key = dateKey(date);

                return {
                    date,
                    key,
                    count: rows.filter(row => (
                        row.date &&
                        dateKey(row.date) === key
                    )).length,
                };
            });
        }

        const grouped = rows.reduce((result, row) => {
            if (!row.date) {
                return result;
            }

            const key = dateKey(row.date);
            result[key] = (result[key] || 0) + 1;
            return result;
        }, {});

        return Object.entries(grouped)
            .sort(([a], [b]) => a.localeCompare(b))
            .map(([key, count]) => ({
                date: new Date(`${key}T00:00:00`),
                key,
                count,
            }));
    }

    function renderTrend(rows, days) {
        const trendRows = buildTrendRows(rows, days);
        const values = trendRows.map(item => item.count);
        const labels = trendRows.map(item => (
            formatDateLabel(item.date)
        ));

        trendTotal.textContent =
            `${rows.length.toLocaleString('id-ID')} total`;

        chartEmptyState.classList.toggle(
            'hidden',
            rows.length > 0
        );
        chartEmptyState.classList.toggle(
            'flex',
            rows.length === 0
        );

        if (trendChart) {
            trendChart.destroy();
        }

        const context = document
            .getElementById('trendChart')
            .getContext('2d');

        trendChart = new Chart(context, {
            type: 'bar',

            data: {
                labels,

                datasets: [{
                    label: 'Klik',
                    data: values,
                    backgroundColor: 'rgba(34, 211, 238, 0.85)',
                    borderColor: '#22d3ee',
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false,
                    maxBarThickness: 90,
                }],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 500,
                },

                plugins: {
                    legend: {
                        display: false,
                    },

                    tooltip: {
                        backgroundColor: '#020617',
                        borderColor: '#1e293b',
                        borderWidth: 1,
                        displayColors: false,
                        titleColor: '#94a3b8',
                        bodyColor: '#ffffff',

                        callbacks: {
                            label(context) {
                                return `${context.parsed.y} klik`;
                            },
                        },
                    },
                },

                scales: {
                    x: {
                        border: {
                            display: false,
                        },

                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 10,
                            },
                            maxRotation: 0,
                            autoSkip: true,
                        },

                        grid: {
                            display: false,
                        },
                    },

                    y: {
                        beginAtZero: true,
                        border: {
                            display: false,
                        },

                        ticks: {
                            color: '#64748b',
                            precision: 0,
                            font: {
                                size: 10,
                            },
                        },

                        grid: {
                            color: 'rgba(148, 163, 184, 0.07)',
                        },
                    },
                },
            },
        });
    }

    function renderRecentClicks(rows) {
        const keyword = clickSearch.value
            .trim()
            .toLowerCase();

        const filtered = rows
            .filter(row => {
                if (!keyword) {
                    return true;
                }

                return [
                    row.slug,
                    row.device,
                    row.browser,
                    row.os,
                    row.country,
                    row.city,
                    row.referrer,
                ].some(value => (
                    String(value).toLowerCase().includes(keyword)
                ));
            })
            .sort((a, b) => {
                const aTime = a.date?.getTime() || 0;
                const bTime = b.date?.getTime() || 0;
                return bTime - aTime;
            })
            .slice(0, 25);

        recentClicksInfo.textContent =
            `Menampilkan ${filtered.length.toLocaleString('id-ID')} klik`;

        if (filtered.length === 0) {
            recentClicksBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-14 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-800">
                            <x-heroicon-o-magnifying-glass class="h-6 w-6 text-slate-500"/>
                        </div>

                        <p class="mt-3 text-sm font-bold text-slate-400">
                            Data tidak ditemukan
                        </p>
                    </td>
                </tr>
            `;
            return;
        }

        recentClicksBody.innerHTML = filtered.map(row => {
            const location = [
                row.country !== 'Unknown' ? row.country : null,
                row.city !== 'Unknown' ? row.city : null,
            ].filter(Boolean).join(', ') || '-';

            const isMobile = row.device
                .toLowerCase()
                .includes('mobile');

            return `
                <tr class="transition hover:bg-slate-800/35">
                    <td class="px-4 py-3">
                        <span class="font-semibold text-cyan-400">
                            ${escapeHtml(row.slug)}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        <span class="inline-flex rounded-full border border-slate-700 bg-slate-950/60 px-2.5 py-1 text-[10px] font-bold text-slate-300">
                            ${isMobile ? 'Mobile' : escapeHtml(row.device)}
                        </span>
                    </td>

                    <td class="px-4 py-3 font-medium text-slate-300">
                        ${escapeHtml(row.browser)}
                    </td>

                    <td class="px-4 py-3 font-medium text-slate-300">
                        ${escapeHtml(row.os)}
                    </td>

                    <td class="min-w-[180px] px-4 py-3 font-medium text-slate-300">
                        ${escapeHtml(location)}
                    </td>

                    <td class="max-w-[220px] px-4 py-3">
                        <span
                            class="block truncate text-slate-500"
                            title="${escapeHtml(row.referrer)}"
                        >
                            ${escapeHtml(shortReferrer(row.referrer))}
                        </span>
                    </td>

                    <td class="whitespace-nowrap px-4 py-3 text-right text-slate-500">
                        ${escapeHtml(formatDateTime(row.date))}
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderDashboard() {
        const days = getPeriodDays();
        const periodRows = filterByPeriod(
            normalizedRows,
            days
        );

        const previousPeriodRows = days
            ? filterByPeriod(normalizedRows, days, 1)
            : [];

        const todayRows = getTodayRows(normalizedRows, 0);
        const yesterdayRows = getTodayRows(normalizedRows, -1);

        totalClicks.textContent =
            normalizedRows.length.toLocaleString('id-ID');

        todayClicks.textContent =
            todayRows.length.toLocaleString('id-ID');

        periodClicks.textContent =
            periodRows.length.toLocaleString('id-ID');

        const selectedLabel = days
            ? `${days} Hari`
            : 'Semua Waktu';

        periodCardLabel.textContent = selectedLabel;

        const uniqueCountries = new Set(
            periodRows
                .map(row => row.country)
                .filter(country => country !== 'Unknown')
        );

        totalCountries.textContent =
            uniqueCountries.size.toLocaleString('id-ID');

        setComparison(
            todayComparison,
            todayRows.length,
            yesterdayRows.length,
            'vs kemarin'
        );

        if (days) {
            setComparison(
                periodComparison,
                periodRows.length,
                previousPeriodRows.length,
                'vs minggu lalu'
            );
        } else {
            periodComparison.textContent =
                'Seluruh data tersedia';
            periodComparison.className =
                'mt-1 text-xs font-semibold text-slate-500';
        }

        renderTrend(periodRows, days);

        renderBreakdown(
            deviceBreakdown,
            countBy(periodRows, 'device'),
            {
                barClass: 'bg-cyan-400',
                limit: 5,
            }
        );

        renderBreakdown(
            browserBreakdown,
            countBy(periodRows, 'browser'),
            {
                barClass: 'bg-emerald-400',
                limit: 5,
            }
        );

        renderBreakdown(
            osBreakdown,
            countBy(periodRows, 'os'),
            {
                barClass: 'bg-fuchsia-500',
                limit: 5,
            }
        );

        renderBreakdown(
            referrerBreakdown,
            countBy(periodRows, 'referrer'),
            {
                barClass: 'bg-cyan-400',
                limit: 5,
                labelFormatter: shortReferrer,
            }
        );

        renderBreakdown(
            countryBreakdown,
            countBy(
                periodRows.filter(row => row.country !== 'Unknown'),
                'country'
            ),
            {
                barClass: 'bg-cyan-400',
                limit: 6,
            }
        );

        renderBreakdown(
            cityBreakdown,
            countBy(
                periodRows.filter(row => row.city !== 'Unknown'),
                'city'
            ),
            {
                barClass: 'bg-emerald-400',
                limit: 6,
            }
        );

        renderBreakdown(
            shortlinkBreakdown,
            countBy(periodRows, 'slug'),
            {
                barClass: 'bg-cyan-400',
                limit: 8,
            }
        );

        renderRecentClicks(periodRows);
    }

    function setLoading(loading) {
        isLoading = loading;
        refreshButton.disabled = loading;
        refreshIcon.classList.toggle('animate-spin', loading);

        analyticsStatus.innerHTML = loading
            ? `
                <span class="h-2 w-2 animate-pulse rounded-full bg-cyan-400"></span>
                <span class="text-xs font-semibold text-cyan-400">
                    Syncing...
                </span>
            `
            : `
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>

                <span class="text-xs font-semibold text-emerald-400">
                    Live Data
                </span>
            `;
    }

    async function loadAnalytics() {
        if (isLoading) {
            return;
        }

        setLoading(true);

        try {
            const response = await fetch(analyticsUrl, {
                headers: {
                    Accept: 'application/json',
                },
            });

            const json = await response.json();

            if (!response.ok || json.success === false) {
                throw new Error(
                    json.message || 'Gagal mengambil data analytics.'
                );
            }

            rawRows = getRowsFromResponse(json);
            normalizedRows = rawRows.map(normalizeRow);

            renderDashboard();
        } catch (error) {
            console.error(error);

            normalizedRows = [];
            renderDashboard();

            analyticsStatus.innerHTML = `
                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                <span class="text-xs font-semibold text-red-400">
                    Gagal memuat data
                </span>
            `;
        } finally {
            setLoading(false);
        }
    }

    periodFilter.addEventListener(
        'change',
        renderDashboard
    );

    clickSearch.addEventListener(
        'input',
        renderDashboard
    );

    refreshButton.addEventListener(
        'click',
        loadAnalytics
    );

    loadAnalytics();
});
</script>
@endpush