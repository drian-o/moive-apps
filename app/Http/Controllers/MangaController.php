<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MangaService;

class MangaController extends Controller
{
    protected MangaService $manga;

    public function __construct(MangaService $manga)
    {
        $this->manga = $manga;
    }

    /**
     * Halaman AI Manga
     */
    public function index()
    {
        return view('pages.manga.index');
    }

    /**
     * Generate Manga
     */
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        $comic = $this->manga->generate($request->prompt);

        return response()->json($comic);
    }

    /**
     * Cek Status Generate
     */
    public function status($id)
    {
        return response()->json(
            $this->manga->status($id)
        );
    }
}