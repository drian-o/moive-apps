@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Website Settings')

@section('page-title', 'Website Settings')

@section('content')

@if(session('success'))
<div class="mb-6 rounded-xl border border-green-600 bg-green-600/20 p-4 text-green-300">
    {{ session('success') }}
</div>
@endif

<form
    action="{{ route('admin.settings.update') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <div class="grid gap-6">

        {{-- GENERAL --}}
        <div class="rounded-2xl bg-slate-900 p-8">

            <h2 class="mb-6 text-2xl font-bold">
                General Settings
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Website Name
                    </label>

                    <input
                        type="text"
                        name="site_name"
                        value="{{ old('site_name', $setting->site_name) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                </div>

                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Website Title
                    </label>

                    <input
                        type="text"
                        name="site_title"
                        value="{{ old('site_title', $setting->site_title) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                </div>

            </div>

            <div class="mt-6">

                <label class="mb-2 block text-sm text-slate-300">
                    Website Description
                </label>

                <textarea
                    name="site_description"
                    rows="4"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-4 text-white">{{ old('site_description', $setting->site_description) }}</textarea>

            </div>

            <div class="mt-6">

                <label class="mb-2 block text-sm text-slate-300">
                    Website Keywords
                </label>

                <textarea
                    name="site_keywords"
                    rows="3"
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 p-4 text-white">{{ old('site_keywords', $setting->site_keywords) }}</textarea>

            </div>

        </div>

        {{-- BRANDING --}}
        <div class="rounded-2xl bg-slate-900 p-8">

            <h2 class="mb-6 text-2xl font-bold">
                Branding
            </h2>

            <div class="grid gap-8 md:grid-cols-2">

                {{-- LOGO --}}
                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Logo
                    </label>

                    <input
                        type="file"
                        name="logo"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">

                    @if($setting->logo)

                        <div class="mt-4">

                            <img
                                src="{{ Storage::url($setting->logo) }}"
                                class="h-20 rounded-lg border border-slate-700 bg-white p-2">

                            <p class="mt-2 text-xs text-slate-500">
                                {{ $setting->logo }}
                            </p>

                        </div>

                    @endif

                </div>

                {{-- FAVICON --}}
                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Favicon
                    </label>

                    <input
                        type="file"
                        name="favicon"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 p-3">

                    @if($setting->favicon)

                        <div class="mt-4">

                            <img
                                src="{{ Storage::url($setting->favicon) }}"
                                class="h-14 rounded-lg border border-slate-700 bg-white p-2">

                            <p class="mt-2 text-xs text-slate-500">
                                {{ $setting->favicon }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- CONTACT --}}
        <div class="rounded-2xl bg-slate-900 p-8">

            <h2 class="mb-6 text-2xl font-bold">
                Contact
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $setting->email) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                </div>

                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Telegram
                    </label>

                    <input
                        type="text"
                        name="telegram"
                        value="{{ old('telegram', $setting->telegram) }}"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                </div>

            </div>

        </div>

        {{-- SOCIAL --}}
        <div class="rounded-2xl bg-slate-900 p-8">

            <h2 class="mb-6 text-2xl font-bold">
                Social Media
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <input
                    type="text"
                    name="facebook"
                    value="{{ old('facebook', $setting->facebook) }}"
                    placeholder="Facebook"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3">

                <input
                    type="text"
                    name="instagram"
                    value="{{ old('instagram', $setting->instagram) }}"
                    placeholder="Instagram"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3">

                <input
                    type="text"
                    name="twitter"
                    value="{{ old('twitter', $setting->twitter) }}"
                    placeholder="Twitter"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3">

                <input
                    type="text"
                    name="youtube"
                    value="{{ old('youtube', $setting->youtube) }}"
                    placeholder="Youtube"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3">

                <input
                    type="text"
                    name="discord"
                    value="{{ old('discord', $setting->discord) }}"
                    placeholder="Discord"
                    class="rounded-xl border border-slate-700 bg-slate-800 px-4 py-3">

            </div>

        </div>

        {{-- THEME --}}
        <div class="rounded-2xl bg-slate-900 p-8">

            <h2 class="mb-6 text-2xl font-bold">
                Theme
            </h2>

            <div class="grid gap-6 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm text-slate-300">
                        Theme Color
                    </label>

                    <input
                        type="color"
                        name="theme_color"
                        value="{{ old('theme_color', $setting->theme_color) }}"
                        class="h-14 w-full rounded-xl border border-slate-700 bg-slate-800">

                </div>

                <div class="flex items-center gap-3 pt-8">

                    <input
                        type="checkbox"
                        name="maintenance"
                        value="1"
                        {{ $setting->maintenance ? 'checked' : '' }}>

                    <span>
                        Maintenance Mode
                    </span>

                </div>

            </div>

        </div>

        <button
            type="submit"
            class="rounded-xl bg-blue-600 py-4 text-lg font-bold transition hover:bg-blue-700">

            💾 Save Website Settings

        </button>

    </div>

</form>

@endsection