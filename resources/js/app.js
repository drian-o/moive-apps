import './bootstrap';
import '../css/app.css';

import Hls from 'hls.js';
import Alpine from 'alpinejs';
import 'flowbite';

window.Hls = Hls;
window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // ==========================
    // SEARCH
    // ==========================

    const input = document.getElementById('search');
    const result = document.getElementById('search-result');

    if (input && result) {

        console.log('SEARCH INIT');

        let timeout;

        input.addEventListener('input', (e) => {

            console.log('INPUT EVENT:', e.target.value);

            clearTimeout(timeout);

            const keyword = input.value.trim();

            if (keyword.length < 2) {

                result.innerHTML = '';
                result.classList.add('hidden');
                return;

            }

            timeout = setTimeout(async () => {

                try {

                    result.innerHTML = `
                        <div class="p-4 text-center text-zinc-400">
                            Mencari...
                        </div>
                    `;

                    result.classList.remove('hidden');

                    const response = await fetch(
                        '/anime-api/search?q=' + encodeURIComponent(keyword)
                    );

                    const json = await response.json();

                    console.log('SEARCH RESPONSE:', json);

                   const list = json.data?.animeList || [];

if (!list.length) {

    result.innerHTML = `
        <div class="p-5 text-center text-zinc-400">
            Anime tidak ditemukan
        </div>
    `;

    return;

}

console.log('BEFORE RENDER');

result.innerHTML = list.slice(0, 8).map(anime => `
                        <a
                            href="javascript:void(0)"
                            class="flex items-center gap-3 border-b border-zinc-800 p-3 transition hover:bg-zinc-800">

                            <img
                                src="${anime.poster}"
                                class="h-16 w-12 rounded-lg object-cover">

                            <div class="min-w-0 flex-1">

                                <div class="truncate font-semibold text-white">
                                    ${anime.title}
                                </div>

                                <div class="mt-1 text-xs text-zinc-400">
                                    ${anime.episodes ? `Episode ${anime.episodes}` : ''}
                                    ${anime.releaseDay ? ` • ${anime.releaseDay}` : ''}
                                </div>

                            </div>

                        </a>
                    `).join('');

                } catch (e) {

                    console.error('SEARCH ERROR:', e);

                    result.innerHTML = `
                        <div class="p-5 text-center text-red-400">
                            Gagal mengambil data.
                        </div>
                    `;

                }

            }, 300);

        });

        input.addEventListener('focus', () => {

            if (result.innerHTML.trim() !== '') {
                result.classList.remove('hidden');
            }

        });

        document.addEventListener('click', (e) => {

            if (
                !input.contains(e.target) &&
                !result.contains(e.target)
            ) {

                result.classList.add('hidden');

            }

        });

    }

    // ==========================
    // MOBILE SIDEBAR
    // ==========================

    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('menu-toggle');
    const overlay = document.getElementById('sidebar-overlay');

    if (sidebar && toggle && overlay) {

        toggle.addEventListener('click', () => {

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');

        });

        overlay.addEventListener('click', () => {

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');

        });

    }

});

new Swiper('.recommended-swiper', {

    slidesPerView: 'auto',

    spaceBetween: 20,

    grabCursor: true,

    navigation: {

        nextEl: '.recommended-next',

        prevEl: '.recommended-prev',

    },

    breakpoints: {

        640: {

            spaceBetween: 20,

        },

        1024: {

            spaceBetween: 24,

        },

    },

});