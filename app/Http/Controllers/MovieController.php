<?php

namespace App\Http\Controllers;

use App\Services\MovieOfTheNightService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected MovieOfTheNightService $motn;

    public function __construct(MovieOfTheNightService $motn)
    {
        $this->motn = $motn;
    }

    /**
     * Search Movie / TV
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string'
        ]);

        return response()->json(
            $this->motn->search($request->q)
        );
    }

    /**
     * Detail Movie
     */
    public function show($imdb)
    {
        return response()->json(
            $this->motn->detail($imdb)
        );
    }

    /**
     * Streaming Provider
     */
    public function streaming($imdb)
    {
        return response()->json(
            $this->motn->streaming($imdb)
        );
    }

    /**
     * Genres
     */
    public function genres()
    {
        return response()->json(
            $this->motn->genres()
        );
    }

    /**
     * Countries
     */
    public function countries()
    {
        return response()->json(
            $this->motn->countries()
        );
    }
}