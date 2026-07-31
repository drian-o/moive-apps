<aside
    id="sidebar"
    class="flex h-screen w-[280px] flex-col border-r border-zinc-700/50 bg-[#141923]">

    {{-- Logo --}}
    <div class="flex h-16 items-center border-b border-zinc-700/50 px-7">

        @if(!empty($setting?->logo))
            <a href="{{ route('home') }}">
                <img
                    src="{{ asset('storage/'.$setting->logo) }}"
                    alt="{{ $setting->site_name }}"
                    class="h-11 w-auto">
            </a>
        @endif

    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4">

        {{-- ================= MAIN ================= --}}
        <div class="mb-8">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-600">
                Main
            </p>

            <div class="space-y-2">

                {{-- Home --}}
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs('home')
                        ? 'border border-sky-500/30 bg-sky-500/10 text-white shadow-[0_0_15px_rgba(14,165,233,.15)]'
                        : 'text-zinc-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10.5L12 3l9 7.5V21a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V10.5z"/>
                    </svg>

                    <span>Home</span>

                </a>

                {{-- Anime --}}
                <a href="{{ route('anime.unlimited') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs('anime.*')
                        ? 'border border-sky-500/30 bg-sky-500/10 text-white shadow-[0_0_15px_rgba(14,165,233,.15)]'
                        : 'text-zinc-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"/>
                        <path d="M8 21h8" stroke-width="2"/>
                    </svg>

                    <span>Anime</span>

                </a>

                {{-- Donghua --}}
                <a href="{{ route('donghua.home') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs('donghua.*')
                        ? 'border border-sky-500/30 bg-sky-500/10 text-white shadow-[0_0_15px_rgba(14,165,233,.15)]'
                        : 'text-zinc-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3c4 4 6 7 6 10a6 6 0 11-12 0c0-3 2-6 6-10z"/>
                    </svg>

                    <span>Donghua</span>

                </a>

                {{-- Movie --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-zinc-300 transition-all duration-200 hover:bg-white/5 hover:text-white hover:translate-x-1">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="5" width="18" height="14" rx="2" stroke-width="2"/>
                        <path d="M7 5v14M17 5v14" stroke-width="2"/>
                    </svg>

                    <span>Movie</span>

                </a>

                {{-- Comic --}}
                <a href="{{ route('comic.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs('comic.*')
                        ? 'border border-sky-500/30 bg-sky-500/10 text-white shadow-[0_0_15px_rgba(14,165,233,.15)]'
                        : 'text-zinc-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6.5 17V5A2.5 2.5 0 019 2.5H20V17"/>
                    </svg>

                    <span>Comic</span>

                </a>

            </div>

        </div>
                {{-- ================= DISCOVER ================= --}}
        <div class="mb-8">

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-600">
                Discover
            </p>

            <div class="space-y-2">

                {{-- Trending --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-zinc-300 transition-all duration-200 hover:bg-white/5 hover:text-white hover:translate-x-1">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>

                    <span>Trending</span>

                </a>

                {{-- Popular --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-zinc-300 transition-all duration-200 hover:bg-white/5 hover:text-white hover:translate-x-1">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.959a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.447a1 1 0 00-.364 1.118l1.286 3.959c.3.921-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.197-1.538-1.118l1.286-3.959a1 1 0 00-.364-1.118L2.463 9.386c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.959z"/>
                    </svg>

                    <span>Popular</span>

                </a>

                {{-- Bookmark --}}
                <a href="#"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-zinc-300 transition-all duration-200 hover:bg-white/5 hover:text-white hover:translate-x-1">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-4-7 4V5z"/>
                    </svg>

                    <span>Bookmark</span>

                </a>

            </div>

        </div>

        {{-- ================= CONTENT ================= --}}
        <div>

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-600">
                Content
            </p>

            <div class="space-y-2">

                <a href="{{ route('articles.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs('articles.*')
                        ? 'border border-sky-500/30 bg-sky-500/10 text-white shadow-[0_0_15px_rgba(14,165,233,.15)]'
                        : 'text-zinc-300 hover:bg-white/5 hover:text-white hover:translate-x-1' }}">

                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h10M7 16h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>

                    <span>Articles</span>

                </a>

            </div>

        </div>

    </nav>

</aside>