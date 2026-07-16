<?php

namespace App\Http\Controllers;

use App\Services\ComicService;

class ReadController extends Controller
{
    public function __construct(
        protected ComicService $comic
    ) {}

    public function show($slug, $chapter)
    {
        $chapter = $this->comic->chapter($slug, $chapter);

        if (empty($chapter)) {
            abort(404);
        }

        return view('pages.comic.read', compact('chapter'));
    }
}