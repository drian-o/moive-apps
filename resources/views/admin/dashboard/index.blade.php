@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">

    <div class="rounded-2xl bg-slate-900 p-6">
        <p class="text-slate-400">Anime</p>
        <h3 class="mt-2 text-4xl font-black">
            {{ number_format($animeCount) }}
        </h3>
    </div>

    <div class="rounded-2xl bg-slate-900 p-6">
        <p class="text-slate-400">Donghua</p>
        <h3 class="mt-2 text-4xl font-black">
            {{ number_format($donghuaCount) }}
        </h3>
    </div>

    <div class="rounded-2xl bg-slate-900 p-6">
        <p class="text-slate-400">Comic</p>
        <h3 class="mt-2 text-4xl font-black">
            {{ number_format($comicCount) }}
        </h3>
    </div>

    <div class="rounded-2xl bg-slate-900 p-6">
        <p class="text-slate-400">Users</p>
        <h3 class="mt-2 text-4xl font-black">
            {{ number_format($userCount) }}
        </h3>
    </div>

    <div class="rounded-2xl bg-slate-900 p-6">
        <p class="text-slate-400">Visitors</p>
        <h3 class="mt-2 text-4xl font-black">
            {{ number_format($visitorCount) }}
        </h3>
    </div>

</div>

<div class="mt-8 grid gap-6 xl:grid-cols-2">

    <div class="rounded-2xl bg-slate-900 p-6">

        <h3 class="mb-5 text-xl font-bold">
            Recent Activity
        </h3>

        <div class="space-y-4 text-slate-300">

            <div>✅ Admin Login</div>
            <div>✅ Database Connected</div>
            <div>✅ API Ready</div>
            <div>✅ System Online</div>

        </div>

    </div>

    <div class="rounded-2xl bg-slate-900 p-6">

        <h3 class="mb-5 text-xl font-bold">
            Server Status
        </h3>

        <div class="space-y-4 text-slate-300">

            <div>PHP 8.2</div>
            <div>Laravel 12</div>
            <div>MySQL Connected</div>
            <div>Storage OK</div>

        </div>

    </div>

</div>

@endsection