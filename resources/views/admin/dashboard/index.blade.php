@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@php
    $stats = [
        [
            'label' => 'Anime',
            'value' => (int) $animeCount,
            'description' => 'Total koleksi anime',
            'icon' => 'tv',
            'accent' => 'sky',
        ],
        [
            'label' => 'Donghua',
            'value' => (int) $donghuaCount,
            'description' => 'Total koleksi donghua',
            'icon' => 'fire',
            'accent' => 'cyan',
        ],
        [
            'label' => 'Comic',
            'value' => (int) $comicCount,
            'description' => 'Total komik tersedia',
            'icon' => 'book-open',
            'accent' => 'violet',
        ],
        [
            'label' => 'Users',
            'value' => (int) $userCount,
            'description' => 'Pengguna terdaftar',
            'icon' => 'users',
            'accent' => 'emerald',
        ],
        [
            'label' => 'Visitors',
            'value' => (int) $visitorCount,
            'description' => 'Total kunjungan tercatat',
            'icon' => 'cursor-arrow-rays',
            'accent' => 'amber',
        ],
    ];

    $totalContent = (int) $animeCount
        + (int) $donghuaCount
        + (int) $comicCount;

    $contentStats = [
        [
            'label' => 'Anime',
            'value' => (int) $animeCount,
            'bar' => 'bg-sky-400',
            'text' => 'text-sky-400',
        ],
        [
            'label' => 'Donghua',
            'value' => (int) $donghuaCount,
            'bar' => 'bg-cyan-400',
            'text' => 'text-cyan-400',
        ],
        [
            'label' => 'Comic',
            'value' => (int) $comicCount,
            'bar' => 'bg-violet-400',
            'text' => 'text-violet-400',
        ],
    ];

    $systemStatus = [
        [
            'label' => 'PHP Runtime',
            'value' => 'PHP '.PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION,
            'status' => 'Online',
            'accent' => 'violet',
        ],
        [
            'label' => 'Framework',
            'value' => 'Laravel '.app()->version(),
            'status' => 'Ready',
            'accent' => 'red',
        ],
        [
            'label' => 'Database',
            'value' => strtoupper(config('database.default', 'mysql')),
            'status' => 'Connected',
            'accent' => 'emerald',
        ],
        [
            'label' => 'Environment',
            'value' => strtoupper(app()->environment()),
            'status' => config('app.debug') ? 'Debug On' : 'Stable',
            'accent' => 'sky',
        ],
    ];
@endphp

@section('content')
<div
    id="dashboard-app"
    class="mx-auto w-full max-w-[1600px]"
>
    {{-- Hero --}}
    <section class="relative mb-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-sky-500/10 blur-3xl"></div>
            <div class="absolute -bottom-32 right-0 h-80 w-80 rounded-full bg-violet-500/10 blur-3xl"></div>

            <div
                class="absolute inset-0 opacity-[0.025]"
                style="
                    background-image:
                        linear-gradient(rgba(255,255,255,.6) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,.6) 1px, transparent 1px);
                    background-size: 34px 34px;
                "
            ></div>
        </div>

        <div class="relative flex flex-col gap-6 px-6 py-7 lg:flex-row lg:items-center lg:justify-between lg:px-8 lg:py-9">
            <div class="max-w-3xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1.5">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>

                    <span class="text-[11px] font-bold uppercase tracking-[0.14em] text-emerald-400">
                        System Online
                    </span>
                </div>

                <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                    Selamat datang kembali,
                    <span class="bg-gradient-to-r from-sky-400 via-cyan-400 to-violet-400 bg-clip-text text-transparent">
                        Administrator.
                    </span>
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-400">
                    Pantau koleksi konten, pengguna, pengunjung, dan kondisi sistem dari satu dashboard.
                </p>
            </div>

            <div class="grid min-w-[280px] grid-cols-2 gap-3">
                <div class="rounded-2xl border border-slate-700/80 bg-slate-950/45 p-4 backdrop-blur">
                    <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                        Hari Ini
                    </p>

                    <p class="mt-2 text-sm font-black text-white">
                        {{ now()->translatedFormat('d M Y') }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-700/80 bg-slate-950/45 p-4 backdrop-blur">
                    <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                        Waktu Lokal
                    </p>

                    <p
                        id="dashboard-clock"
                        class="mt-2 text-sm font-black text-cyan-400"
                    >
                        {{ now()->format('H:i:s') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach($stats as $stat)
            @php
                $cardBorder = match($stat['accent']) {
                    'cyan' => 'hover:border-cyan-500/35',
                    'violet' => 'hover:border-violet-500/35',
                    'emerald' => 'hover:border-emerald-500/35',
                    'amber' => 'hover:border-amber-500/35',
                    default => 'hover:border-sky-500/35',
                };

                $iconWrap = match($stat['accent']) {
                    'cyan' => 'bg-cyan-500/10 text-cyan-400 group-hover:bg-cyan-500',
                    'violet' => 'bg-violet-500/10 text-violet-400 group-hover:bg-violet-500',
                    'emerald' => 'bg-emerald-500/10 text-emerald-400 group-hover:bg-emerald-500',
                    'amber' => 'bg-amber-500/10 text-amber-400 group-hover:bg-amber-500',
                    default => 'bg-sky-500/10 text-sky-400 group-hover:bg-sky-500',
                };

                $glow = match($stat['accent']) {
                    'cyan' => 'bg-cyan-500/10',
                    'violet' => 'bg-violet-500/10',
                    'emerald' => 'bg-emerald-500/10',
                    'amber' => 'bg-amber-500/10',
                    default => 'bg-sky-500/10',
                };
            @endphp

            <article class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-5 shadow-lg shadow-black/10 transition duration-300 hover:-translate-y-1 {{ $cardBorder }}">
                <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full {{ $glow }} blur-2xl"></div>

                <div class="relative flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                            {{ $stat['label'] }}
                        </p>

                        <p
                            class="count-up mt-3 text-3xl font-black tracking-tight text-white"
                            data-value="{{ $stat['value'] }}"
                        >
                            {{ number_format($stat['value']) }}
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-500">
                            {{ $stat['description'] }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition group-hover:text-white {{ $iconWrap }}">
                        @switch($stat['icon'])
                            @case('fire')
                                <x-heroicon-o-fire class="h-5 w-5"/>
                                @break

                            @case('book-open')
                                <x-heroicon-o-book-open class="h-5 w-5"/>
                                @break

                            @case('users')
                                <x-heroicon-o-users class="h-5 w-5"/>
                                @break

                            @case('cursor-arrow-rays')
                                <x-heroicon-o-cursor-arrow-rays class="h-5 w-5"/>
                                @break

                            @default
                                <x-heroicon-o-tv class="h-5 w-5"/>
                        @endswitch
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Main overview --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.25fr)_minmax(360px,.75fr)]">
        {{-- Content overview --}}
        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/15">
            <div class="flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/10">
                        <x-heroicon-o-chart-bar-square class="h-5 w-5 text-sky-400"/>
                    </div>

                    <div>
                        <h2 class="font-black text-white">
                            Content Overview
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Distribusi koleksi konten yang tersedia.
                        </p>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-right">
                    <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                        Total Konten
                    </p>

                    <p class="mt-1 text-lg font-black text-white">
                        {{ number_format($totalContent) }}
                    </p>
                </div>
            </div>

            <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-[minmax(0,1fr)_220px]">
                <div class="space-y-5">
                    @foreach($contentStats as $item)
                        @php
                            $percentage = $totalContent > 0
                                ? round(($item['value'] / $totalContent) * 100)
                                : 0;
                        @endphp

                        <div>
                            <div class="mb-2 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full {{ $item['bar'] }}"></span>

                                    <span class="text-sm font-semibold text-slate-400">
                                        {{ $item['label'] }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold {{ $item['text'] }}">
                                        {{ $percentage }}%
                                    </span>

                                    <span class="min-w-[55px] text-right text-sm font-black text-white">
                                        {{ number_format($item['value']) }}
                                    </span>
                                </div>
                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                                <div
                                    class="dashboard-progress h-full rounded-full {{ $item['bar'] }} transition-all duration-700"
                                    data-width="{{ $percentage }}"
                                    style="width: 0%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-col justify-center rounded-2xl border border-slate-800 bg-slate-950/45 p-5 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500/20 to-violet-500/20">
                        <x-heroicon-o-circle-stack class="h-7 w-7 text-sky-400"/>
                    </div>

                    <p class="mt-4 text-3xl font-black text-white">
                        {{ number_format($totalContent) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Item dalam library
                    </p>

                    <div class="mt-5 grid grid-cols-3 gap-2">
                        @foreach($contentStats as $item)
                            <div class="rounded-xl bg-slate-900 p-2">
                                <p class="text-xs font-black {{ $item['text'] }}">
                                    {{ number_format($item['value']) }}
                                </p>

                                <p class="mt-1 truncate text-[9px] uppercase tracking-wider text-slate-600">
                                    {{ $item['label'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- Visitors --}}
        <section class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/15">
            <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>

            <div class="relative flex h-full flex-col p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-amber-400">
                            Audience
                        </p>

                        <h2 class="mt-2 text-xl font-black text-white">
                            Visitor Summary
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Ringkasan trafik dan pertumbuhan audiens platform.
                        </p>
                    </div>

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-400">
                        <x-heroicon-o-arrow-trending-up class="h-6 w-6"/>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-sm font-semibold text-slate-500">
                        Total Visitors
                    </p>

                    <p
                        class="count-up mt-2 text-5xl font-black tracking-tight text-white"
                        data-value="{{ (int) $visitorCount }}"
                    >
                        {{ number_format($visitorCount) }}
                    </p>
                </div>

                <div class="mt-auto pt-8">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/45 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Users
                            </p>

                            <p class="mt-2 text-xl font-black text-emerald-400">
                                {{ number_format($userCount) }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/45 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Ratio
                            </p>

                            <p class="mt-2 text-xl font-black text-cyan-400">
                                {{ $visitorCount > 0
                                    ? number_format(($userCount / $visitorCount) * 100, 1)
                                    : '0.0'
                                }}%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Bottom panels --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        {{-- Recent activity --}}
        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/15">
            <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10">
                        <x-heroicon-o-bolt class="h-5 w-5 text-emerald-400"/>
                    </div>

                    <div>
                        <h2 class="font-black text-white">
                            Recent Activity
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Status aktivitas sistem terbaru.
                        </p>
                    </div>
                </div>

                <span class="rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                    Live
                </span>
            </div>

            <div class="divide-y divide-slate-800">
                @foreach([
                    [
                        'title' => 'Admin Login',
                        'description' => 'Sesi administrator aktif dan terverifikasi.',
                        'icon' => 'user',
                        'accent' => 'sky',
                    ],
                    [
                        'title' => 'Database Connected',
                        'description' => 'Koneksi database tersedia untuk aplikasi.',
                        'icon' => 'database',
                        'accent' => 'emerald',
                    ],
                    [
                        'title' => 'API Ready',
                        'description' => 'Layanan API siap menerima permintaan.',
                        'icon' => 'api',
                        'accent' => 'violet',
                    ],
                    [
                        'title' => 'System Online',
                        'description' => 'Seluruh layanan utama berjalan normal.',
                        'icon' => 'system',
                        'accent' => 'amber',
                    ],
                ] as $activity)
                    @php
                        $activityClass = match($activity['accent']) {
                            'emerald' => 'bg-emerald-500/10 text-emerald-400',
                            'violet' => 'bg-violet-500/10 text-violet-400',
                            'amber' => 'bg-amber-500/10 text-amber-400',
                            default => 'bg-sky-500/10 text-sky-400',
                        };
                    @endphp

                    <div class="flex items-center gap-4 px-5 py-4 transition hover:bg-slate-800/35 sm:px-6">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $activityClass }}">
                            @switch($activity['icon'])
                                @case('database')
                                    <x-heroicon-o-circle-stack class="h-5 w-5"/>
                                    @break

                                @case('api')
                                    <x-heroicon-o-code-bracket class="h-5 w-5"/>
                                    @break

                                @case('system')
                                    <x-heroicon-o-server-stack class="h-5 w-5"/>
                                    @break

                                @default
                                    <x-heroicon-o-user-circle class="h-5 w-5"/>
                            @endswitch
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-200">
                                {{ $activity['title'] }}
                            </p>

                            <p class="mt-1 truncate text-xs text-slate-500">
                                {{ $activity['description'] }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            <span class="hidden text-[10px] font-bold uppercase tracking-wider text-emerald-400 sm:inline">
                                Active
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Server status --}}
        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/15">
            <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/10">
                        <x-heroicon-o-server-stack class="h-5 w-5 text-violet-400"/>
                    </div>

                    <div>
                        <h2 class="font-black text-white">
                            Server Status
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Runtime dan layanan aplikasi.
                        </p>
                    </div>
                </div>

                <button
                    id="refresh-server-status"
                    type="button"
                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-700 bg-slate-950/60 text-slate-500 transition hover:border-violet-500/30 hover:bg-violet-500/10 hover:text-violet-400"
                    title="Refresh status"
                >
                    <x-heroicon-o-arrow-path
                        id="server-refresh-icon"
                        class="h-4 w-4"
                    />
                </button>
            </div>

            <div class="grid gap-3 p-5 sm:grid-cols-2 sm:p-6">
                @foreach($systemStatus as $item)
                    @php
                        $systemAccent = match($item['accent']) {
                            'red' => 'bg-red-500/10 text-red-400',
                            'emerald' => 'bg-emerald-500/10 text-emerald-400',
                            'sky' => 'bg-sky-500/10 text-sky-400',
                            default => 'bg-violet-500/10 text-violet-400',
                        };
                    @endphp

                    <div class="rounded-2xl border border-slate-800 bg-slate-950/45 p-4 transition hover:border-slate-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                    {{ $item['label'] }}
                                </p>

                                <p class="mt-2 text-sm font-black text-white">
                                    {{ $item['value'] }}
                                </p>
                            </div>

                            <span class="flex h-9 w-9 items-center justify-center rounded-xl {{ $systemAccent }}">
                                <x-heroicon-o-check-circle class="h-5 w-5"/>
                            </span>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">
                                {{ $item['status'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    {{-- Footer info --}}
    <div class="mt-6 flex flex-col gap-2 rounded-2xl border border-slate-800 bg-slate-900/70 px-5 py-4 text-xs text-slate-600 sm:flex-row sm:items-center sm:justify-between">
        <span>
            Dashboard diperbarui secara realtime dari data aplikasi.
        </span>

        <span>
            Environment:
            <strong class="font-bold text-slate-400">
                {{ strtoupper(app()->environment()) }}
            </strong>
        </span>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const clock =
        document.getElementById('dashboard-clock');

    const refreshButton =
        document.getElementById('refresh-server-status');

    const refreshIcon =
        document.getElementById('server-refresh-icon');

    function updateClock() {
        if (!clock) {
            return;
        }

        clock.textContent = new Intl.DateTimeFormat(
            'id-ID',
            {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
            }
        ).format(new Date());
    }

    document
        .querySelectorAll('.dashboard-progress')
        .forEach((bar, index) => {
            setTimeout(() => {
                bar.style.width =
                    `${bar.dataset.width || 0}%`;
            }, 100 + (index * 100));
        });

    refreshButton?.addEventListener('click', () => {
        refreshIcon.classList.add('animate-spin');
        refreshButton.disabled = true;

        setTimeout(() => {
            refreshIcon.classList.remove('animate-spin');
            refreshButton.disabled = false;
        }, 700);
    });

    updateClock();
    setInterval(updateClock, 1000);
});
</script>
@endpush