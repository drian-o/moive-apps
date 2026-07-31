@extends('layouts.admin')

@section('title', 'Raw Online')
@section('page-title', 'Raw Online')

@php
    $pageItems = $pastes->getCollection();

    $publicCount = $pageItems->where('visibility', 'public')->count();
    $unlistedCount = $pageItems->where('visibility', 'unlisted')->count();
    $privateCount = $pageItems->where('visibility', 'private')->count();
@endphp

@section('content')
<div class="mx-auto w-full max-w-[1600px]">
    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-fuchsia-500 via-violet-500 to-indigo-600 shadow-lg shadow-violet-950/40">
                    <x-heroicon-o-code-bracket class="relative z-10 h-6 w-6 text-white"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Raw Online
                    </h1>

                    <p class="text-sm text-slate-500">
                        Paste & Code Sharing Management
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Simpan kode atau teks, bagikan melalui URL viewer, RAW, dan download.
            </p>
        </div>

        <a
            href="{{ route('admin.raw-online.create') }}"
            class="group relative inline-flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-fuchsia-600 to-violet-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-violet-950/40 transition hover:-translate-y-0.5 hover:from-fuchsia-500 hover:to-violet-500"
        >
            <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>
            <x-heroicon-o-plus class="relative h-5 w-5"/>
            <span class="relative">Buat Paste & Domain Extrator</span>
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500/15">
                <x-heroicon-o-check-circle class="h-5 w-5 text-emerald-400"/>
            </div>

            <div>
                <p class="text-sm font-bold text-emerald-300">Berhasil</p>
                <p class="mt-1 text-sm text-emerald-200/70">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Stats --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Total Paste
                    </p>

                    <p class="mt-3 text-3xl font-black text-white">
                        {{ number_format($pastes->total()) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Seluruh data tersimpan
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400">
                    <x-heroicon-o-document-duplicate class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Public
                    </p>

                    <p class="mt-3 text-3xl font-black text-emerald-400">
                        {{ $publicCount }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Pada halaman ini
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                    <x-heroicon-o-globe-alt class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Unlisted
                    </p>

                    <p class="mt-3 text-3xl font-black text-amber-400">
                        {{ $unlistedCount }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Hanya melalui URL
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                    <x-heroicon-o-link class="h-5 w-5"/>
                </div>
            </div>
        </article>

        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">
                        Private
                    </p>

                    <p class="mt-3 text-3xl font-black text-red-400">
                        {{ $privateCount }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Hanya administrator
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-500/10 text-red-400">
                    <x-heroicon-o-lock-closed class="h-5 w-5"/>
                </div>
            </div>
        </article>
    </div>

    {{-- Table --}}
    <section class="mt-6 overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
        <div class="flex flex-col gap-4 border-b border-slate-800 px-5 py-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-black text-white">Daftar Paste</h2>
                <p class="mt-1 text-xs text-slate-500">
                    Cari, buka, edit, atau hapus paste.
                </p>
            </div>

            <form
                action="{{ route('admin.raw-online.index') }}"
                method="GET"
                class="flex flex-col gap-2 sm:flex-row"
            >
                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 group-focus-within:text-violet-400"/>
                    </div>

                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari filename atau slug..."
                        class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-4 text-xs text-white outline-none placeholder:text-slate-600 focus:border-violet-500/70 sm:w-64"
                    >
                </div>

                <select
                    name="visibility"
                    class="rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-xs font-semibold text-slate-300 outline-none focus:border-violet-500"
                >
                    <option value="">Semua Visibility</option>
                    <option value="public" @selected(request('visibility') === 'public')>Public</option>
                    <option value="unlisted" @selected(request('visibility') === 'unlisted')>Unlisted</option>
                    <option value="private" @selected(request('visibility') === 'private')>Private</option>
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-800 px-4 py-2.5 text-xs font-bold text-slate-300 transition hover:bg-slate-700 hover:text-white"
                >
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-950/55">
                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            File
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Language
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Visibility
                        </th>

                        <th class="px-5 py-4 text-center text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Views
                        </th>

                        <th class="px-5 py-4 text-left text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Expired
                        </th>

                        <th class="px-5 py-4 text-right text-[10px] font-bold uppercase tracking-[0.16em] text-slate-600">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-800">
                    @forelse($pastes as $paste)
                        @php
                            $isExpired = $paste->isExpired();

                            $visibilityClass = match($paste->visibility) {
                                'public' => 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400',
                                'private' => 'border-red-500/20 bg-red-500/10 text-red-400',
                                default => 'border-amber-500/20 bg-amber-500/10 text-amber-400',
                            };
                        @endphp

                        <tr class="group transition hover:bg-slate-800/35">
                            <td class="min-w-[300px] px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400">
                                        <x-heroicon-o-code-bracket-square class="h-5 w-5"/>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate font-bold text-slate-200">
                                            {{ $paste->filename }}
                                        </p>

                                        <button
                                            type="button"
                                            class="copy-value mt-1 inline-flex max-w-full items-center gap-1.5 font-mono text-[11px] text-slate-600 transition hover:text-violet-400"
                                            data-copy="{{ route('raw-online.raw', $paste) }}"
                                        >
                                            <span class="truncate">/{{ $paste->slug }}</span>
                                            <x-heroicon-o-clipboard class="h-3.5 w-3.5 shrink-0"/>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="rounded-lg border border-slate-700 bg-slate-950/60 px-2.5 py-1 font-mono text-[11px] text-slate-400">
                                    {{ $paste->language }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex rounded-full border px-3 py-1 text-[10px] font-bold uppercase tracking-wider {{ $visibilityClass }}">
                                    {{ $paste->visibility }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center font-black text-slate-300">
                                {{ number_format($paste->views) }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-xs">
                                @if($isExpired)
                                    <span class="font-bold text-red-400">Expired</span>
                                @elseif($paste->expires_at)
                                    <span class="text-slate-400">
                                        {{ $paste->expires_at->format('d M Y, H:i') }}
                                    </span>
                                @else
                                    <span class="text-slate-600">Never</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                        @if($paste->visibility !== 'private' && !$isExpired)
                            {{-- Viewer --}}
                            <a
                                href="{{ route('raw-online.show', $paste) }}"
                                target="_blank"
                                rel="noopener"
                                class="flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                                title="Viewer"
                            >
                                <x-heroicon-o-eye class="h-4 w-4"/>
                            </a>

                            {{-- RAW --}}
                            <a
                                href="{{ route('raw-online.raw', $paste) }}"
                                target="_blank"
                                rel="noopener"
                                class="flex h-9 items-center justify-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 text-[10px] font-black text-emerald-400 transition hover:bg-emerald-500 hover:text-white"
                            >
                                RAW
                            </a>
                        @endif

                        {{-- Domain Extractor --}}
                        <a
                            href="{{ route('admin.raw-online.extractor', $paste) }}"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                            title="Domain Extractor"
                        >
                            <x-heroicon-o-globe-alt class="h-4 w-4"/>
                        </a>

                        {{-- Edit --}}
                        <a
                            href="{{ route('admin.raw-online.edit', $paste) }}"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-blue-400 transition hover:bg-blue-500 hover:text-white"
                            title="Edit"
                        >
                            <x-heroicon-o-pencil-square class="h-4 w-4"/>
                        </a>

                                    <form
                                        action="{{ route('admin.raw-online.destroy', $paste) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus paste {{ addslashes($paste->filename) }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400 transition hover:bg-red-500 hover:text-white"
                                            title="Hapus"
                                        >
                                            <x-heroicon-o-trash class="h-4 w-4"/>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                                    <x-heroicon-o-code-bracket class="h-8 w-8 text-slate-500"/>
                                </div>

                                <h3 class="mt-4 text-base font-bold text-slate-300">
                                    Belum ada paste
                                </h3>

                                <p class="mt-2 text-sm text-slate-600">
                                    Buat paste pertama untuk mulai membagikan kode.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-2 border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-xs text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span>
                Menampilkan {{ $pastes->count() }} dari {{ $pastes->total() }} paste
            </span>

            <span>
                Halaman {{ $pastes->currentPage() }} dari {{ $pastes->lastPage() }}
            </span>
        </div>
    </section>

    @if($pastes->hasPages())
        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-900/70 p-4">
            {{ $pastes->onEachSide(1)->links() }}
        </div>
    @endif
</div>

{{-- Toast --}}
<div
    id="raw-toast"
    class="pointer-events-none fixed bottom-5 right-5 z-[90] hidden max-w-sm translate-y-4 rounded-2xl border border-emerald-500/20 bg-slate-900/95 p-4 opacity-0 shadow-2xl shadow-black/50 backdrop-blur transition"
>
    <p id="raw-toast-message" class="text-sm font-semibold text-emerald-300"></p>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('raw-toast');
    const toastMessage = document.getElementById('raw-toast-message');

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

    document.querySelectorAll('.copy-value').forEach(button => {
        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.copy || '');
                showToast('URL RAW berhasil disalin.');
            } catch {
                showToast('Browser menolak akses clipboard.');
            }
        });
    });
});
</script>
@endpush
