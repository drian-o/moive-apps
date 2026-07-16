<aside class="flex w-72 flex-col border-r border-slate-800 bg-slate-900">

    <div class="border-b border-slate-800 p-6">

        <h1 class="text-3xl font-black text-sky-500">
            
        </h1>

    </div>

    <nav class="flex-1 space-y-1 p-4">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center rounded-xl bg-sky-600 px-4 py-3 font-medium">

            🏠 Dashboard

        </a>

        <div class="pt-6 text-xs uppercase tracking-widest text-slate-500">

            Content

        </div>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            🎬 Anime
        </a>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            📚 Manga
        </a>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            📖 Comic
        </a>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            🐉 Donghua
        </a>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            🎥 Movie
        </a>

        <div class="pt-6 text-xs uppercase tracking-widest text-slate-500">

            System

        </div>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            👥 Users
        </a>

        <a href="#" class="flex rounded-xl px-4 py-3 hover:bg-slate-800">
            🔌 API
        </a>

        <a href="{{ route('admin.settings') }}">
            ⚙ Website Settings
        </a>
    
    </nav>

    <div class="border-t border-slate-800 p-4">

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button
                class="w-full rounded-xl bg-red-600 py-3 font-semibold hover:bg-red-700">

                Logout

            </button>

        </form>

    </div>

</aside>