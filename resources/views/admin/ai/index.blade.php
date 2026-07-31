@extends('layouts.admin')

@section('title', 'AI Assistant')
@section('page-title', 'AI Assistant')

@section('content')
<div
    id="ai-assistant"
    data-chat-url="{{ route('admin.ai.chat') }}"
    class="mx-auto w-full max-w-[1500px]"
>
    {{-- Page heading --}}
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 shadow-lg shadow-violet-950/40">
                    <x-heroicon-o-sparkles class="relative z-10 h-6 w-6 text-white"/>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-white/20"></div>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        AI Assistant
                    </h1>

                    <p class="text-sm text-slate-500">
                        Powered by Gemini AI
                    </p>
                </div>
            </div>

            <p class="max-w-2xl text-sm leading-6 text-slate-400">
                Tanyakan apa saja atau unggah gambar dan PDF untuk dianalisis
                langsung oleh AI.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <div class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-2">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-40"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>

                <span class="text-xs font-semibold text-emerald-400">
                    AI Online
                </span>
            </div>

            <div class="rounded-xl border border-violet-500/20 bg-violet-500/10 px-3 py-2 text-xs font-semibold text-violet-300">
                Gemini AI
            </div>
        </div>
    </div>

    {{-- Main container --}}
    <div class="relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-2xl shadow-black/30">

        {{-- Decorative background --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-violet-600/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-32 h-80 w-80 rounded-full bg-indigo-600/10 blur-3xl"></div>
        </div>

        {{-- Window header --}}
        <div class="relative flex flex-col gap-4 border-b border-slate-800 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                </div>

                <div class="hidden h-6 w-px bg-slate-700 sm:block"></div>

                <div>
                    <h2 class="font-bold text-white">
                        AI Workspace
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500">
                        Chat, analisis gambar, dan dokumen PDF
                    </p>
                </div>
            </div>

            <div
                id="ai-status"
                class="flex w-fit items-center gap-2 rounded-full border border-slate-700 bg-slate-950/60 px-3 py-1.5"
            >
                <span
                    id="ai-status-dot"
                    class="h-2 w-2 rounded-full bg-emerald-500"
                ></span>

                <span
                    id="ai-status-text"
                    class="text-xs font-semibold text-slate-400"
                >
                    Siap menerima perintah
                </span>
            </div>
        </div>

        {{-- Workspace --}}
        <div class="relative grid min-h-[680px] grid-cols-1 xl:grid-cols-[44%_56%]">

            {{-- Left: Input --}}
            <section class="border-b border-slate-800 p-5 sm:p-6 xl:border-b-0 xl:border-r">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-white">
                            Tulis Pertanyaan
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            Jelaskan kebutuhanmu secara detail.
                        </p>
                    </div>

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400">
                        <x-heroicon-o-chat-bubble-left-right class="h-5 w-5"/>
                    </div>
                </div>

                {{-- Message input --}}
                <div class="group relative">
                    <div class="pointer-events-none absolute inset-0 rounded-2xl bg-gradient-to-r from-violet-500/0 via-violet-500/10 to-indigo-500/0 opacity-0 blur transition group-focus-within:opacity-100"></div>

                    <textarea
                        id="message"
                        rows="11"
                        maxlength="10000"
                        class="relative w-full resize-none rounded-2xl border border-slate-700/80 bg-slate-950/70 p-5 text-sm leading-7 text-white outline-none transition placeholder:text-slate-600 focus:border-violet-500/70 focus:ring-4 focus:ring-violet-500/10"
                        placeholder="Contoh: Analisis gambar ini dan jelaskan bagian penting yang perlu saya perhatikan..."
                    ></textarea>

                    <div class="absolute bottom-3 right-4 text-[11px] text-slate-600">
                        <span id="character-count">0</span>/10.000
                    </div>
                </div>

                {{-- Shortcut info --}}
                <div class="mt-2 flex items-center justify-between px-1 text-[11px] text-slate-600">
                    <span>
                        Gunakan bahasa yang jelas untuk hasil terbaik.
                    </span>

                    <span class="hidden sm:inline">
                        <kbd class="rounded border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-slate-400">
                            Ctrl
                        </kbd>
                        +
                        <kbd class="rounded border border-slate-700 bg-slate-800 px-1.5 py-0.5 text-slate-400">
                            Enter
                        </kbd>
                    </span>
                </div>

                {{-- Upload section --}}
                <div class="mt-6">
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-white">
                                Lampiran
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                Gambar atau PDF, maksimal 10 MB.
                            </p>
                        </div>

                        <span class="rounded-md bg-slate-800 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            Opsional
                        </span>
                    </div>

                    <label
                        id="drop-zone"
                        for="file"
                        class="group flex min-h-[145px] cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-950/40 px-6 py-6 text-center transition hover:border-violet-500/60 hover:bg-violet-500/5"
                    >
                        <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800/80 transition group-hover:border-violet-500/30 group-hover:bg-violet-500/10">
                            <x-heroicon-o-arrow-up-tray class="h-6 w-6 text-slate-400 transition group-hover:text-violet-400"/>
                        </div>

                        <p class="text-sm font-semibold text-slate-300">
                            Klik atau tarik file ke sini
                        </p>

                        <p class="mt-1 text-xs text-slate-600">
                            PNG, JPG, WEBP, atau PDF
                        </p>
                    </label>

                    <input
                        id="file"
                        name="file"
                        type="file"
                        accept="image/png,image/jpeg,image/webp,image/gif,application/pdf"
                        class="hidden"
                    />

                    {{-- File preview --}}
                    <div
                        id="file-preview"
                        class="mt-3 hidden items-center gap-3 rounded-2xl border border-slate-700 bg-slate-950/60 p-3"
                    >
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-500/10">
                            <x-heroicon-o-document-text
                                id="file-preview-icon"
                                class="h-5 w-5 text-violet-400"
                            />
                        </div>

                        <div class="min-w-0 flex-1">
                            <p
                                id="file-name"
                                class="truncate text-sm font-semibold text-white"
                            ></p>

                            <p
                                id="file-size"
                                class="mt-0.5 text-xs text-slate-500"
                            ></p>
                        </div>

                        <button
                            id="remove-file"
                            type="button"
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-500 transition hover:bg-red-500/10 hover:text-red-400"
                            title="Hapus file"
                        >
                            <x-heroicon-o-x-mark class="h-5 w-5"/>
                        </button>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <button
                        id="send"
                        type="button"
                        class="group relative flex flex-1 items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-violet-950/40 transition hover:-translate-y-0.5 hover:from-violet-500 hover:to-indigo-500 hover:shadow-violet-950/60 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <span class="absolute inset-0 translate-x-[-120%] bg-gradient-to-r from-transparent via-white/15 to-transparent transition duration-700 group-hover:translate-x-[120%]"></span>

                        <svg
                            id="send-spinner"
                            class="relative hidden h-5 w-5 animate-spin"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                            ></path>
                        </svg>

                        <x-heroicon-o-paper-airplane
                            id="send-icon"
                            class="relative h-5 w-5"
                        />

                        <span id="send-text" class="relative">
                            Kirim ke AI
                        </span>
                    </button>

                    <button
                        id="reset-input"
                        type="button"
                        class="flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-800/70 px-5 py-3.5 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white"
                    >
                        <x-heroicon-o-arrow-path class="h-5 w-5"/>
                        Reset
                    </button>
                </div>
            </section>

            {{-- Right: Response --}}
            <section class="flex min-h-[580px] flex-col bg-slate-950/35">
                <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-500/10">
                            <x-heroicon-o-sparkles class="h-5 w-5 text-indigo-400"/>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-white">
                                AI Response
                            </h3>

                            <p
                                id="response-meta"
                                class="mt-0.5 text-[11px] text-slate-600"
                            >
                                Belum ada permintaan
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            id="copy-response"
                            type="button"
                            class="flex h-9 items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 text-xs font-semibold text-slate-400 transition hover:border-indigo-500/40 hover:text-indigo-400 disabled:cursor-not-allowed disabled:opacity-40"
                            disabled
                        >
                            <x-heroicon-o-clipboard class="h-4 w-4"/>
                            <span class="hidden sm:inline">Copy</span>
                        </button>

                        <button
                            id="clear-response"
                            type="button"
                            class="flex h-9 items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 text-xs font-semibold text-slate-400 transition hover:border-red-500/40 hover:text-red-400"
                        >
                            <x-heroicon-o-trash class="h-4 w-4"/>
                            <span class="hidden sm:inline">Clear</span>
                        </button>
                    </div>
                </div>

                <div class="relative flex flex-1 p-4 sm:p-6">
                    <div
                        class="pointer-events-none absolute inset-0 opacity-[0.025]"
                        style="
                            background-image:
                                linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px),
                                linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px);
                            background-size: 28px 28px;
                        "
                    ></div>

                    <div
                        id="response-container"
                        class="relative flex min-h-[470px] w-full flex-col rounded-2xl border border-slate-800 bg-slate-950/75 shadow-inner shadow-black/40"
                    >
                        {{-- Empty state --}}
                        <div
                            id="empty-response"
                            class="flex flex-1 flex-col items-center justify-center px-6 py-14 text-center"
                        >
                            <div class="relative mb-5">
                                <div class="absolute inset-0 rounded-full bg-violet-500/20 blur-2xl"></div>

                                <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl border border-violet-500/20 bg-gradient-to-br from-violet-500/15 to-indigo-500/10">
                                    <x-heroicon-o-sparkles class="h-8 w-8 text-violet-400"/>
                                </div>
                            </div>

                            <h4 class="text-base font-bold text-slate-300">
                                Siap membantumu
                            </h4>

                            <p class="mt-2 max-w-sm text-sm leading-6 text-slate-600">
                                Masukkan pertanyaan atau unggah file, lalu tekan
                                tombol Kirim ke AI.
                            </p>

                            <div class="mt-6 grid w-full max-w-md grid-cols-1 gap-2 sm:grid-cols-2">
                                <button
                                    type="button"
                                    data-prompt="Buatkan ide artikel SEO yang menarik untuk website saya."
                                    class="prompt-example rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-3 text-left text-xs text-slate-500 transition hover:border-violet-500/30 hover:text-violet-300"
                                >
                                    Buat ide artikel SEO
                                </button>

                                <button
                                    type="button"
                                    data-prompt="Analisis konten ini dan berikan saran untuk meningkatkannya."
                                    class="prompt-example rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-3 text-left text-xs text-slate-500 transition hover:border-violet-500/30 hover:text-violet-300"
                                >
                                    Analisis konten
                                </button>
                            </div>
                        </div>

                        {{-- Loading state --}}
                        <div
                            id="loading-response"
                            class="hidden flex-1 flex-col items-center justify-center px-6 py-14 text-center"
                        >
                            <div class="relative mb-5 flex h-16 w-16 items-center justify-center">
                                <span class="absolute h-16 w-16 animate-ping rounded-full bg-violet-500/10"></span>

                                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-indigo-600 shadow-lg shadow-violet-950/50">
                                    <x-heroicon-o-sparkles class="h-7 w-7 animate-pulse text-white"/>
                                </div>
                            </div>

                            <h4 class="text-sm font-bold text-white">
                                AI sedang berpikir...
                            </h4>

                            <p class="mt-2 text-xs text-slate-500">
                                Permintaanmu sedang dianalisis.
                            </p>

                            <div class="mt-5 flex items-center gap-1.5">
                                <span class="h-2 w-2 animate-bounce rounded-full bg-violet-400"></span>
                                <span class="h-2 w-2 animate-bounce rounded-full bg-violet-400 [animation-delay:150ms]"></span>
                                <span class="h-2 w-2 animate-bounce rounded-full bg-violet-400 [animation-delay:300ms]"></span>
                            </div>
                        </div>

                        {{-- Actual response --}}
                        <div
                            id="result"
                            class="hidden flex-1 whitespace-pre-wrap break-words p-5 text-sm leading-7 text-slate-300 sm:p-6"
                        ></div>
                    </div>
                </div>

                {{-- Response footer --}}
                <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-800 px-5 py-3 text-[11px] text-slate-600 sm:px-6">
                    <span>
                        Respons AI dapat mengandung kesalahan. Periksa kembali informasi penting.
                    </span>

                    <span>
                        Gemini AI
                    </span>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('ai-assistant');

    if (!app) {
        return;
    }

    const chatUrl = app.dataset.chatUrl;

    const messageInput = document.getElementById('message');
    const characterCount = document.getElementById('character-count');

    const fileInput = document.getElementById('file');
    const dropZone = document.getElementById('drop-zone');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFileButton = document.getElementById('remove-file');

    const sendButton = document.getElementById('send');
    const sendText = document.getElementById('send-text');
    const sendIcon = document.getElementById('send-icon');
    const sendSpinner = document.getElementById('send-spinner');
    const resetInputButton = document.getElementById('reset-input');

    const emptyResponse = document.getElementById('empty-response');
    const loadingResponse = document.getElementById('loading-response');
    const result = document.getElementById('result');
    const responseMeta = document.getElementById('response-meta');

    const copyResponseButton = document.getElementById('copy-response');
    const clearResponseButton = document.getElementById('clear-response');

    const statusDot = document.getElementById('ai-status-dot');
    const statusText = document.getElementById('ai-status-text');

    let selectedFile = null;
    let isSending = false;

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    function formatFileSize(bytes) {
        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    function isValidFile(file) {
        const allowedTypes = [
            'image/png',
            'image/jpeg',
            'image/webp',
            'image/gif',
            'application/pdf',
        ];

        return allowedTypes.includes(file.type);
    }

    function setStatus(text, state = 'ready') {
        const colors = {
            ready: 'bg-emerald-500',
            loading: 'bg-violet-500 animate-pulse',
            success: 'bg-sky-500',
            error: 'bg-red-500',
        };

        statusText.textContent = text;
        statusDot.className =
            `h-2 w-2 rounded-full ${colors[state] ?? colors.ready}`;
    }

    function showEmptyResponse() {
        emptyResponse.classList.remove('hidden');
        emptyResponse.classList.add('flex');

        loadingResponse.classList.add('hidden');
        loadingResponse.classList.remove('flex');

        result.classList.add('hidden');
        result.textContent = '';

        copyResponseButton.disabled = true;
        responseMeta.textContent = 'Belum ada permintaan';
    }

    function showLoadingResponse() {
        emptyResponse.classList.add('hidden');
        emptyResponse.classList.remove('flex');

        result.classList.add('hidden');

        loadingResponse.classList.remove('hidden');
        loadingResponse.classList.add('flex');

        copyResponseButton.disabled = true;
        responseMeta.textContent = 'Memproses permintaan...';
    }

    function showResult(text, isError = false) {
        emptyResponse.classList.add('hidden');
        emptyResponse.classList.remove('flex');

        loadingResponse.classList.add('hidden');
        loadingResponse.classList.remove('flex');

        result.classList.remove('hidden');
        result.textContent = text;

        result.classList.toggle('text-red-300', isError);
        result.classList.toggle('text-slate-300', !isError);

        copyResponseButton.disabled = isError || !text;

        responseMeta.textContent = isError
            ? 'Terjadi kesalahan'
            : `Selesai · ${new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
            })}`;
    }

    function displayFile(file) {
        if (!isValidFile(file)) {
            alert('File harus berupa PNG, JPG, WEBP, GIF, atau PDF.');
            return;
        }

        const maximumSize = 10 * 1024 * 1024;

        if (file.size > maximumSize) {
            alert('Ukuran file maksimal 10 MB.');
            return;
        }

        selectedFile = file;

        fileName.textContent = file.name;
        fileSize.textContent =
            `${formatFileSize(file.size)} · ${file.type || 'File'}`;

        filePreview.classList.remove('hidden');
        filePreview.classList.add('flex');
    }

    function clearFile() {
        selectedFile = null;
        fileInput.value = '';

        fileName.textContent = '';
        fileSize.textContent = '';

        filePreview.classList.add('hidden');
        filePreview.classList.remove('flex');
    }

    function setSendingState(sending) {
        isSending = sending;
        sendButton.disabled = sending;
        resetInputButton.disabled = sending;

        sendText.textContent = sending
            ? 'Sedang memproses...'
            : 'Kirim ke AI';

        sendSpinner.classList.toggle('hidden', !sending);
        sendIcon.classList.toggle('hidden', sending);
    }

    async function sendMessage() {
        if (isSending) {
            return;
        }

        const message = messageInput.value.trim();

        if (!message && !selectedFile) {
            messageInput.focus();
            setStatus('Masukkan pesan atau file', 'error');
            return;
        }

        const formData = new FormData();

        formData.append('message', message);

        if (selectedFile) {
            formData.append('file', selectedFile);
        }

        setSendingState(true);
        showLoadingResponse();
        setStatus('AI sedang memproses', 'loading');

        const startedAt = performance.now();

        try {
            const response = await fetch(chatUrl, {
                method: 'POST',

                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },

                body: formData,
            });

            let json;

            try {
                json = await response.json();
            } catch {
                throw new Error(
                    `Server mengembalikan respons tidak valid (${response.status}).`
                );
            }

            if (!response.ok || !json.success) {
                throw new Error(
                    json.message ?? 'Terjadi kesalahan saat memproses permintaan.'
                );
            }

            const elapsed = (
                (performance.now() - startedAt) / 1000
            ).toFixed(1);

            showResult(json.reply ?? 'AI tidak memberikan respons.');
            responseMeta.textContent = `Selesai dalam ${elapsed} detik`;

            setStatus('Respons berhasil dibuat', 'success');
        } catch (error) {
            console.error(error);

            showResult(
                error.message ?? 'Tidak dapat terhubung ke layanan AI.',
                true
            );

            setStatus('Permintaan gagal', 'error');
        } finally {
            setSendingState(false);
        }
    }

    messageInput.addEventListener('input', () => {
        characterCount.textContent =
            messageInput.value.length.toLocaleString('id-ID');
    });

    messageInput.addEventListener('keydown', event => {
        if (event.ctrlKey && event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    });

    fileInput.addEventListener('change', () => {
        const file = fileInput.files?.[0];

        if (file) {
            displayFile(file);
        }
    });

    removeFileButton.addEventListener('click', clearFile);

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, event => {
            event.preventDefault();

            dropZone.classList.add(
                'border-violet-500',
                'bg-violet-500/10'
            );
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, event => {
            event.preventDefault();

            dropZone.classList.remove(
                'border-violet-500',
                'bg-violet-500/10'
            );
        });
    });

    dropZone.addEventListener('drop', event => {
        const file = event.dataTransfer.files?.[0];

        if (file) {
            displayFile(file);
        }
    });

    sendButton.addEventListener('click', sendMessage);

    resetInputButton.addEventListener('click', () => {
        messageInput.value = '';
        characterCount.textContent = '0';

        clearFile();
        messageInput.focus();

        setStatus('Input berhasil direset', 'ready');
    });

    copyResponseButton.addEventListener('click', async () => {
        const text = result.textContent.trim();

        if (!text) {
            return;
        }

        try {
            await navigator.clipboard.writeText(text);

            const previousText =
                copyResponseButton.querySelector('span')?.textContent;

            const label =
                copyResponseButton.querySelector('span');

            if (label) {
                label.textContent = 'Copied';
            }

            setTimeout(() => {
                if (label) {
                    label.textContent = previousText || 'Copy';
                }
            }, 1500);
        } catch {
            alert('Respons tidak dapat disalin.');
        }
    });

    clearResponseButton.addEventListener('click', () => {
        showEmptyResponse();
        setStatus('Respons dibersihkan', 'ready');
    });

    document
        .querySelectorAll('.prompt-example')
        .forEach(button => {
            button.addEventListener('click', () => {
                messageInput.value = button.dataset.prompt ?? '';
                characterCount.textContent =
                    messageInput.value.length.toLocaleString('id-ID');

                messageInput.focus();
            });
        });

    showEmptyResponse();
});
</script>
@endpush