@extends('layouts.admin')

@section('title', 'Ads')

@section('page-title', 'Ads Management')

@section('content')

<div class="flex items-center justify-between mb-6">

    <div>
        <h2 class="text-2xl font-bold text-white">
            Ads Management
        </h2>

        <p class="text-slate-400 mt-1">
            Kelola seluruh banner promosi website.
        </p>
    </div>

    <a href="{{ route('admin.ads.create') }}"
       class="rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700 transition">

        + Tambah Ads

    </a>

</div>

<div class="overflow-hidden rounded-2xl bg-slate-900">

    <table class="w-full">

        <thead class="bg-slate-800">

            <tr>

                <th class="px-5 py-4 text-left">#</th>
                <th class="px-5 py-4 text-left">Nama</th>
                <th class="px-5 py-4 text-left">Posisi</th>
                <th class="px-5 py-4 text-left">Status</th>
                <th class="px-5 py-4 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($ads as $ad)

            <tr class="border-t border-slate-800">

                <td class="px-5 py-4">
                    {{ $ad->id }}
                </td>

                <td class="px-5 py-4">
                    {{ $ad->name }}
                </td>

                <td class="px-5 py-4 capitalize">
                    {{ $ad->position }}
                </td>

                <td class="px-5 py-4">

                    @if($ad->is_active)

                        <span class="rounded-full bg-green-600 px-3 py-1 text-sm">
                            Active
                        </span>

                    @else

                        <span class="rounded-full bg-red-600 px-3 py-1 text-sm">
                            Inactive
                        </span>

                    @endif

                </td>

                <td class="px-5 py-4 text-center">

                    <a href="{{ route('admin.ads.edit',$ad->id) }}"
                       class="rounded-lg bg-yellow-500 px-4 py-2 text-black hover:bg-yellow-400">

                        Edit

                    </a>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5" class="py-10 text-center text-slate-400">

                    Belum ada Ads.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection