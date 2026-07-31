<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ads::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.ads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'position'   => 'required|in:sidebar,player,footer,popup,floating',

            // Support JPG PNG WEBP GIF sampai 20MB
            'image'      => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4|max:20480',

            'url'        => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('ads', 'public');
        }

        Ads::create([
            'name'       => $request->name,
            'position'   => $request->position,
            'image'      => $image,
            'url'        => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.ads.index');
    }

    public function edit(string $id)
    {
        $ad = Ads::findOrFail($id);

        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}