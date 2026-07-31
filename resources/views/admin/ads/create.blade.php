@extends('layouts.admin')

@section('title', 'Tambah Ads')

@section('page-title', 'Tambah Ads')

@section('content')

<div class="max-w-4xl">

    <div class="rounded-2xl bg-slate-900 p-6">

        <h2 class="mb-6 text-2xl font-bold">
            Tambah Banner Promosi
        </h2>

        <form method="POST"
              action="{{ route('admin.ads.store') }}"
              enctype="multipart/form-data">

            @csrf

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-500 bg-red-600/20 p-4">
                    <ul class="list-disc pl-5 text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-6">

                <div>
                    <label class="mb-2 block">Nama Banner</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3"
                        required>
                </div>

                <div>
                    <label class="mb-2 block">Posisi</label>

                    <select
                        name="position"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">

                        <option value="sidebar" {{ old('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        <option value="player" {{ old('position') == 'player' ? 'selected' : '' }}>Player</option>
                        <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                        <option value="popup" {{ old('position') == 'popup' ? 'selected' : '' }}>Popup</option>
                        <option value="floating" {{ old('position') == 'floating' ? 'selected' : '' }}>Floating</option>

                    </select>
                </div>

                <div>
                    <label class="mb-2 block">Gambar Banner</label>

                    <input
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3"
                        required>
                </div>

                <div>
                    <label class="mb-2 block">URL Tujuan</label>

                    <input
                        type="url"
                        name="url"
                        value="{{ old('url') }}"
                        placeholder="https://example.com"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">
                </div>

                <div>
                    <label class="mb-2 block">Urutan</label>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 0) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">
                </div>

                <div>
                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}>

                        Aktif

                    </label>
                </div>

                <button
                    type="submit"
                    class="rounded-xl bg-sky-600 py-3 font-bold transition hover:bg-sky-700">

                    Simpan Banner

                </button>

            </div>

        </form>

    </div>

</div>

@endsection