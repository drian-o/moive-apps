@php
    $isEdit = $mode === 'edit';

    $languages = [
        'text' => 'Plain Text',
        'html' => 'HTML',
        'css' => 'CSS',
        'javascript' => 'JavaScript',
        'json' => 'JSON',
        'php' => 'PHP',
        'blade' => 'Blade',
        'sql' => 'SQL',
        'bash' => 'Bash',
        'markdown' => 'Markdown',
        'xml' => 'XML',
    ];

    $filename = old('filename', $rawPaste?->filename ?? 'file.txt');
    $language = old('language', $rawPaste?->language ?? 'text');
    $visibility = old('visibility', $rawPaste?->visibility ?? 'unlisted');
    $content = old('content', $rawPaste?->content ?? '');

    $expiresAt = old(
        'expires_at',
        $rawPaste?->expires_at?->format('Y-m-d\TH:i')
    );
@endphp

<form
    id="raw-paste-form"
    action="{{ $action }}"
    method="POST"
>
    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid gap-6 xl:grid-cols-[330px_minmax(0,1fr)]">
        {{-- Settings --}}
        <aside class="space-y-5 xl:sticky xl:top-6 xl:self-start">
            <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/10">
                        <x-heroicon-o-adjustments-horizontal class="h-5 w-5 text-violet-400"/>
                    </div>

                    <div>
                        <h2 class="font-bold text-white">Paste Settings</h2>
                        <p class="mt-0.5 text-xs text-slate-500">
                            File, bahasa, akses, dan masa berlaku.
                        </p>
                    </div>
                </div>

                <div class="space-y-5 p-5">
                    {{-- Filename --}}
                    <div>
                        <label for="filename" class="mb-2 block text-sm font-bold text-slate-300">
                            Filename
                        </label>

                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <x-heroicon-o-document class="h-4 w-4 text-slate-600 group-focus-within:text-violet-400"/>
                            </div>

                            <input
                                id="filename"
                                type="text"
                                name="filename"
                                value="{{ $filename }}"
                                maxlength="150"
                                required
                                placeholder="index.html"
                                class="w-full rounded-xl border bg-slate-950/70 py-3 pl-10 pr-3 font-mono text-sm text-white outline-none placeholder:text-slate-600 focus:ring-4
                                    {{ $errors->has('filename')
                                        ? 'border-red-500/70 focus:border-red-500 focus:ring-red-500/10'
                                        : 'border-slate-700 focus:border-violet-500/70 focus:ring-violet-500/10'
                                    }}"
                            >
                        </div>

                        @error('filename')
                            <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Language --}}
                    <div>
                        <label for="language" class="mb-2 block text-sm font-bold text-slate-300">
                            Language
                        </label>

                        <select
                            id="language"
                            name="language"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-3 text-sm text-white outline-none focus:border-violet-500/70"
                        >
                            @foreach($languages as $value => $label)
                                <option value="{{ $value }}" @selected($language === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('language')
                            <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Visibility --}}
                    <div>
                        <label for="visibility" class="mb-2 block text-sm font-bold text-slate-300">
                            Visibility
                        </label>

                        <select
                            id="visibility"
                            name="visibility"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-3 text-sm text-white outline-none focus:border-violet-500/70"
                        >
                            <option value="public" @selected($visibility === 'public')>
                                Public
                            </option>

                            <option value="unlisted" @selected($visibility === 'unlisted')>
                                Unlisted
                            </option>

                            <option value="private" @selected($visibility === 'private')>
                                Private
                            </option>
                        </select>

                        <p id="visibility-help" class="mt-2 text-xs leading-5 text-slate-600"></p>

                        @error('visibility')
                            <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Expiry --}}
                    <div>
                        <label for="expires_at" class="mb-2 block text-sm font-bold text-slate-300">
                            Expired At
                        </label>

                        <input
                            id="expires_at"
                            type="datetime-local"
                            name="expires_at"
                            value="{{ $expiresAt }}"
                            class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-3 text-sm text-white outline-none focus:border-violet-500/70"
                        >

                        <p class="mt-2 text-xs text-slate-600">
                            Kosongkan agar paste tidak kedaluwarsa.
                        </p>

                        @error('expires_at')
                            <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            @if($isEdit)
                <section class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900">
                    <div class="border-b border-slate-800 px-5 py-4">
                        <h2 class="font-bold text-white">Public Links</h2>
                    </div>

                    <div class="space-y-3 p-5">
                        <button
                            type="button"
                            class="copy-link flex w-full items-center justify-between gap-3 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-3 text-left transition hover:border-violet-500/30"
                            data-copy="{{ route('raw-online.show', $rawPaste) }}"
                        >
                            <span class="min-w-0">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                    Viewer URL
                                </span>
                                <span class="mt-1 block truncate font-mono text-[11px] text-slate-400">
                                    {{ route('raw-online.show', $rawPaste) }}
                                </span>
                            </span>

                            <x-heroicon-o-clipboard class="h-4 w-4 shrink-0 text-violet-400"/>
                        </button>

                        <button
                            type="button"
                            class="copy-link flex w-full items-center justify-between gap-3 rounded-xl border border-slate-700 bg-slate-950/60 px-3 py-3 text-left transition hover:border-emerald-500/30"
                            data-copy="{{ route('raw-online.raw', $rawPaste) }}"
                        >
                            <span class="min-w-0">
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-600">
                                    RAW URL
                                </span>
                                <span class="mt-1 block truncate font-mono text-[11px] text-slate-400">
                                    {{ route('raw-online.raw', $rawPaste) }}
                                </span>
                            </span>

                            <x-heroicon-o-clipboard class="h-4 w-4 shrink-0 text-emerald-400"/>
                        </button>

                        <div class="grid grid-cols-2 gap-2">
                            <a
                                href="{{ route('raw-online.show', $rawPaste) }}"
                                target="_blank"
                                rel="noopener"
                                class="flex items-center justify-center gap-2 rounded-xl border border-cyan-500/20 bg-cyan-500/10 px-3 py-2.5 text-xs font-bold text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                            >
                                <x-heroicon-o-eye class="h-4 w-4"/>
                                Viewer
                            </a>

                            <a
                                href="{{ route('raw-online.raw', $rawPaste) }}"
                                target="_blank"
                                rel="noopener"
                                class="flex items-center justify-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2.5 text-xs font-bold text-emerald-400 transition hover:bg-emerald-500 hover:text-white"
                            >
                                RAW
                            </a>
                        </div>
                    </div>
                </section>
            @endif


            {{-- Inline Domain Extractor --}}
            <section
                id="inline-domain-extractor"
                class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20"
            >
                <div class="flex items-center justify-between gap-3 border-b border-slate-800 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10">
                            <x-heroicon-o-globe-alt class="h-5 w-5 text-cyan-400"/>
                        </div>

                        <div>
                            <h2 class="font-bold text-white">
                                Domain Extractor
                            </h2>

                            <p
                                id="extractor-status"
                                class="mt-0.5 text-xs text-slate-500"
                            >
                                Belum dianalisis
                            </p>
                        </div>
                    </div>

                    <span
                        id="extractor-domain-badge"
                        class="rounded-md border border-cyan-500/20 bg-cyan-500/10 px-2 py-1 text-[10px] font-black text-cyan-400"
                    >
                        0 DOMAIN
                    </span>
                </div>

                <div class="space-y-4 p-5">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-800 bg-slate-950/55 p-3">
                            <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Total URL
                            </p>

                            <p
                                id="extractor-total-urls"
                                class="mt-2 text-2xl font-black text-white"
                            >
                                0
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/55 p-3">
                            <p class="text-[9px] font-bold uppercase tracking-[0.14em] text-slate-600">
                                Domain Unik
                            </p>

                            <p
                                id="extractor-unique-domains"
                                class="mt-2 text-2xl font-black text-cyan-400"
                            >
                                0
                            </p>
                        </div>
                    </div>

                    <button
                        id="run-inline-extractor"
                        type="button"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-cyan-600 to-sky-600 px-4 py-3 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:from-cyan-500 hover:to-sky-500"
                    >
                        <x-heroicon-o-magnifying-glass class="h-4 w-4"/>
                        Extract dari Editor
                    </button>

                    <div
                        id="extractor-results-wrap"
                        class="hidden space-y-3"
                    >
                        <div class="group relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-600 group-focus-within:text-cyan-400"/>
                            </div>

                            <input
                                id="extractor-search"
                                type="search"
                                placeholder="Cari domain..."
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/70 py-2.5 pl-10 pr-3 text-xs text-white outline-none placeholder:text-slate-600 focus:border-cyan-500/60"
                            >
                        </div>

                        <div
                            id="extractor-domain-list"
                            class="max-h-64 divide-y divide-slate-800 overflow-y-auto rounded-2xl border border-slate-800 bg-slate-950/45"
                        ></div>

                        <div>
                            <label
                                for="extractor-export-format"
                                class="mb-2 block text-[10px] font-bold uppercase tracking-[0.14em] text-slate-600"
                            >
                                Format Export
                            </label>

                            <select
                                id="extractor-export-format"
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3 py-2.5 text-xs font-semibold text-slate-300 outline-none focus:border-emerald-500/60"
                            >
                                <option value="domains">
                                    Domain saja
                                </option>

                                <option value="https_domains">
                                    Domain dengan https://
                                </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button
                                id="copy-extracted-domains"
                                type="button"
                                class="flex items-center justify-center gap-2 rounded-xl border border-cyan-500/20 bg-cyan-500/10 px-3 py-2.5 text-[11px] font-bold text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                            >
                                <x-heroicon-o-clipboard class="h-4 w-4"/>
                                Copy Domain
                            </button>

                            <button
                                id="export-extracted-domains"
                                type="button"
                                class="flex items-center justify-center gap-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2.5 text-[11px] font-bold text-emerald-400 transition hover:bg-emerald-500 hover:text-white"
                            >
                                <x-heroicon-o-arrow-down-tray class="h-4 w-4"/>
                                Export
                            </button>
                        </div>
                    </div>

                    <div
                        id="extractor-empty"
                        class="rounded-2xl border border-dashed border-slate-700 bg-slate-950/35 px-4 py-6 text-center"
                    >
                        <x-heroicon-o-link class="mx-auto h-7 w-7 text-slate-600"/>

                        <p class="mt-2 text-xs font-semibold text-slate-500">
                            Tempel kode lalu jalankan extractor.
                        </p>
                    </div>
                </div>
            </section>

            <div class="grid gap-3">
                <button
                    id="save-paste"
                    type="submit"
                    class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-fuchsia-600 to-violet-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-violet-950/40 transition hover:-translate-y-0.5 hover:from-fuchsia-500 hover:to-violet-500 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg
                        id="save-spinner"
                        class="hidden h-5 w-5 animate-spin"
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
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                    </svg>

                    <x-heroicon-o-check id="save-icon" class="h-5 w-5"/>

                    <span id="save-text">
                        {{ $isEdit ? 'Update Paste' : 'Simpan Paste' }}
                    </span>
                </button>

                <a
                    href="{{ route('admin.raw-online.index') }}"
                    class="flex w-full items-center justify-center rounded-xl border border-slate-700 bg-slate-800/70 px-5 py-3 text-sm font-bold text-slate-300 transition hover:bg-slate-700 hover:text-white"
                >
                    Batal
                </a>
            </div>
        </aside>

        {{-- Editor --}}
        <section class="min-w-0 overflow-hidden rounded-3xl border border-slate-800 bg-[#0b0d12] shadow-2xl shadow-black/30">
            <div class="flex flex-col gap-3 border-b border-slate-800 bg-slate-900/85 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-red-500"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                    </div>

                    <div class="h-5 w-px bg-slate-700"></div>

                    <div class="flex items-center gap-2">
                        <x-heroicon-o-code-bracket class="h-4 w-4 text-violet-400"/>

                        <span id="editor-filename" class="font-mono text-xs font-bold text-slate-300">
                            {{ $filename }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold text-slate-600">
                    <button
                        id="toolbar-domain-extractor"
                        type="button"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1.5 font-bold text-cyan-400 transition hover:bg-cyan-500 hover:text-white"
                    >
                        <x-heroicon-o-globe-alt class="h-3.5 w-3.5"/>
                        Extractor
                    </button>

                    <span>
                        <span id="line-count">1</span> lines
                    </span>

                    <span>
                        <span id="character-count">0</span> chars
                    </span>

                    <span class="rounded-md bg-slate-800 px-2 py-1 font-mono text-violet-400">
                        Ctrl + S
                    </span>
                </div>
            </div>

            <div class="relative grid min-h-[680px] grid-cols-[58px_minmax(0,1fr)]">
                <div
                    id="line-numbers"
                    class="select-none overflow-hidden border-r border-slate-800 bg-[#090b0f] px-3 py-5 text-right font-mono text-sm leading-6 text-slate-700"
                    aria-hidden="true"
                >
                    1
                </div>

                <textarea
                    id="content"
                    name="content"
                    spellcheck="false"
                    wrap="off"
                    required
                    placeholder="Paste your code here..."
                    class="min-h-[680px] w-full resize-none overflow-auto bg-[#0b0d12] px-4 py-5 font-mono text-sm leading-6 text-slate-200 outline-none placeholder:text-slate-700 selection:bg-violet-500/30"
                >{{ $content }}</textarea>
            </div>

            @error('content')
                <div class="border-t border-red-500/20 bg-red-500/10 px-5 py-3 text-xs font-medium text-red-400">
                    {{ $message }}
                </div>
            @enderror

            <div class="flex flex-col gap-2 border-t border-slate-800 bg-slate-900/60 px-4 py-3 text-[11px] text-slate-600 sm:flex-row sm:items-center sm:justify-between">
                <span>
                    Tab menghasilkan empat spasi.
                </span>

                <span id="editor-language" class="font-mono uppercase text-violet-400">
                    {{ $language }}
                </span>
            </div>
        </section>
    </div>
</form>

{{-- Toast --}}
<div
    id="raw-form-toast"
    class="pointer-events-none fixed bottom-5 right-5 z-[90] hidden max-w-sm translate-y-4 rounded-2xl border border-emerald-500/20 bg-slate-900/95 p-4 opacity-0 shadow-2xl shadow-black/50 backdrop-blur transition"
>
    <p id="raw-form-toast-message" class="text-sm font-semibold text-emerald-300"></p>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('raw-paste-form');
    const textarea = document.getElementById('content');
    const lineNumbers = document.getElementById('line-numbers');

    const filename = document.getElementById('filename');
    const editorFilename = document.getElementById('editor-filename');

    const language = document.getElementById('language');
    const editorLanguage = document.getElementById('editor-language');

    const visibility = document.getElementById('visibility');
    const visibilityHelp = document.getElementById('visibility-help');

    const lineCount = document.getElementById('line-count');
    const characterCount = document.getElementById('character-count');

    const saveButton = document.getElementById('save-paste');
    const saveSpinner = document.getElementById('save-spinner');
    const saveIcon = document.getElementById('save-icon');
    const saveText = document.getElementById('save-text');

    const toast = document.getElementById('raw-form-toast');
    const toastMessage = document.getElementById('raw-form-toast-message');

    const extractorCard =
        document.getElementById('inline-domain-extractor');

    const toolbarExtractorButton =
        document.getElementById('toolbar-domain-extractor');

    const runExtractorButton =
        document.getElementById('run-inline-extractor');

    const extractorStatus =
        document.getElementById('extractor-status');

    const extractorDomainBadge =
        document.getElementById('extractor-domain-badge');

    const extractorTotalUrls =
        document.getElementById('extractor-total-urls');

    const extractorUniqueDomains =
        document.getElementById('extractor-unique-domains');

    const extractorSearch =
        document.getElementById('extractor-search');

    const extractorResultsWrap =
        document.getElementById('extractor-results-wrap');

    const extractorDomainList =
        document.getElementById('extractor-domain-list');

    const extractorEmpty =
        document.getElementById('extractor-empty');

    const copyExtractedDomains =
        document.getElementById('copy-extracted-domains');

    const exportExtractedDomains =
        document.getElementById('export-extracted-domains');

    const extractorExportFormat =
        document.getElementById('extractor-export-format');

    let extractedUrls = [];
    let extractedDomains = [];


    function normalizeExtractedUrl(rawUrl) {
        return String(rawUrl || '')
            .replace(/&amp;/gi, '&')
            .replace(/[),.;]+$/g, '')
            .trim();
    }

    function extractUrlsFromContent(content) {
        const matches = String(content || '').match(
            /https?:\/\/[^\s"'<>`\\]+/gi
        ) || [];

        return matches
            .map(normalizeExtractedUrl)
            .filter(url => {
                try {
                    const parsed = new URL(url);

                    return ['http:', 'https:'].includes(
                        parsed.protocol
                    );
                } catch {
                    return false;
                }
            });
    }

    function groupExtractedDomains(urls) {
        const domainMap = new Map();

        urls.forEach(url => {
            const parsed = new URL(url);
            const domain = parsed.hostname.toLowerCase();

            if (!domainMap.has(domain)) {
                domainMap.set(domain, {
                    domain,
                    count: 0,
                    urls: [],
                });
            }

            const item = domainMap.get(domain);
            item.count++;

            if (!item.urls.includes(url)) {
                item.urls.push(url);
            }
        });

        return Array.from(domainMap.values())
            .sort((first, second) => {
                if (second.count !== first.count) {
                    return second.count - first.count;
                }

                return first.domain.localeCompare(
                    second.domain
                );
            });
    }

    function escapeExtractorHtml(value) {
        const element = document.createElement('div');
        element.textContent = value;

        return element.innerHTML;
    }

    async function copyExtractorText(value) {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(value);
            return;
        }

        const helper = document.createElement('textarea');
        helper.value = value;
        document.body.appendChild(helper);
        helper.select();
        document.execCommand('copy');
        helper.remove();
    }

    function renderExtractedDomains() {
        const keyword = extractorSearch.value
            .trim()
            .toLowerCase();

        const filtered = extractedDomains.filter(item =>
            !keyword || item.domain.includes(keyword)
        );

        if (filtered.length === 0) {
            extractorDomainList.innerHTML = `
                <div class="px-4 py-8 text-center text-xs text-slate-600">
                    Domain tidak ditemukan.
                </div>
            `;

            return;
        }

        extractorDomainList.innerHTML = filtered
            .map(item => `
                <button
                    type="button"
                    class="copy-one-domain flex w-full items-center gap-3 px-3 py-3 text-left transition hover:bg-slate-800/60"
                    data-domain="${escapeExtractorHtml(item.domain)}"
                >
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-cyan-500/10 text-cyan-400">
                        ↗
                    </span>

                    <span class="min-w-0 flex-1">
                        <span class="block truncate font-mono text-xs font-bold text-slate-300">
                            ${escapeExtractorHtml(item.domain)}
                        </span>

                        <span class="mt-1 block truncate font-mono text-[10px] text-slate-600">
                            ${escapeExtractorHtml(item.urls[0] || '')}
                        </span>
                    </span>

                    <span class="shrink-0 rounded-full border border-violet-500/20 bg-violet-500/10 px-2 py-1 text-[9px] font-black text-violet-400">
                        ${item.count}
                    </span>
                </button>
            `)
            .join('');

        extractorDomainList
            .querySelectorAll('.copy-one-domain')
            .forEach(button => {
                button.addEventListener('click', async () => {
                    await copyExtractorText(
                        button.dataset.domain || ''
                    );

                    showToast(
                        'Domain berhasil disalin.'
                    );
                });
            });
    }

    function runInlineExtractor() {
        extractedUrls = extractUrlsFromContent(
            textarea.value
        );

        extractedDomains = groupExtractedDomains(
            extractedUrls
        );

        extractorTotalUrls.textContent =
            extractedUrls.length.toLocaleString('id-ID');

        extractorUniqueDomains.textContent =
            extractedDomains.length.toLocaleString('id-ID');

        extractorDomainBadge.textContent =
            `${extractedDomains.length} DOMAIN`;

        const hasResults =
            extractedDomains.length > 0;

        extractorResultsWrap.classList.toggle(
            'hidden',
            !hasResults
        );

        extractorEmpty.classList.toggle(
            'hidden',
            hasResults
        );

        extractorStatus.textContent = hasResults
            ? `${extractedDomains.length} domain ditemukan`
            : 'Tidak ada URL ditemukan';

        extractorStatus.className = hasResults
            ? 'mt-0.5 text-xs text-emerald-400'
            : 'mt-0.5 text-xs text-amber-400';

        renderExtractedDomains();

        showToast(
            hasResults
                ? `${extractedDomains.length} domain berhasil diekstrak.`
                : 'Tidak ada URL http/https di dalam editor.'
        );
    }

    function markExtractorAsStale() {
        if (extractedDomains.length === 0) {
            return;
        }

        extractorStatus.textContent =
            'Konten berubah, scan ulang';

        extractorStatus.className =
            'mt-0.5 text-xs text-amber-400';
    }

    function updateEditorStats() {
        const lines = textarea.value.split('\n').length;

        lineCount.textContent = lines.toLocaleString('id-ID');
        characterCount.textContent =
            textarea.value.length.toLocaleString('id-ID');

        lineNumbers.textContent = Array.from(
            { length: lines },
            (_, index) => index + 1
        ).join('\n');
    }

    function updateVisibilityHelp() {
        const messages = {
            public: 'Bisa dibuka melalui URL dan dapat ditampilkan pada halaman explore.',
            unlisted: 'Bisa dibuka melalui URL, tetapi tidak ditampilkan pada halaman explore.',
            private: 'Hanya dapat dikelola melalui dashboard administrator.',
        };

        visibilityHelp.textContent =
            messages[visibility.value] || '';
    }

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

    textarea.addEventListener('input', () => {
        updateEditorStats();
        markExtractorAsStale();
    });

    runExtractorButton.addEventListener(
        'click',
        runInlineExtractor
    );

    toolbarExtractorButton.addEventListener(
        'click',
        () => {
            runInlineExtractor();

            extractorCard.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            });
        }
    );

    extractorSearch.addEventListener(
        'input',
        renderExtractedDomains
    );

    copyExtractedDomains.addEventListener(
        'click',
        async () => {
            const value = extractedDomains
                .map(item => item.domain)
                .join('\n');

            await copyExtractorText(value);
            showToast(
                'Semua domain berhasil disalin.'
            );
        }
    );

    exportExtractedDomains.addEventListener(
        'click',
        () => {
            if (extractedDomains.length === 0) {
                showToast(
                    'Belum ada domain untuk diekspor.'
                );

                return;
            }

            const format =
                extractorExportFormat.value;

            const safeBaseName = (
                filename.value ||
                'domain-extractor'
            )
                .replace(/\.[^.]+$/, '')
                .replace(/[^a-z0-9_-]+/gi, '-')
                .replace(/^-+|-+$/g, '')
                .toLowerCase() ||
                'domain-extractor';

            let exportContent = '';
            let extension = 'txt';
            let mimeType =
                'text/plain;charset=utf-8';

            switch (format) {
                case 'https_domains':
                    exportContent = extractedDomains
                        .map(item => `https://${item.domain}`)
                        .join('\r\n');
                    break;

                case 'domains':
                default:
                    exportContent = extractedDomains
                        .map(item => item.domain)
                        .join('\r\n');
                    break;
            }

            const blob = new Blob(
                [exportContent],
                { type: mimeType }
            );

            const objectUrl =
                URL.createObjectURL(blob);

            const anchor =
                document.createElement('a');

            anchor.href = objectUrl;
            anchor.download =
                format === 'https_domains'
                    ? `${safeBaseName}-domains-with-https.${extension}`
                    : `${safeBaseName}-domains.${extension}`;

            document.body.appendChild(anchor);
            anchor.click();
            anchor.remove();

            URL.revokeObjectURL(objectUrl);

            showToast(
                `Export ${extension.toUpperCase()} berhasil.`
            );
        }
    );

    textarea.addEventListener('scroll', () => {
        lineNumbers.scrollTop = textarea.scrollTop;
    });

    textarea.addEventListener('keydown', event => {
        if (event.key === 'Tab') {
            event.preventDefault();

            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            textarea.value =
                textarea.value.slice(0, start) +
                '    ' +
                textarea.value.slice(end);

            textarea.selectionStart =
                textarea.selectionEnd =
                start + 4;

            updateEditorStats();
        }

        if (
            (event.ctrlKey || event.metaKey) &&
            event.key.toLowerCase() === 's'
        ) {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    filename.addEventListener('input', () => {
        editorFilename.textContent =
            filename.value.trim() || 'file.txt';
    });

    language.addEventListener('change', () => {
        editorLanguage.textContent =
            language.value.toUpperCase();
    });

    visibility.addEventListener(
        'change',
        updateVisibilityHelp
    );

    document.querySelectorAll('.copy-link').forEach(button => {
        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(
                    button.dataset.copy || ''
                );

                showToast('URL berhasil disalin.');
            } catch {
                showToast('Browser menolak akses clipboard.');
            }
        });
    });

    form.addEventListener('submit', () => {
        saveButton.disabled = true;
        saveSpinner.classList.remove('hidden');
        saveIcon.classList.add('hidden');
        saveText.textContent = 'Menyimpan...';
    });

    updateEditorStats();
    updateVisibilityHelp();

    if (textarea.value.trim() !== '') {
        runInlineExtractor();
    }
});
</script>
@endpush