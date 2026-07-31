@extends('layouts.admin')

@section('title', 'Domain Nawala')

@section('content')

<div class="space-y-8">
    <div class="relative overflow-hidden rounded-3xl border border-cyan-500/20 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-950 shadow-2xl">
        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-cyan-500/10 blur-3xl"></div>
        <div class="absolute -left-16 -bottom-16 h-60 w-60 rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="relative border-b border-slate-800/80 px-8 py-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-500/30 bg-cyan-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-8 w-8 text-cyan-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9.75 17L15 12l-5.25-5M15 17h3"/>
                        </svg>
                    </div>
                    <div>

                        <div class="flex flex-wrap items-center gap-3">
                            <h1 class="text-3xl font-bold tracking-wide text-white">
                                Domain Scanner
                            </h1>

                            <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-cyan-300">
                                Realtime
                            </span>
                        </div>

                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                            Scan blokir domain KOMDIGI Status secara realtime 
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-slate-700 bg-slate-950/70 px-6 py-4 text-center">
                        <div class="text-xs uppercase tracking-widest text-slate-500">
                            Status
                        </div>
                        <div class="mt-2 font-bold text-emerald-400">
                            ONLINE
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-700 bg-slate-950/70 px-6 py-4 text-center">
                        <div class="text-xs uppercase tracking-widest text-slate-500">
                            Scanner
                        </div>

                        <div class="mt-2 font-bold text-cyan-400">
                            Ready
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative p-8">

            <label class="mb-3 flex items-center justify-between">

                <span class="font-semibold text-slate-300">

                    Domain List

                </span>

                <span class="text-xs text-slate-500">

                    Pisahkan menggunakan Enter

                </span>

            </label>

            <textarea
                id="domains"
                rows="10"
                class="w-full rounded-2xl border border-slate-700 bg-slate-950/80 p-5 font-mono text-sm text-white outline-none transition duration-300 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-500/10"
                placeholder="securityvn.net&#10;google.com&#10;facebook.com"></textarea>

            <div class="mt-6 flex flex-col gap-4 sm:flex-row">

                <button
                    id="btnScan"
                    type="button"
                    class="inline-flex flex-1 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-sky-600 px-6 py-4 font-bold text-white shadow-lg shadow-cyan-500/20 transition hover:scale-[1.02] hover:shadow-cyan-500/40">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m1.35-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Scan Domain
                </button>
            </div>
        </div>
    </div>

<div class="grid gap-6 md:grid-cols-3">

    <!-- TOTAL -->
    <div class="group relative overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 p-6 transition duration-300 hover:-translate-y-1 hover:border-cyan-500/40 hover:shadow-2xl hover:shadow-cyan-500/10">

        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-cyan-500/10 blur-2xl"></div>

        <div class="relative flex items-center justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                    Total Domain
                </p>

                <h2
                    id="total"
                    class="mt-4 text-5xl font-black text-white">

                    0

                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Domain berhasil diproses
                </p>

            </div>

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-cyan-500/10 text-cyan-400">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>

                </svg>

            </div>

        </div>

    </div>


    <!-- ALLOWED -->
    <div class="group relative overflow-hidden rounded-3xl border border-emerald-500/20 bg-slate-900 p-6 transition duration-300 hover:-translate-y-1 hover:border-emerald-500/40 hover:shadow-2xl hover:shadow-emerald-500/10">

        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-500/10 blur-2xl"></div>

        <div class="relative flex items-center justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                    Allowed
                </p>

                <h2
                    id="allowed"
                    class="mt-4 text-5xl font-black text-emerald-400">

                    0

                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Domain tidak diblokir
                </p>

            </div>

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>

                </svg>

            </div>

        </div>

    </div>


    <!-- BLOCKED -->
    <div class="group relative overflow-hidden rounded-3xl border border-red-500/20 bg-slate-900 p-6 transition duration-300 hover:-translate-y-1 hover:border-red-500/40 hover:shadow-2xl hover:shadow-red-500/10">
        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-red-500/10 blur-2xl"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                    Blocked
                </p>
                <h2
                    id="blocked"
                    class="mt-4 text-5xl font-black text-red-400">
                    0
                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Domain terdeteksi diblokir
                </p>
            </div>

            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-red-500/10 text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
    </div>
</div>


<div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900 shadow-xl">
    <div class="flex items-center justify-between border-b border-slate-800 px-8 py-5">
        <div>
            <h2 class="text-xl font-bold text-white">
                Scan Result
            </h2>
        </div>

        <div class="rounded-xl border border-cyan-500/20 bg-cyan-500/10 px-4 py-2">
            <span class="text-xs font-semibold uppercase tracking-widest text-cyan-300">
                Live Result
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="sticky top-0 bg-slate-950">
                <tr>
                    <th class="px-8 py-5 text-left text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                        Domain
                    </th>

                    <th class="px-8 py-5 text-center text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                        Nawala
                    </th>

                    <th class="px-8 py-5 text-center text-xs font-bold uppercase tracking-[0.25em] text-slate-500">
                        Network
                    </th>
                </tr>
            </thead>

            <tbody
                id="resultTable"
                class="divide-y divide-slate-800 text-sm">
                <tr>

                    <td colspan="3" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full border border-slate-700 bg-slate-950">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-10 w-10 text-slate-600"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9.75 17L15 12l-5.25-5M15 17h3"/>
                                </svg>
                            </div>

                            <h3 class="text-lg font-semibold text-slate-300">
                                Belum Ada Hasil Scan
                            </h3>

                            <p class="mt-2 max-w-md text-sm text-slate-500">
                                Masukkan satu atau beberapa domain di atas,
                                kemudian tekan tombol
                                <span class="font-semibold text-cyan-400">
                                    Scan Domain
                                </span>
                                untuk memulai proses pengecekan.
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection


@push('scripts')

<script>

$('#btnScan').on('click', function () {

    let domains = $('#domains').val().trim();

    if(domains === ''){

        alert('Masukkan minimal satu domain.');

        return;

    }

    $('#btnScan')
        .prop('disabled', true)
        .text('Scanning...');

    $.ajax({

        url: "{{ route('admin.seo-tools.scan') }}",

        method: "POST",

        data: {

            domains: domains,

            _token: "{{ csrf_token() }}"

        },

        success: function(res){

            $('#btnScan')
                .prop('disabled', false)
                .text('Scan Domain');

            $('#total').text(res.total ?? 0);
            $('#allowed').text(res.allowed ?? 0);
            $('#blocked').text(res.blocked ?? 0);

            let html='';

            if(!res.data || res.data.length===0){

                html=`
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                            Tidak ada data.
                        </td>
                    </tr>
                `;

            }else{

                $.each(res.data,function(i,item){

                    html+=`

                    <tr class="border-b border-slate-800 transition duration-200 hover:bg-slate-800/60">

                    <td class="px-8 py-5">

                        <div class="font-mono font-semibold text-slate-200">

                            ${item.domain}

                        </div>

                    </td>

                        <td class="px-6 py-4 text-center">

                            ${
                                item.nawala.blocked
                                ? '<span class="inline-flex rounded-full border border-red-500/30 bg-red-500/15 px-4 py-1 text-xs font-bold uppercase tracking-wider text-red-300">Blocked</span>'
                                : '<span class="inline-flex rounded-full border border-emerald-500/30 bg-emerald-500/15 px-4 py-1 text-xs font-bold uppercase tracking-wider text-emerald-300">Allowed</span>'
                            }

                        </td>

                        <td class="px-6 py-4 text-center">

                            ${
                                item.network.blocked
                                ? '<span class="inline-flex rounded-full border border-red-500/30 bg-red-500/15 px-4 py-1 text-xs font-bold uppercase tracking-wider text-red-300">Blocked</span>'
                                : '<span class="inline-flex rounded-full border border-emerald-500/30 bg-emerald-500/15 px-4 py-1 text-xs font-bold uppercase tracking-wider text-emerald-300">Allowed</span>'
                            }

                        </td>

                    </tr>

                    `;

                });

            }

            $('#resultTable').html(html);

        },

        error:function(xhr){

            $('#btnScan')
                .prop('disabled', false)
                .text('Scan Domain');

            if(xhr.responseJSON){

                alert(xhr.responseJSON.message);

            }else{

                alert('Terjadi kesalahan.');

            }

        }

    });

});

</script>

@endpush