@php
    $menuBase = '
        group relative flex items-center gap-3 overflow-hidden
        rounded-xl px-3.5 py-3 text-sm font-medium
        transition-all duration-200
    ';

    $menuInactive = '
        text-slate-400
        hover:bg-slate-800/70
        hover:text-white
    ';

    $menuActive = '
        bg-gradient-to-r from-sky-500/20 to-blue-500/5
        text-sky-300
        ring-1 ring-inset ring-sky-500/20
        shadow-lg shadow-sky-950/20
    ';

    $iconBase = '
        relative z-10 h-5 w-5 shrink-0
        transition-all duration-200
    ';

    $sectionTitle = '
        mb-2 mt-6 flex items-center gap-3 px-3
        text-[10px] font-bold uppercase tracking-[0.22em]
        text-slate-600
    ';
@endphp

<aside
    class="
        sticky top-0 flex h-screen w-72 shrink-0 flex-col
        overflow-hidden border-r border-slate-800/80
        bg-slate-950
    "
>
    {{-- Background decoration --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div
            class="
                absolute -left-24 -top-24 h-64 w-64 rounded-full
                bg-sky-500/10 blur-3xl
            "
        ></div>

        <div
            class="
                absolute -bottom-32 -right-32 h-72 w-72 rounded-full
                bg-blue-600/10 blur-3xl
            "
        ></div>

        <div
            class="absolute inset-0 opacity-[0.025]"
            style="
                background-image:
                    linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px);
                background-size: 30px 30px;
            "
        ></div>
    </div>

    {{-- Brand --}}
    <div class="relative border-b border-slate-800/80 px-5 py-5">
        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3"
        >
            <div
                class="
                    relative flex h-11 w-11 shrink-0 items-center justify-center
                    overflow-hidden rounded-xl
                    bg-gradient-to-br from-sky-400 to-blue-600
                    shadow-lg shadow-sky-500/20
                "
            >
                <x-heroicon-o-command-line
                    class="relative z-10 h-6 w-6 text-white"
                />

                <div
                    class="
                        absolute inset-0
                        bg-gradient-to-t from-black/20 to-white/20
                    "
                ></div>
            </div>

            <div class="min-w-0">
                <h1
                    class="
                        truncate text-xl font-black tracking-tight text-white
                    "
                >
                    SEO
                    <span
                        class="
                            bg-gradient-to-r from-sky-400 to-blue-400
                            bg-clip-text text-transparent
                        "
                    >
                        TOOLS
                    </span>
                </h1>

                <div class="mt-0.5 flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="
                                absolute inline-flex h-full w-full
                                animate-ping rounded-full
                                bg-emerald-400 opacity-50
                            "
                        ></span>

                        <span
                            class="
                                relative inline-flex h-2 w-2
                                rounded-full bg-emerald-500
                            "
                        ></span>
                    </span>

                    <p class="text-[11px] font-medium text-slate-500">
                        Administration Panel
                    </p>
                </div>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav
        class="
            relative flex-1 overflow-y-auto px-4 py-4
            [scrollbar-color:theme(colors.slate.700)_transparent]
            [scrollbar-width:thin]
        "
    >
        {{-- Overview --}}
        <div class="{{ $sectionTitle }} mt-1">
            <span>Overview</span>
            <span class="h-px flex-1 bg-slate-800"></span>
        </div>

        @php
            $dashboardActive = request()->routeIs('admin.dashboard');
        @endphp

        <a
            href="{{ route('admin.dashboard') }}"
            class="{{ $menuBase }}
                {{ $dashboardActive ? $menuActive : $menuInactive }}"
            @if ($dashboardActive) aria-current="page" @endif
        >
            @if ($dashboardActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400 shadow-lg shadow-sky-400/50
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg transition-all duration-200
                    {{ $dashboardActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-home class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Dashboard
            </span>

            @if ($dashboardActive)
                <x-heroicon-o-chevron-right
                    class="relative z-10 h-4 w-4 text-sky-400"
                />
            @endif
        </a>

        {{-- Content --}}
        <div class="{{ $sectionTitle }}">
            <span>Content</span>
            <span class="h-px flex-1 bg-slate-800"></span>
        </div>

        @php
            $aiActive = request()->routeIs('admin.ai.*');
        @endphp

        <a
            href="{{ route('admin.ai.index') }}"
            class="{{ $menuBase }}
                {{ $aiActive ? $menuActive : $menuInactive }}"
            @if ($aiActive) aria-current="page" @endif
        >
            @if ($aiActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $aiActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-sparkles class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Assistant AI
            </span>

            <span
                class="
                    relative z-10 rounded-md border border-violet-500/20
                    bg-violet-500/10 px-1.5 py-0.5
                    text-[9px] font-bold uppercase tracking-wider
                    text-violet-400
                "
            >
                AI
            </span>
        </a>

        @php
            $articlesActive = request()->routeIs('admin.articles.*');
        @endphp

        <a
            href="{{ route('admin.articles.index') }}"
            class="{{ $menuBase }}
                {{ $articlesActive ? $menuActive : $menuInactive }}"
            @if ($articlesActive) aria-current="page" @endif
        >
            @if ($articlesActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $articlesActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-document-text class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Articles
            </span>
        </a>


        {{-- Raw Online --}}
        @php
            $rawOnlineActive = request()->routeIs('admin.raw-online.*');
        @endphp

        <a
            href="{{ route('admin.raw-online.index') }}"
            class="{{ $menuBase }}
                {{ $rawOnlineActive ? $menuActive : $menuInactive }}"
            @if ($rawOnlineActive) aria-current="page" @endif
        >
            @if ($rawOnlineActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-violet-400 shadow-lg shadow-violet-400/40
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg transition-all duration-200
                    {{ $rawOnlineActive
                        ? 'bg-violet-500/15 text-violet-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-violet-400'
                    }}
                "
            >
                <x-heroicon-o-code-bracket-square class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Raw Online & Extrator Domain
            </span>

            <span
                class="
                    relative z-10 rounded-md border border-violet-500/20
                    bg-violet-500/10 px-1.5 py-0.5
                    text-[9px] font-bold uppercase tracking-wider
                    text-violet-400
                "
            >
                RAW
            </span>
        </a>

        {{-- SEO Tools --}}
        <div class="{{ $sectionTitle }}">
            <span>SEO Tools</span>
            <span class="h-px flex-1 bg-slate-800"></span>
        </div>

        @php
            $authorityActive = request()->routeIs(
                'admin.seo-tools.authority'
            );
        @endphp

        <a
            href="{{ route('admin.seo-tools.authority') }}"
            class="{{ $menuBase }}
                {{ $authorityActive ? $menuActive : $menuInactive }}"
            @if ($authorityActive) aria-current="page" @endif
        >
            @if ($authorityActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $authorityActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-shield-check class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Authority Checker
            </span>
        </a>

        @php
            $nawalaActive = request()->routeIs(
                'admin.seo-tools.index'
            );
        @endphp

        <a
            href="{{ route('admin.seo-tools.index') }}"
            class="{{ $menuBase }}
                {{ $nawalaActive ? $menuActive : $menuInactive }}"
            @if ($nawalaActive) aria-current="page" @endif
        >
            @if ($nawalaActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $nawalaActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-globe-alt class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Domain Nawala
            </span>
        </a>

        @php
            $indexingActive = request()->routeIs(
                'admin.google-indexing'
            );
        @endphp

        <a
            href="{{ route('admin.google-indexing') }}"
            class="{{ $menuBase }}
                {{ $indexingActive ? $menuActive : $menuInactive }}"
            @if ($indexingActive) aria-current="page" @endif
        >
            @if ($indexingActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $indexingActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-amber-400'
                    }}
                "
            >
                <x-heroicon-o-bolt class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Boost Indexing
            </span>
        </a>

        @php
            $shortlinksActive = request()->routeIs(
                'admin.seo-tools.shortlinks*'
            );
        @endphp

        <a
            href="{{ route('admin.seo-tools.shortlinks') }}"
            class="{{ $menuBase }}
                {{ $shortlinksActive ? $menuActive : $menuInactive }}"
            @if ($shortlinksActive) aria-current="page" @endif
        >
            @if ($shortlinksActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $shortlinksActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-link class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Shortlinks
            </span>
        </a>

        {{-- System --}}
        <div class="{{ $sectionTitle }}">
            <span>System</span>
            <span class="h-px flex-1 bg-slate-800"></span>
        </div>

        @php
            $terminalActive = request()->routeIs(
                'admin.seo-tools.terminal.*'
            );
        @endphp

        <a
            href="{{ route('admin.seo-tools.terminal.index') }}"
            class="{{ $menuBase }}
                {{ $terminalActive ? $menuActive : $menuInactive }}"
            @if ($terminalActive) aria-current="page" @endif
        >
            @if ($terminalActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-emerald-400 shadow-lg shadow-emerald-400/40
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $terminalActive
                        ? 'bg-emerald-500/15 text-emerald-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-emerald-400'
                    }}
                "
            >
                <x-heroicon-o-command-line class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Terminal
            </span>

            <span class="relative z-10 flex h-2 w-2">
                <span
                    class="
                        absolute inline-flex h-full w-full
                        animate-ping rounded-full bg-emerald-400
                        opacity-40
                    "
                ></span>

                <span
                    class="
                        relative inline-flex h-2 w-2
                        rounded-full bg-emerald-500
                    "
                ></span>
            </span>
        </a>

        @php
            $adsActive = request()->routeIs('admin.ads.*');
        @endphp

        <a
            href="{{ route('admin.ads.index') }}"
            class="{{ $menuBase }}
                {{ $adsActive ? $menuActive : $menuInactive }}"
            @if ($adsActive) aria-current="page" @endif
        >
            @if ($adsActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $adsActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-megaphone class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Ads
            </span>
        </a>

        @php
            $settingsActive = request()->routeIs('admin.settings');
        @endphp

        <a
            href="{{ route('admin.settings') }}"
            class="{{ $menuBase }}
                {{ $settingsActive ? $menuActive : $menuInactive }}"
            @if ($settingsActive) aria-current="page" @endif
        >
            @if ($settingsActive)
                <span
                    class="
                        absolute inset-y-2 left-0 w-1 rounded-r-full
                        bg-sky-400
                    "
                ></span>
            @endif

            <div
                class="
                    relative z-10 flex h-9 w-9 shrink-0 items-center
                    justify-center rounded-lg
                    {{ $settingsActive
                        ? 'bg-sky-500/15 text-sky-400'
                        : 'bg-slate-800/60 text-slate-500 group-hover:bg-slate-700/70 group-hover:text-sky-400'
                    }}
                "
            >
                <x-heroicon-o-cog-6-tooth class="{{ $iconBase }}"/>
            </div>

            <span class="relative z-10 flex-1">
                Website Settings
            </span>
        </a>
    </nav>

    {{-- Admin profile and logout --}}
    <div
        class="
            relative border-t border-slate-800/80
            bg-slate-950/80 p-4 backdrop-blur
        "
    >
        <div
            class="
                mb-3 flex items-center gap-3 rounded-xl
                border border-slate-800 bg-slate-900/70
                p-3
            "
        >
            <div
                class="
                    flex h-10 w-10 shrink-0 items-center justify-center
                    rounded-xl bg-gradient-to-br
                    from-sky-500 to-blue-700
                    text-sm font-bold text-white
                    shadow-lg shadow-blue-950/50
                "
            >
                {{ strtoupper(
                    substr(auth()->user()->name ?? 'A', 0, 1)
                ) }}
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-white">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </p>

                <div class="mt-0.5 flex items-center gap-1.5">
                    <span
                        class="h-1.5 w-1.5 rounded-full bg-emerald-500"
                    ></span>

                    <p class="truncate text-[11px] text-slate-500">
                        Administrator
                    </p>
                </div>
            </div>

            <x-heroicon-o-shield-check
                class="h-5 w-5 shrink-0 text-sky-500"
            />
        </div>

        <form
            method="POST"
            action="{{ route('admin.logout') }}"
        >
            @csrf

            <button
                type="submit"
                class="
                    group flex w-full items-center justify-center gap-2
                    rounded-xl border border-red-500/20
                    bg-red-500/10 px-4 py-3
                    text-sm font-semibold text-red-400
                    transition-all duration-200
                    hover:border-red-500/30
                    hover:bg-red-500
                    hover:text-white
                    hover:shadow-lg hover:shadow-red-950/30
                "
            >
                <x-heroicon-o-arrow-left-on-rectangle
                    class="
                        h-5 w-5 transition-transform duration-200
                        group-hover:-translate-x-0.5
                    "
                />

                Logout
            </button>
        </form>
    </div>
</aside>