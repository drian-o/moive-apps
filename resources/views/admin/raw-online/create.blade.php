@extends('layouts.admin')

@section('title', 'Buat Raw Paste')
@section('page-title', 'Buat Raw Paste')

@section('content')
<div class="mx-auto w-full max-w-[1700px]">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-fuchsia-500 via-violet-500 to-indigo-600 shadow-lg shadow-violet-950/40">
                    <x-heroicon-o-code-bracket-square class="relative z-10 h-6 w-6 text-white"/>
                </div>

                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white">
                        Buat Raw Paste
                    </h1>

                    <p class="text-sm text-slate-500">
                        New Paste Workspace
                    </p>
                </div>
            </div>

            <p class="max-w-3xl text-sm leading-6 text-slate-400">
                Tempelkan kode atau teks, pilih visibilitas, lalu simpan untuk mendapatkan URL RAW.
            </p>
        </div>

        <a
            href="{{ route('admin.raw-online.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-bold text-slate-300 transition hover:bg-slate-800 hover:text-white"
        >
            <x-heroicon-o-arrow-left class="h-4 w-4"/>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-5 rounded-2xl border border-red-500/20 bg-red-500/10 p-4">
            <p class="text-sm font-bold text-red-300">
                Beberapa data belum valid.
            </p>

            <ul class="mt-2 space-y-1 text-sm text-red-200/70">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('admin.raw-online._form', [
        'mode' => 'create',
        'action' => route('admin.raw-online.store'),
        'rawPaste' => null,
    ])
</div>
@endsection
