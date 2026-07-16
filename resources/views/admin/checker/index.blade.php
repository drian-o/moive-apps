@extends('layouts.admin')

@section('title', 'Scanner')

@section('content')

<div class="space-y-6">

    <div class="bg-slate-900 rounded-xl border border-slate-700">

        <div class="px-6 py-4 border-b border-slate-700">

            <h2 class="text-xl font-bold">
                Domain Scanner
            </h2>

        </div>

        <div class="p-6">

            <textarea
                id="domains"
                rows="10"
                class="w-full rounded-lg bg-slate-950 border border-slate-700 p-4 outline-none"
                placeholder="google.com&#10;facebook.com&#10;example.com"></textarea>

            <div class="flex gap-3 mt-5">

                <button
                    id="reset"
                    type="button"
                    class="flex-1 py-3 rounded-lg border border-red-500 text-red-400 hover:bg-red-500 hover:text-white transition">

                    RESET

                </button>

                <button
                    id="scan"
                    type="button"
                    class="flex-1 py-3 rounded-lg border border-cyan-500 text-cyan-400 hover:bg-cyan-500 hover:text-white transition">

                    SCAN

                </button>

            </div>

        </div>

    </div>

    <div class="grid grid-cols-4 gap-4">

        <div class="bg-slate-900 rounded-lg p-5">

            <p class="text-slate-400 text-sm">
                TOTAL
            </p>

            <h3 id="total" class="text-3xl font-bold">
                0
            </h3>

        </div>

        <div class="bg-slate-900 rounded-lg p-5">

            <p class="text-green-400 text-sm">
                ALLOWED
            </p>

            <h3 id="allowed" class="text-3xl font-bold">
                0
            </h3>

        </div>

        <div class="bg-slate-900 rounded-lg p-5">

            <p class="text-red-400 text-sm">
                BLOCKED
            </p>

            <h3 id="blocked" class="text-3xl font-bold">
                0
            </h3>

        </div>

        <div class="bg-slate-900 rounded-lg p-5">

            <p class="text-yellow-400 text-sm">
                ERROR
            </p>

            <h3 id="error" class="text-3xl font-bold">
                0
            </h3>

        </div>

    </div>

    <div class="bg-slate-900 rounded-xl border border-slate-700 overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-800">

                <tr>

                    <th class="text-left p-4">
                        DOMAIN
                    </th>

                    <th class="text-left p-4">
                        STATUS
                    </th>

                </tr>

            </thead>

            <tbody id="result">

            </tbody>

        </table>

    </div>

</div>

<script>

const resetBtn = document.getElementById('reset');
const scanBtn = document.getElementById('scan');

resetBtn.onclick = function(){

    document.getElementById('domains').value = '';

    document.getElementById('result').innerHTML = '';

    document.getElementById('total').textContent = '0';
    document.getElementById('allowed').textContent = '0';
    document.getElementById('blocked').textContent = '0';
    document.getElementById('error').textContent = '0';

}

scanBtn.onclick = async function(){

    const domains = document.getElementById('domains').value.trim();

    if(domains === ''){

        alert('Masukkan minimal satu domain.');

        return;

    }

    scanBtn.disabled = true;

    scanBtn.innerHTML = 'Scanning...';

    try{

        const response = await fetch("{{ route('admin.checker.check') }}",{

            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },

            body:JSON.stringify({

                domains:domains

            })

        });

        const data = await response.json();

        let tbody='';

        document.getElementById('total').textContent=data.length;

        document.getElementById('allowed').textContent='0';
        document.getElementById('blocked').textContent='0';
        document.getElementById('error').textContent='0';

        data.forEach(function(item){

            tbody += `
                <tr class="border-t border-slate-700">

                    <td class="p-4">
                        ${item.domain}
                    </td>

                    <td class="p-4">

                        <span class="text-yellow-400">

                            ${item.status}

                        </span>

                    </td>

                </tr>
            `;

        });

        document.getElementById('result').innerHTML = tbody;

    }catch(e){

        alert(e);

    }

    scanBtn.disabled=false;

    scanBtn.innerHTML='SCAN';

}

</script>

@endsection