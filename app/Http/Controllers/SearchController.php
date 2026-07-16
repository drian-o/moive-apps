<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MangasusukuService;
use App\Services\SansekaiAnimeService;
use App\Services\SansekaiDonghuaService;

class SearchController extends Controller
{
    public function __construct(
        protected SansekaiAnimeService $anime,
        protected SansekaiDonghuaService $donghua,
        protected MangasusukuService $comic
    ) {}

    public function index(Request $request)
    {
        $keyword = trim($request->get('q'));

        if ($keyword === '') {
            return view('pages.search.index', [
                'keyword'  => '',
                'anime'    => [],
                'donghua'  => [],
                'comic'    => [],
            ]);
        }

        $anime = $this->anime->search($keyword);
        $donghua = $this->donghua->search($keyword);
        $comic = $this->comic->search($keyword);

        return view('pages.search.index', compact(
            'keyword',
            'anime',
            'donghua',
            'comic'
        ));
    }
}