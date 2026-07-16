<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Checker\CheckerManager;

class CheckerController extends Controller
{
    public function index()
    {
        return view('admin.checker.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'domains' => 'required|string'
        ]);

        $domains = preg_split('/\r\n|\r|\n/', trim($request->domains));

        $results = app(CheckerManager::class)->scan($domains);

        return response()->json($results);
    }
}