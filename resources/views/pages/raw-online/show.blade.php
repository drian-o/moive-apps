@extends('layouts.app')

@section('title', $rawPaste->filename)

@php
    $lines = preg_split('/\r\n|\r|\n/', $rawPaste->content);
    $lineCount = count($lines);
    $rawUrl = route('raw-online.raw', $rawPaste);
    $downloadUrl = route('raw-online.download', $rawPaste);
@endphp

@section('content')
<div
    id="raw-viewer"
    class="relative min-h-[calc(100vh-120px)]"
    data-copy-url="{{ $rawUrl }}"
>
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[620px] overflow-hidden">
        <div class="absolute -left-40 -top-40 h-[420px] w-[420px] rounded-full bg-violet-500/10 blur-3xl"></div>
        <div class="absolute -right-40 top-20 h-[420px] w-[420px] rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-[1700px] px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span class="rounded-full border border-violet-500/20 bg-violet-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-violet-400">
                        {{ $rawPaste->language }}
                    </span>

                    <span class="rounded-full border border-slate-800 bg-slate-900/70 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        {{ $rawPaste->visibility }}
                    </span>
                </div>

                <h1 class="break-all text-2xl font-black text-white sm:text-3xl">
                    {{ $rawPaste->filename }}
                </h1>

                <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-slate-500">
                    <span>{{ number_format($rawPaste->views) }} views</span>
                    <span>{{ number_format($lineCount) }} lines</span>
                    <span>{{ number_format(strlen($rawPaste->content)) }} characters</span>
                    <span>{{ $rawPaste->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <button
                    id="copy-raw-url"
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-xs font-bold text-slate-300 transition hover:border-violet-500/30 hover:bg-violet-500/10 hover:text-violet-300"
                >
                    <x-heroicon-o-clipboard class="h-4 w-4"/>
                    Copy URL
                </button>

                <a
                    href="{{ $rawUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-2.5 text-xs font-bold text-emerald-400 transition hover:bg-emerald-500 hover:text-white"
                >
                    RAW
                </a>

                <a
                    href="{{ $downloadUrl }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-2.5 text-xs font-bold text-white transition hover:from-violet-500 hover:to-fuchsia-500"
                >
                    <x-heroicon-o-arrow-down-tray class="h-4 w-4"/>
                    Download
                </a>
            </div>
        </div>

        {{-- Viewer --}}
        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-[#0b0d12] shadow-2xl shadow-black/40">
            <div class="flex flex-col gap-3 border-b border-slate-800 bg-slate-900/85 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                    </div>

                    <div class="h-5 w-px bg-slate-700"></div>

                    <span class="font-mono text-xs font-bold text-slate-300">
                        {{ $rawPaste->filename }}
                    </span>
                </div>

                <span class="font-mono text-[11px] uppercase text-violet-400">
                    {{ $rawPaste->language }}
                </span>
            </div>

            <div class="max-h-[calc(100vh-250px)] min-h-[560px] overflow-auto">
                <table class="w-full border-collapse font-mono text-sm leading-6">
                    <tbody>
                        @foreach($lines as $index => $line)
                            <tr class="group">
                                <td class="sticky left-0 w-[64px] select-none border-r border-slate-800 bg-[#090b0f] px-3 text-right align-top text-slate-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="whitespace-pre px-4 text-slate-200 group-hover:bg-violet-500/[0.03]">{{ $line }}@if($line === '')&nbsp;@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-2 border-t border-slate-800 bg-slate-900/60 px-4 py-3 text-[11px] text-slate-600 sm:flex-row sm:items-center sm:justify-between">
                <span>
                    RAW disajikan sebagai text/plain dan tidak dieksekusi browser.
                </span>

                <span class="font-mono">
                    /raw/{{ $rawPaste->slug }}
                </span>
            </div>
        </section>
    </div>
</div>

<div
    id="viewer-toast"
    class="pointer-events-none fixed bottom-5 right-5 z-[90] hidden max-w-sm translate-y-4 rounded-2xl border border-emerald-500/20 bg-slate-900/95 p-4 opacity-0 shadow-2xl shadow-black/50 backdrop-blur transition"
>
    <p id="viewer-toast-message" class="text-sm font-semibold text-emerald-300"></p>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const viewer = document.getElementById('raw-viewer');
    const copyButton = document.getElementById('copy-raw-url');

    const toast = document.getElementById('viewer-toast');
    const toastMessage = document.getElementById('viewer-toast-message');

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
        }, 1600);
    }

    copyButton?.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(
                viewer.dataset.copyUrl || ''
            );

            showToast('URL RAW berhasil disalin.');
        } catch {
            showToast('Browser menolak akses clipboard.');
        }
    });
});
</script>
@endpush
