@extends('layouts.admin')

@section('title', 'Authority Checker')
@section('page-title', 'Authority Checker')

@section('content')
<div
    id="authority-app"
    data-check-url="{{ route('admin.seo-tools.authority.check') }}"
    class="mx-auto w-full max-w-[1600px] space-y-6"
>
    {{-- Page header --}}
    <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-sky-500 to-blue-700 shadow-lg shadow-sky-950/50">
                    <x-heroicon-o-shield-check class="relative z-10 h-6 w-6 text-white" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                        Authority Checker
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-500">
                        Domain intelligence workspace
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Periksa Domain Authority, Page Authority, spam score, backlink,
                referring domain, organic traffic, dan halaman terkuat dalam satu kali scan.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-2">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>
                <span class="text-xs font-semibold text-emerald-400">Service Ready</span>
            </div>

            <div class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-2 text-xs font-semibold text-sky-300">
                Moz + Semrush
            </div>
        </div>
    </div>

    {{-- Input card --}}
    <section class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/25">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-72 w-72 rounded-full bg-sky-500/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-24 h-72 w-72 rounded-full bg-blue-600/10 blur-3xl"></div>
        </div>

        <div class="relative flex flex-col gap-4 border-b border-slate-800 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-700 bg-slate-950/70 text-sky-400">
                    <x-heroicon-o-globe-alt class="h-5 w-5" />
                </div>

                <div>
                    <h2 class="font-bold text-white">Domain Scanner</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Masukkan satu domain per baris.</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button
                    id="sample-domains"
                    type="button"
                    class="rounded-xl border border-slate-700 bg-slate-800/70 px-3 py-2 text-xs font-semibold text-slate-400 transition hover:border-sky-500/40 hover:text-sky-300"
                >
                    Isi contoh
                </button>

                <button
                    id="clear-domains"
                    type="button"
                    class="rounded-xl border border-slate-700 bg-slate-800/70 px-3 py-2 text-xs font-semibold text-slate-400 transition hover:border-red-500/40 hover:text-red-300"
                >
                    Bersihkan
                </button>
            </div>
        </div>

        <div class="relative p-5 sm:p-6">
            <div class="group relative">
                <div class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-r from-sky-500/0 via-sky-500/10 to-blue-500/0 opacity-0 blur transition group-focus-within:opacity-100"></div>

                <textarea
                    id="domains"
                    rows="8"
                    spellcheck="false"
                    class="relative w-full resize-y rounded-2xl border border-slate-700/80 bg-slate-950/80 px-5 py-4 font-mono text-sm leading-7 text-white outline-none transition placeholder:text-slate-600 focus:border-sky-500/70 focus:ring-4 focus:ring-sky-500/10"
                    placeholder="google.com&#10;facebook.com&#10;youtube.com&#10;openai.com"
                ></textarea>

                <div class="absolute bottom-3 right-4 rounded-md bg-slate-900/90 px-2 py-1 text-[11px] text-slate-500">
                    <span id="domain-count">0</span> domain
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-2 text-xs leading-5 text-slate-500">
                    <x-heroicon-o-information-circle class="mt-0.5 h-4 w-4 shrink-0 text-sky-500" />
                    <span>Format protokol dan path akan dibersihkan otomatis sebelum dipindai.</span>
                </div>

                <button
                    id="btnCheck"
                    type="button"
                    class="group relative flex min-w-[190px] items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-950/40 transition hover:-translate-y-0.5 hover:from-sky-500 hover:to-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

                    <svg id="scan-spinner" class="relative hidden h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <x-heroicon-o-magnifying-glass id="scan-icon" class="relative h-5 w-5" />
                    <span id="scan-text" class="relative">Scan Domains</span>
                </button>
            </div>
        </div>
    </section>

    {{-- Loading --}}
    <section id="loading" class="hidden overflow-hidden rounded-2xl border border-sky-500/20 bg-sky-950/30">
        <div class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-500/10">
                    <span class="absolute h-10 w-10 animate-ping rounded-full bg-sky-500/10"></span>
                    <svg class="relative h-6 w-6 animate-spin text-sky-400" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>

                <div>
                    <div class="font-bold text-white">Scanning domains...</div>
                    <div id="loading-message" class="mt-1 text-sm text-sky-200/70">
                        Mengumpulkan metrik Moz dan Semrush.
                    </div>
                </div>
            </div>

            <div id="scan-elapsed" class="font-mono text-xs text-sky-300">00:00</div>
        </div>

        <div class="h-1 overflow-hidden bg-slate-900">
            <div class="h-full w-1/3 animate-[authorityProgress_1.4s_ease-in-out_infinite] rounded-full bg-gradient-to-r from-sky-500 to-blue-500"></div>
        </div>
    </section>

    {{-- Results --}}
    <section id="resultContainer" class="space-y-6">
        <div id="empty-state" class="relative overflow-hidden rounded-3xl border border-dashed border-slate-700 bg-slate-900/70 px-6 py-16 text-center">
            <div class="pointer-events-none absolute inset-0 opacity-[0.025]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:28px 28px"></div>

            <div class="relative mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-3xl border border-sky-500/20 bg-gradient-to-br from-sky-500/15 to-blue-500/5 shadow-lg shadow-sky-950/30">
                <x-heroicon-o-chart-bar-square class="h-9 w-9 text-sky-400" />
            </div>

            <h3 class="relative text-xl font-bold text-white">Belum ada hasil scan</h3>
            <p class="relative mx-auto mt-2 max-w-lg text-sm leading-6 text-slate-500">
                Masukkan satu atau beberapa domain di atas, kemudian tekan
                <strong class="text-slate-300">Scan Domains</strong>.
            </p>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    @keyframes authorityProgress {
        0% { transform: translateX(-110%); }
        50% { transform: translateX(110%); }
        100% { transform: translateX(310%); }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('authority-app');

    if (!app) return;

    const checkUrl = app.dataset.checkUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    const domainsInput = document.getElementById('domains');
    const domainCount = document.getElementById('domain-count');
    const scanButton = document.getElementById('btnCheck');
    const scanText = document.getElementById('scan-text');
    const scanIcon = document.getElementById('scan-icon');
    const scanSpinner = document.getElementById('scan-spinner');
    const loading = document.getElementById('loading');
    const loadingMessage = document.getElementById('loading-message');
    const scanElapsed = document.getElementById('scan-elapsed');
    const resultContainer = document.getElementById('resultContainer');
    const sampleButton = document.getElementById('sample-domains');
    const clearButton = document.getElementById('clear-domains');

    const chartInstances = new Map();
    let timerId = null;
    let scanStartedAt = 0;
    let isScanning = false;
    let latestResults = [];

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function toNumber(value, fallback = 0) {
        const number = Number(value);
        return Number.isFinite(number) ? number : fallback;
    }

    function formatNumber(value) {
        if (value === null || value === undefined || value === '') return '-';

        const number = Number(value);
        if (!Number.isFinite(number)) return escapeHtml(value);

        return new Intl.NumberFormat('en-US', {
            notation: Math.abs(number) >= 1000 ? 'compact' : 'standard',
            maximumFractionDigits: 1,
        }).format(number);
    }

    function formatPercent(value) {
        const number = Number(value);
        return Number.isFinite(number) ? `${number.toFixed(1)}%` : '-';
    }

    function normalizeDomain(value) {
        let domain = String(value ?? '').trim().toLowerCase();
        if (!domain) return '';

        domain = domain.replace(/^https?:\/\//i, '');
        domain = domain.split('/')[0];
        domain = domain.split('?')[0];
        domain = domain.split('#')[0];

        return domain.replace(/\.$/, '');
    }

    function getDomains() {
        return [...new Set(
            domainsInput.value
                .split(/\r?\n|,/)
                .map(normalizeDomain)
                .filter(Boolean)
        )];
    }

    function updateDomainCount() {
        domainCount.textContent = getDomains().length.toLocaleString('id-ID');
    }

    function safeExternalUrl(value) {
        const domain = normalizeDomain(value);
        if (!domain) return '#';

        try {
            const url = new URL(`https://${domain}`);
            return ['http:', 'https:'].includes(url.protocol) ? url.href : '#';
        } catch {
            return '#';
        }
    }

    function authorityLabel(score) {
        if (score >= 90) return 'Excellent';
        if (score >= 70) return 'Very Strong';
        if (score >= 50) return 'Good';
        if (score >= 30) return 'Average';
        return 'Low';
    }

    function authorityTone(score) {
        if (score >= 70) return 'emerald';
        if (score >= 40) return 'sky';
        if (score >= 20) return 'amber';
        return 'red';
    }

    function metricCard(label, value, icon, tone = 'sky') {
        const tones = {
            sky: 'border-sky-500/15 bg-sky-500/5 text-sky-400',
            emerald: 'border-emerald-500/15 bg-emerald-500/5 text-emerald-400',
            violet: 'border-violet-500/15 bg-violet-500/5 text-violet-400',
            amber: 'border-amber-500/15 bg-amber-500/5 text-amber-400',
            red: 'border-red-500/15 bg-red-500/5 text-red-400',
            cyan: 'border-cyan-500/15 bg-cyan-500/5 text-cyan-400',
        };

        return `
            <div class="rounded-2xl border p-4 transition duration-200 hover:-translate-y-0.5 ${tones[tone] ?? tones.sky}">
                <div class="flex items-start justify-between gap-3">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">${escapeHtml(label)}</div>
                    <div class="text-lg">${icon}</div>
                </div>
                <div class="mt-3 break-words text-2xl font-black text-white">${value}</div>
            </div>
        `;
    }

    function insightCard(title, value, description, icon) {
        return `
            <div class="rounded-2xl border border-slate-800 bg-slate-950/55 p-5 transition hover:border-sky-500/30 hover:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-300">${escapeHtml(title)}</div>
                        <div class="mt-1 text-xs leading-5 text-slate-600">${escapeHtml(description)}</div>
                    </div>
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-800 text-xl">${icon}</div>
                </div>
                <div class="mt-5 text-xl font-black text-white">${escapeHtml(value)}</div>
            </div>
        `;
    }

    function renderTopPages(pages, cardId) {
        if (!Array.isArray(pages) || pages.length === 0) {
            return `
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-sm text-slate-500">
                        Tidak ada data top pages.
                    </td>
                </tr>
            `;
        }

        return pages.map((page, index) => {
            const url = String(page?.url ?? '');
            const safeUrl = (() => {
                try {
                    const parsed = new URL(url);
                    return ['http:', 'https:'].includes(parsed.protocol) ? parsed.href : '#';
                } catch {
                    return '#';
                }
            })();

            return `
                <tr class="page-row border-b border-slate-800/80 transition hover:bg-slate-800/45" data-search="${escapeHtml(url.toLowerCase())}">
                    <td class="px-5 py-4 text-slate-600">${index + 1}</td>
                    <td class="max-w-0 px-5 py-4">
                        <div class="truncate font-medium text-slate-200" title="${escapeHtml(url)}">${escapeHtml(url)}</div>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex min-w-10 justify-center rounded-full bg-sky-500/15 px-3 py-1 text-xs font-bold text-sky-300">
                            ${escapeHtml(page?.authority ?? '-')}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex justify-center gap-2">
                            <button type="button" class="copy-btn rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-xs text-slate-300 transition hover:border-sky-500/40 hover:text-sky-300" data-copy="${escapeHtml(url)}">Copy</button>
                            <a href="${escapeHtml(safeUrl)}" target="_blank" rel="noopener noreferrer" class="rounded-lg bg-sky-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-sky-500">Visit</a>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderLinkingDomains(domains) {
        if (!Array.isArray(domains) || domains.length === 0) {
            return `
                <tr>
                    <td colspan="3" class="px-5 py-12 text-center text-sm text-slate-500">
                        Tidak ada data linking domain.
                    </td>
                </tr>
            `;
        }

        return domains.map(item => {
            const domain = String(item?.domain ?? '');
            return `
                <tr class="border-b border-slate-800/80 transition hover:bg-slate-800/45">
                    <td class="px-5 py-4 font-medium text-slate-200">${escapeHtml(domain)}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex min-w-10 justify-center rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-bold text-emerald-300">${escapeHtml(item?.authority ?? '-')}</span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <button type="button" class="copy-btn rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-xs text-slate-300 transition hover:border-sky-500/40 hover:text-sky-300" data-copy="${escapeHtml(domain)}">Copy</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderDomainCard(item, index) {
        const domain = normalizeDomain(item?.domain) || `domain-${index + 1}`;
        const authority = Math.min(100, Math.max(0, toNumber(item?.authority)));
        const pageAuthority = Array.isArray(item?.top_pages) && item.top_pages.length
            ? Math.max(...item.top_pages.map(page => toNumber(page?.authority)))
            : '-';
        const spamScore = toNumber(item?.spam_score);
        const authorityScore = item?.authority_score ?? item?.authority?.score ?? '-';
        const cardId = `authority-card-${index}`;
        const chartId = `authority-chart-${index}`;
        const tone = authorityTone(authority);
        const visitUrl = safeExternalUrl(domain);
        const trust = authority >= 80 ? 'Excellent' : authority >= 60 ? 'Good' : authority >= 40 ? 'Average' : 'Low';
        const backlinkQuality = spamScore <= 3 ? 'High' : spamScore <= 10 ? 'Medium' : 'Low';

        return `
            <article id="${cardId}" class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/20">
                <div class="relative overflow-hidden border-b border-slate-800 px-5 py-5 sm:px-6">
                    <div class="pointer-events-none absolute -right-16 -top-20 h-48 w-48 rounded-full bg-sky-500/10 blur-3xl"></div>

                    <div class="relative flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    Active
                                </span>
                                <span class="text-xs text-slate-600">Moz + Semrush intelligence</span>
                            </div>

                            <h2 class="mt-3 break-all text-2xl font-black tracking-tight text-white sm:text-3xl">${escapeHtml(domain)}</h2>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="rounded-lg border border-sky-500/20 bg-sky-500/10 px-3 py-1.5 text-xs font-bold text-sky-300">DA ${authority}</span>
                                <span class="rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-3 py-1.5 text-xs font-bold text-emerald-300">PA ${escapeHtml(pageAuthority)}</span>
                                <span class="rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-1.5 text-xs font-bold text-red-300">Spam ${formatPercent(spamScore)}</span>
                                <span class="rounded-lg border border-cyan-500/20 bg-cyan-500/10 px-3 py-1.5 text-xs font-bold text-cyan-300">Authority ${escapeHtml(authorityScore)}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" class="copy-btn rounded-xl border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:border-sky-500/40 hover:text-sky-300" data-copy="${escapeHtml(domain)}">Copy</button>
                            <a href="${escapeHtml(visitUrl)}" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-500">Visit</a>
                            <button type="button" class="toggle-detail flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-950/70 px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:border-sky-500/40 hover:text-white" data-target="${cardId}" data-chart="${chartId}" data-index="${index}">
                                <span>Detail</span>
                                <svg class="detail-chevron h-4 w-4 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid gap-px bg-slate-800 sm:grid-cols-2 xl:grid-cols-6">
                    ${metricCard('Domain Authority', authority, '🛡️', tone)}
                    ${metricCard('Page Authority', escapeHtml(pageAuthority), '📄', 'emerald')}
                    ${metricCard('Spam Score', formatPercent(spamScore), '🚨', spamScore > 10 ? 'red' : 'amber')}
                    ${metricCard('Backlinks', formatNumber(item?.backlinks), '🔗', 'sky')}
                    ${metricCard('Ref Domains', formatNumber(item?.referring_domains ?? item?.ref_domains), '🌍', 'cyan')}
                    ${metricCard('Organic Traffic', formatNumber(item?.organic_traffic), '📈', 'violet')}
                </div>

                <div class="detail-box hidden" data-item-index="${index}">
                    <div class="grid gap-6 border-t border-slate-800 p-5 sm:p-6 xl:grid-cols-[360px_1fr]">
                        <div class="rounded-2xl border border-slate-800 bg-gradient-to-br from-slate-950 to-slate-900 p-6">
                            <div class="text-center text-sm font-semibold text-slate-400">Domain Authority</div>
                            <div class="relative mx-auto mt-5 h-64 w-64 max-w-full">
                                <canvas id="${chartId}"></canvas>
                                <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
                                    <div class="text-6xl font-black text-white">${authority}</div>
                                    <span class="mt-2 rounded-full border border-sky-500/20 bg-sky-500/10 px-3 py-1 text-[10px] font-bold tracking-wider text-sky-300">MOZ DA</span>
                                    <div class="mt-3 text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500">${authorityLabel(authority)}</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-800 bg-slate-950/45 p-5 sm:p-6">
                            <div class="mb-5">
                                <h3 class="text-lg font-bold text-white">Overview Metrics</h3>
                                <p class="mt-1 text-xs text-slate-500">Ringkasan performa dan profil backlink domain.</p>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                ${metricCard('Authority Score', escapeHtml(authorityScore), '⭐', 'cyan')}
                                ${metricCard('Follow Backlinks', formatNumber(item?.follow_backlinks), '✅', 'emerald')}
                                ${metricCard('No-Follow', formatNumber(item?.nofollow_backlinks), '⛔', 'amber')}
                                ${metricCard('Organic Keywords', formatNumber(item?.organic_keywords), '🔎', 'violet')}
                                ${metricCard('Root Domains', formatNumber(item?.ref_domains), '🌐', 'sky')}
                                ${metricCard('Backlinks', formatNumber(item?.backlinks), '🔗', 'sky')}
                                ${metricCard('Referring Domains', formatNumber(item?.referring_domains ?? item?.ref_domains), '🌍', 'cyan')}
                                ${metricCard('Spam Score', formatPercent(spamScore), '🚨', spamScore > 10 ? 'red' : 'amber')}
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-800 p-5 sm:p-6">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-500/10 text-xl">📄</div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Top Pages</h3>
                                    <p class="mt-0.5 text-xs text-slate-500">Halaman dengan authority tertinggi.</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <span class="rounded-xl border border-slate-700 bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-400">${item?.top_pages?.length ?? 0} pages</span>
                                <input type="search" class="page-search w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-white outline-none placeholder:text-slate-600 focus:border-sky-500 sm:w-72" data-card="${cardId}" placeholder="Cari URL...">
                            </div>
                        </div>

                        <div class="mt-5 overflow-x-auto rounded-2xl border border-slate-800">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-950/80 text-xs uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="px-5 py-4 text-left">#</th>
                                        <th class="px-5 py-4 text-left">URL</th>
                                        <th class="px-5 py-4 text-center">PA</th>
                                        <th class="px-5 py-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="page-body bg-slate-900/40">
                                    ${renderTopPages(item?.top_pages ?? [], cardId)}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="border-t border-slate-800 p-5 sm:p-6">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-500/10 text-xl">🌍</div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Top Linking Domains</h3>
                                <p class="mt-0.5 text-xs text-slate-500">Domain yang paling kuat mengarah ke website ini.</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto rounded-2xl border border-slate-800">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-950/80 text-xs uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="px-5 py-4 text-left">Domain</th>
                                        <th class="px-5 py-4 text-center">DA</th>
                                        <th class="px-5 py-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-slate-900/40">
                                    ${renderLinkingDomains(item?.top_linking_domains ?? [])}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="border-t border-slate-800 p-5 sm:p-6">
                        <div class="mb-5">
                            <h3 class="text-lg font-bold text-white">Domain Insights</h3>
                            <p class="mt-1 text-xs text-slate-500">Interpretasi cepat berdasarkan hasil scan.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            ${insightCard('Trust Score', trust, 'Penilaian berdasarkan Domain Authority.', '🛡️')}
                            ${insightCard('HTTPS', 'Enabled', 'Domain diasumsikan dapat diakses melalui HTTPS.', '🔒')}
                            ${insightCard('Backlink Quality', backlinkQuality, 'Diestimasi dari spam score domain.', '🔗')}
                            ${insightCard('Ref Domains', formatNumber(item?.ref_domains), 'Jumlah root domain yang terdeteksi.', '🌎')}
                            ${insightCard('Organic Traffic', formatNumber(item?.organic_traffic), 'Estimasi trafik organik.', '📈')}
                            ${insightCard('Organic Keywords', formatNumber(item?.organic_keywords), 'Keyword organik yang terdeteksi.', '🔍')}
                            ${insightCard('Spam Score', formatPercent(spamScore), 'Semakin rendah umumnya semakin baik.', '🚨')}
                            ${insightCard('Authority', authority, 'Skor Domain Authority Moz.', '⭐')}
                        </div>
                    </div>
                </div>
            </article>
        `;
    }

    function destroyCharts() {
        chartInstances.forEach(chart => chart.destroy());
        chartInstances.clear();
    }

    function createChart(index, canvasId, item) {
        if (chartInstances.has(index)) return;

        const canvas = document.getElementById(canvasId);
        if (!canvas || typeof Chart === 'undefined') return;

        const authority = Math.min(100, Math.max(0, toNumber(item?.authority)));
        const chart = new Chart(canvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [authority, 100 - authority],
                    backgroundColor: ['#0ea5e9', '#1e293b'],
                    borderWidth: 0,
                    hoverOffset: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '82%',
                animation: { duration: 700 },
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false },
                },
            },
        });

        chartInstances.set(index, chart);
    }

    function setScanning(scanning) {
        isScanning = scanning;
        scanButton.disabled = scanning;
        scanSpinner.classList.toggle('hidden', !scanning);
        scanIcon.classList.toggle('hidden', scanning);
        scanText.textContent = scanning ? 'Scanning...' : 'Scan Domains';
        loading.classList.toggle('hidden', !scanning);
    }

    function startTimer() {
        scanStartedAt = Date.now();
        clearInterval(timerId);

        timerId = setInterval(() => {
            const seconds = Math.floor((Date.now() - scanStartedAt) / 1000);
            const minutes = String(Math.floor(seconds / 60)).padStart(2, '0');
            const remainder = String(seconds % 60).padStart(2, '0');
            scanElapsed.textContent = `${minutes}:${remainder}`;
        }, 500);
    }

    function stopTimer() {
        clearInterval(timerId);
        timerId = null;
    }

    async function copyText(text, button = null) {
        try {
            await navigator.clipboard.writeText(text);
            if (button) {
                const previous = button.textContent;
                button.textContent = 'Copied';
                setTimeout(() => button.textContent = previous, 1200);
            }
        } catch {
            alert('Teks tidak dapat disalin.');
        }
    }

    async function scanDomains() {
        if (isScanning) return;

        const domains = getDomains();
        if (domains.length === 0) {
            domainsInput.focus();
            alert('Masukkan minimal satu domain.');
            return;
        }

        domainsInput.value = domains.join('\n');
        updateDomainCount();
        destroyCharts();
        setScanning(true);
        startTimer();
        loadingMessage.textContent = `Memindai ${domains.length} domain dan mengumpulkan metrik...`;
        resultContainer.innerHTML = '';

        try {
            const response = await fetch(checkUrl, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ domains: domains.join('\n') }),
            });

            let data;
            try {
                data = await response.json();
            } catch {
                throw new Error(`Server mengembalikan respons tidak valid (${response.status}).`);
            }

            if (!response.ok) {
                throw new Error(data?.message ?? 'Scan domain gagal.');
            }

            if (!Array.isArray(data)) {
                throw new Error(data?.message ?? 'Format respons tidak sesuai.');
            }

            latestResults = data;

            if (data.length === 0) {
                resultContainer.innerHTML = `
                    <div class="rounded-2xl border border-amber-500/20 bg-amber-500/5 p-8 text-center">
                        <div class="text-lg font-bold text-amber-300">Tidak ada data ditemukan</div>
                        <p class="mt-2 text-sm text-slate-500">Coba periksa penulisan domain atau ulangi beberapa saat lagi.</p>
                    </div>
                `;
                return;
            }

            resultContainer.innerHTML = `
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-black text-white">Scan Results</h2>
                        <p class="mt-1 text-sm text-slate-500">${data.length} domain berhasil diproses.</p>
                    </div>
                    <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-300">Completed</div>
                </div>
                ${data.map(renderDomainCard).join('')}
            `;

            resultContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (error) {
            console.error(error);
            resultContainer.innerHTML = `
                <div class="rounded-2xl border border-red-500/20 bg-red-500/5 p-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500/10 text-red-400">!</div>
                        <div>
                            <div class="font-bold text-red-300">Scan gagal</div>
                            <div class="mt-1 text-sm leading-6 text-slate-400">${escapeHtml(error.message ?? 'Terjadi kesalahan.')}</div>
                        </div>
                    </div>
                </div>
            `;
        } finally {
            stopTimer();
            setScanning(false);
        }
    }

    domainsInput.addEventListener('input', updateDomainCount);

    domainsInput.addEventListener('keydown', event => {
        if (event.ctrlKey && event.key === 'Enter') {
            event.preventDefault();
            scanDomains();
        }
    });

    sampleButton.addEventListener('click', () => {
        domainsInput.value = ['google.com', 'openai.com', 'github.com'].join('\n');
        updateDomainCount();
        domainsInput.focus();
    });

    clearButton.addEventListener('click', () => {
        domainsInput.value = '';
        updateDomainCount();
        domainsInput.focus();
    });

    scanButton.addEventListener('click', scanDomains);

    resultContainer.addEventListener('click', event => {
        const copyButton = event.target.closest('.copy-btn');
        if (copyButton) {
            copyText(copyButton.dataset.copy ?? '', copyButton);
            return;
        }

        const toggleButton = event.target.closest('.toggle-detail');
        if (!toggleButton) return;

        const card = document.getElementById(toggleButton.dataset.target);
        const detail = card?.querySelector('.detail-box');
        if (!detail) return;

        const isOpening = detail.classList.contains('hidden');
        detail.classList.toggle('hidden');
        toggleButton.querySelector('span').textContent = isOpening ? 'Hide Detail' : 'Detail';
        toggleButton.querySelector('.detail-chevron')?.classList.toggle('rotate-180', isOpening);

        if (isOpening) {
            const index = Number(toggleButton.dataset.index);
            createChart(index, toggleButton.dataset.chart, latestResults[index]);
        }
    });

    resultContainer.addEventListener('input', event => {
        const search = event.target.closest('.page-search');
        if (!search) return;

        const card = document.getElementById(search.dataset.card);
        const keyword = search.value.trim().toLowerCase();

        card?.querySelectorAll('.page-row').forEach(row => {
            row.classList.toggle('hidden', !row.dataset.search.includes(keyword));
        });
    });

    updateDomainCount();
});
</script>
@endpush