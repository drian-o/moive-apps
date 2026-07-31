@extends('layouts.admin')

@section('title', 'Edit Ads')

@section('page-title', 'Edit Ads')

@section('content')

<div class="max-w-4xl">

    <div class="rounded-2xl bg-slate-900 p-6">

        <h2 class="mb-6 text-2xl font-bold">
            Edit Banner Promosi
        </h2>

        <form method="POST"
              action="{{ route('admin.ads.update', $ad->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid gap-6">

                <div>
                    <label class="mb-2 block">Nama Banner</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $ad->name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3"
                        required>
                </div>

                <div>
                    <label class="mb-2 block">Posisi</label>

                    <select
                        name="position"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">

                        <option value="sidebar" {{ $ad->position=='sidebar'?'selected':'' }}>Sidebar</option>
                        <option value="player" {{ $ad->position=='player'?'selected':'' }}>Player</option>
                        <option value="footer" {{ $ad->position=='footer'?'selected':'' }}>Footer</option>
                        <option value="popup" {{ $ad->position=='popup'?'selected':'' }}>Popup</option>
                        <option value="floating" {{ $ad->position=='floating'?'selected':'' }}>Floating</option>

                    </select>
                </div>

                <div>
                    <label class="mb-2 block">Banner Saat Ini</label>

                    @if($ad->image)
                        <img
                            src="{{ asset('storage/'.$ad->image) }}"
                            class="mb-3 h-32 rounded-lg border border-slate-700">
                    @endif

                    <input
                        type="file"
                        name="image"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">
                </div>

                <div>
                    <label class="mb-2 block">URL Tujuan</label>

                    <input
                        type="text"
                        name="url"
                        value="{{ old('url', $ad->url) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">
                </div>

                <div>
                    <label class="mb-2 block">Target</label>

                    <select
                        name="target"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">

                        <option value="_blank" {{ $ad->target=='_blank'?'selected':'' }}>
                            Tab Baru
                        </option>

                        <option value="_self" {{ $ad->target=='_self'?'selected':'' }}>
                            Tab Sama
                        </option>

                    </select>
                </div>

                <div>
                    <label class="mb-2 block">Urutan</label>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $ad->sort_order) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">
                </div>

                <div>

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $ad->is_active ? 'checked' : '' }}>

                        Aktif

                    </label>

                </div>

                <button
                    class="rounded-xl bg-green-600 py-3 font-bold hover:bg-green-700">

                    Update Banner

                </button>

            </div>

        </form>

    </div>

</div>

@endsection