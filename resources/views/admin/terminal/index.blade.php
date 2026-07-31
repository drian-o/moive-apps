@extends('layouts.admin')

@section('title', 'Terminal')

@section('content')
<div class="mx-auto w-full max-w-[1600px]">

    {{-- Page heading --}}
    <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <div class="mb-1 flex items-center gap-2">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg border border-blue-500/20 bg-blue-500/10">
                    <svg
                        class="h-5 w-5 text-blue-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 9l3 3-3 3m5 0h3M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                        />
                    </svg>
                </div>

                <h1 class="text-xl font-bold tracking-tight text-white">
                    Web Terminal
                </h1>
            </div>

            <p class="text-sm text-slate-400">
                Kelola project langsung melalui terminal server.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <div class="rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2">
                <span class="text-xs text-slate-500">Environment</span>
                <span class="ml-2 text-xs font-semibold text-emerald-400">
                    {{ app()->environment() }}
                </span>
            </div>

            <div class="rounded-lg border border-slate-700 bg-slate-900/80 px-3 py-2">
                <span class="text-xs text-slate-500">Shell</span>
                <span class="ml-2 text-xs font-semibold text-blue-400">
                    PowerShell
                </span>
            </div>
        </div>
    </div>

    {{-- Terminal window --}}
    <div
        class="overflow-hidden rounded-2xl border border-slate-700/80 bg-slate-900 shadow-2xl shadow-black/30"
    >
        {{-- Window title bar --}}
        <div class="flex min-h-[62px] items-center justify-between border-b border-slate-700/80 bg-slate-900 px-5">

            <div class="flex min-w-0 items-center gap-4">
                {{-- Window dots --}}
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="h-3 w-3 rounded-full bg-red-500 shadow-sm shadow-red-500/30"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400 shadow-sm shadow-amber-400/30"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/30"></span>
                </div>

                <div class="hidden h-6 w-px bg-slate-700 sm:block"></div>

                {{-- Current location --}}
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <svg
                            class="h-4 w-4 shrink-0 text-slate-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"
                            />
                        </svg>

                        <span class="text-sm font-semibold text-slate-200">
                            Project Terminal
                        </span>
                    </div>

                    <p
                        class="mt-0.5 max-w-[280px] truncate font-mono text-xs text-slate-500 sm:max-w-[500px] lg:max-w-[750px]"
                        title="{{ base_path() }}"
                    >
                        {{ base_path() }}
                    </p>
                </div>
            </div>

            {{-- Connection status --}}
            <div class="flex shrink-0 items-center gap-2 rounded-full border border-slate-700 bg-slate-950/60 px-3 py-1.5">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-50"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                </span>

                <span
                    id="connection-status"
                    class="text-xs font-semibold text-blue-400"
                >
                    Connecting...
                </span>
            </div>
        </div>

        {{-- Information bar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-800 bg-slate-950/60 px-5 py-2.5">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <svg
                    class="h-4 w-4 text-blue-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>

                <span>
                    Perintah dijalankan dari folder project aktif.
                </span>
            </div>

            <div class="hidden items-center gap-3 text-[11px] text-slate-600 md:flex">
                <span>
                    <kbd class="rounded border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-slate-400">
                        Ctrl
                    </kbd>
                    +
                    <kbd class="rounded border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-slate-400">
                        C
                    </kbd>
                    hentikan proses
                </span>

                <span class="h-3 w-px bg-slate-700"></span>

                <span>
                    <kbd class="rounded border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-slate-400">
                        ↑
                    </kbd>
                    riwayat perintah
                </span>
            </div>
        </div>

        {{-- Terminal body --}}
        <div class="relative bg-[#030712] p-2 sm:p-4">
            {{-- Subtle background decoration --}}
            <div
                class="pointer-events-none absolute inset-0 opacity-[0.035]"
                style="
                    background-image:
                        linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px);
                    background-size: 24px 24px;
                "
            ></div>

            <div
                id="terminal"
                class="relative h-[calc(100vh-300px)] min-h-[540px] w-full overflow-hidden rounded-xl border border-slate-800 bg-black p-2 shadow-inner shadow-black"
            ></div>
        </div>

        {{-- Footer --}}
        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-800 bg-slate-900 px-5 py-3">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Laravel Project
            </div>

            <div class="font-mono text-[11px] text-slate-600">
                UTF-8 · xterm-256color
            </div>
        </div>
    </div>

    {{-- Warning --}}
    <div class="mt-4 flex items-start gap-3 rounded-xl border border-amber-500/15 bg-amber-500/5 px-4 py-3">
        <svg
            class="mt-0.5 h-4 w-4 shrink-0 text-amber-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.8"
                d="M12 9v2m0 4h.01M10.3 3.9L2.8 17a2 2 0 001.7 3h15a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"
            />
        </svg>

        <p class="text-xs leading-5 text-amber-200/70">
            Terminal memiliki akses untuk menjalankan perintah pada server.
            Pastikan halaman ini hanya dapat diakses oleh administrator.
        </p>
    </div>
</div>

@vite('resources/js/terminal.js')
@endsection