@extends('layouts.admin')

@section('title', 'Domain Extractor')
@section('page-title', 'Domain Extractor')

@section('content')
<div id="domain-extractor" class="mx-auto w-full max-w-[1600px]">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 shadow-lg shadow-cyan-950/40">
                    <x-heroicon-o-globe-alt class="h-6 w-6 text-white"/>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">Domain Extractor</h1>
                    <p class="text-sm text-slate-500">{{ $rawPaste->filename }} · {{ $rawPaste->slug }}</p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Ambil seluruh URL dan domain unik dari isi Raw Paste tanpa mengubah data aslinya.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('raw-online.raw', $rawPaste) }}" target="_blank" class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-400 transition hover:bg-emerald-500 hover:text-white">RAW</a>

            <a href="{{ route('admin.raw-online.edit', $rawPaste) }}" class="inline-flex items-center gap-2 rounded-xl border border-violet-500/20 bg-violet-500/10 px-4 py-3 text-sm font-bold text-violet-400 transition hover:bg-violet-500 hover:text-white">
                <x-heroicon-o-pencil-square class="h-4 w-4"/> Edit Paste
            </a>

            <a href="{{ route('admin.raw-online.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-bold text-slate-300 transition hover:bg-slate-800 hover:text-white">
                <x-heroicon-o-arrow-left class="h-4 w-4"/> Kembali
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['id' => 'total-url', 'label' => 'Total URL', 'caption' => 'Semua URL ditemukan', 'class' => 'text-white'],
            ['id' => 'unique-domain', 'label' => 'Domain Unik', 'caption' => 'Hostname berbeda', 'class' => 'text-cyan-400'],
            ['id' => 'https-total', 'label' => 'HTTPS', 'caption' => 'Koneksi aman', 'class' => 'text-emerald-400'],
            ['id' => 'http-total', 'label' => 'HTTP', 'caption' => 'Tanpa HTTPS', 'class' => 'text-amber-400'],
        ] as $card)
            <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">{{ $card['label'] }}</p>
                <p id="{{ $card['id'] }}" class="mt-3 text-3xl font-black {{ $card['class'] }}">0</p>
                <p class="mt-1 text-xs text-slate-500">{{ $card['caption'] }}</p>
            </article>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1.15fr)_minmax(380px,.85fr)]">
        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-[#0b0d12] shadow-2xl shadow-black/30">
            <div class="flex items-center justify-between border-b border-slate-800 bg-slate-900/85 px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="flex gap-2">
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                    </div>
                    <span class="h-5 w-px bg-slate-700"></span>
                    <span class="font-mono text-xs font-bold text-slate-300">{{ $rawPaste->filename }}</span>
                </div>

                <span class="rounded-md bg-slate-800 px-2 py-1 font-mono text-[10px] font-bold uppercase text-violet-400">{{ $rawPaste->language }}</span>
            </div>

            <textarea id="extract-source" spellcheck="false" wrap="off" class="min-h-[650px] w-full resize-none overflow-auto bg-[#0b0d12] px-5 py-5 font-mono text-sm leading-6 text-slate-200 outline-none selection:bg-cyan-500/25">{{ $rawPaste->content }}</textarea>

            <div class="flex flex-col gap-3 border-t border-slate-800 bg-slate-900/60 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex gap-4 text-[11px] text-slate-600">
                    <span><b id="source-lines" class="font-semibold text-slate-400">0</b> baris</span>
                    <span><b id="source-chars" class="font-semibold text-slate-400">0</b> karakter</span>
                </div>

                <button id="extract-button" type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-cyan-600 to-sky-600 px-5 py-2.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:from-cyan-500 hover:to-sky-500">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4"/> Extract Domain
                </button>
            </div>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
            <div class="flex flex-col gap-3 border-b border-slate-800 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-black text-white">Hasil Extractor</h2>
                    <p class="mt-1 text-xs text-slate-500">Diurutkan berdasarkan jumlah kemunculan.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button id="copy-domains" type="button" disabled class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-xs font-bold text-slate-400 transition hover:text-cyan-400 disabled:cursor-not-allowed disabled:opacity-40">
                        <x-heroicon-o-clipboard class="h-4 w-4"/> Copy Domain
                    </button>

                    <button id="copy-urls" type="button" disabled class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-2 text-xs font-bold text-slate-400 transition hover:text-violet-400 disabled:cursor-not-allowed disabled:opacity-40">
                        <x-heroicon-o-link class="h-4 w-4"/> Copy URL
                    </button>

                    <button id="export-result" type="button" disabled class="inline-flex items-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs font-bold text-emerald-400 transition hover:bg-emerald-500 hover:text-white disabled:cursor-not-allowed disabled:opacity-40">
                        <x-heroicon-o-arrow-down-tray class="h-4 w-4"/> Export
                    </button>
                </div>
            </div>

            <div class="border-b border-slate-800 p-4">
                <input id="domain-search" type="search" placeholder="Cari domain..." class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-2.5 text-xs text-white outline-none placeholder:text-slate-600 focus:border-cyan-500/60">
            </div>

            <div class="max-h-[625px] overflow-y-auto">
                <div id="empty-result" class="px-6 py-20 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800">
                        <x-heroicon-o-globe-alt class="h-8 w-8 text-slate-500"/>
                    </div>
                    <h3 class="mt-4 font-bold text-slate-300">Belum ada hasil</h3>
                    <p class="mt-2 text-sm text-slate-600">Klik Extract Domain untuk memulai.</p>
                </div>

                <div id="domain-list" class="hidden divide-y divide-slate-800"></div>
            </div>

            <div class="flex items-center justify-between border-t border-slate-800 bg-slate-950/30 px-5 py-3 text-[11px] text-slate-600">
                <span id="result-summary">0 domain ditemukan</span>
                <span>Client-side extractor</span>
            </div>
        </section>
    </div>
</div>

<div id="extract-toast" class="pointer-events-none fixed bottom-5 right-5 z-[90] hidden translate-y-4 rounded-2xl border border-emerald-500/20 bg-slate-900/95 p-4 opacity-0 shadow-2xl shadow-black/50 backdrop-blur transition">
    <p id="extract-toast-message" class="text-sm font-semibold text-emerald-300"></p>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const source = document.getElementById('extract-source');
    const list = document.getElementById('domain-list');
    const empty = document.getElementById('empty-result');
    const search = document.getElementById('domain-search');

    const copyDomains = document.getElementById('copy-domains');
    const copyUrls = document.getElementById('copy-urls');
    const exportResult = document.getElementById('export-result');

    let urls = [];
    let domains = [];

    const escapeHtml = value => {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    };

    const copyText = async value => {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(value);
            return;
        }

        const textarea = document.createElement('textarea');
        textarea.value = value;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        textarea.remove();
    };

    const toast = message => {
        const box = document.getElementById('extract-toast');
        document.getElementById('extract-toast-message').textContent = message;
        box.classList.remove('hidden');

        requestAnimationFrame(() => box.classList.remove('translate-y-4', 'opacity-0'));

        setTimeout(() => {
            box.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => box.classList.add('hidden'), 200);
        }, 1600);
    };

    const updateSourceStats = () => {
        document.getElementById('source-lines').textContent = source.value.split('\n').length.toLocaleString('id-ID');
        document.getElementById('source-chars').textContent = source.value.length.toLocaleString('id-ID');
    };

    const extractUrls = content => (content.match(/https?:\/\/[^\s"'<>`\\]+/gi) || [])
        .map(value => value.replace(/&amp;/gi, '&').replace(/[),.;]+$/g, '').trim())
        .filter(value => {
            try {
                const parsed = new URL(value);
                return parsed.protocol === 'http:' || parsed.protocol === 'https:';
            } catch {
                return false;
            }
        });

    const groupDomains = values => {
        const map = new Map();

        values.forEach(url => {
            const parsed = new URL(url);
            const domain = parsed.hostname.toLowerCase();

            if (!map.has(domain)) {
                map.set(domain, { domain, count: 0, urls: [] });
            }

            const item = map.get(domain);
            item.count++;

            if (!item.urls.includes(url)) {
                item.urls.push(url);
            }
        });

        return Array.from(map.values()).sort((a, b) => b.count - a.count || a.domain.localeCompare(b.domain));
    };

    const render = () => {
        const keyword = search.value.trim().toLowerCase();
        const filtered = domains.filter(item => !keyword || item.domain.includes(keyword));

        list.innerHTML = filtered.length
            ? filtered.map((item, index) => `
                <article class="p-4 transition hover:bg-slate-800/35">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 font-mono text-xs font-black text-cyan-400">${index + 1}</div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <button type="button" data-domain="${escapeHtml(item.domain)}" class="copy-domain min-w-0 truncate text-left font-mono text-sm font-bold text-slate-200 transition hover:text-cyan-400">${escapeHtml(item.domain)}</button>
                                <span class="shrink-0 rounded-full border border-violet-500/20 bg-violet-500/10 px-2.5 py-1 text-[10px] font-black text-violet-400">${item.count} URL</span>
                            </div>
                            <p class="mt-2 truncate font-mono text-[11px] text-slate-600">${escapeHtml(item.urls[0] || '')}</p>
                        </div>
                    </div>
                </article>
            `).join('')
            : '<div class="px-6 py-16 text-center text-sm text-slate-600">Domain tidak ditemukan.</div>';

        document.getElementById('result-summary').textContent = `${filtered.length.toLocaleString('id-ID')} domain ditampilkan`;

        document.querySelectorAll('.copy-domain').forEach(button => {
            button.addEventListener('click', async () => {
                await copyText(button.dataset.domain || '');
                toast('Domain berhasil disalin.');
            });
        });
    };

    const extract = () => {
        urls = extractUrls(source.value);
        domains = groupDomains(urls);

        document.getElementById('total-url').textContent = urls.length.toLocaleString('id-ID');
        document.getElementById('unique-domain').textContent = domains.length.toLocaleString('id-ID');
        document.getElementById('https-total').textContent = urls.filter(url => url.startsWith('https://')).length.toLocaleString('id-ID');
        document.getElementById('http-total').textContent = urls.filter(url => url.startsWith('http://')).length.toLocaleString('id-ID');

        const found = domains.length > 0;
        empty.classList.toggle('hidden', found);
        list.classList.toggle('hidden', !found);
        copyDomains.disabled = !found;
        copyUrls.disabled = urls.length === 0;
        exportResult.disabled = !found;

        render();
        toast(found ? `${domains.length} domain berhasil ditemukan.` : 'Tidak ada URL yang ditemukan.');
    };

    document.getElementById('extract-button').addEventListener('click', extract);
    source.addEventListener('input', updateSourceStats);
    search.addEventListener('input', render);

    copyDomains.addEventListener('click', async () => {
        await copyText(domains.map(item => item.domain).join('\n'));
        toast('Semua domain berhasil disalin.');
    });

    copyUrls.addEventListener('click', async () => {
        await copyText(Array.from(new Set(urls)).join('\n'));
        toast('Semua URL berhasil disalin.');
    });

    exportResult.addEventListener('click', () => {
        const content = ['DOMAIN\tJUMLAH URL', ...domains.map(item => `${item.domain}\t${item.count}`)].join('\n');
        const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
        const url = URL.createObjectURL(blob);
        const anchor = document.createElement('a');
        anchor.href = url;
        anchor.download = 'domain-extractor.txt';
        document.body.appendChild(anchor);
        anchor.click();
        anchor.remove();
        URL.revokeObjectURL(url);
        toast('Hasil berhasil diekspor.');
    });

    updateSourceStats();
    extract();
});
</script>
@endpush