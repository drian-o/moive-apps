<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NawalaService;
use Illuminate\Http\Request;

class NawalaShortlinkController extends Controller
{
    protected NawalaService $nawala;

    public function __construct(NawalaService $nawala)
    {
        $this->nawala = $nawala;
    }

    /**
     * Halaman Shortlink
     */
    public function index()
    {
        return view('admin.nawala.shortlinks.index');
    }

    /**
     * List Shortlinks
     */
    public function list()
    {
        return response()->json(
            $this->nawala->getShortlinks()
        );
    }

    /**
     * Detail Shortlink
     */
    public function show(string $id)
    {
        return response()->json(
            $this->nawala->shortlink($id)
        );
    }

    /**
     * Create Shortlink
     */
    public function store(Request $request)
    {
        return response()->json(
            $this->nawala->createShortlink([
                'name'        => $request->name,
                'slug'        => $request->slug,
                'description' => $request->description,
                'is_active'   => $request->boolean('is_active'),
            ])
        );
    }

    /**
     * Update Shortlink
     */
    public function update(Request $request, string $id)
    {
        return response()->json(
            $this->nawala->updateShortlink($id, $request->all())
        );
    }

    /**
     * Delete Shortlink
     */
    public function destroy(string $id)
    {
        return response()->json(
            $this->nawala->deleteShortlink($id)
        );
    }

    /**
     * Create Link
     */
    public function storeLink(Request $request)
    {
        return response()->json(
            $this->nawala->createLink([
                'url'          => $request->url,
                'domain'       => $request->domain,
                'status'       => $request->status,
                'priority'     => $request->priority,
                'shortlink_id' => $request->shortlink_id,
            ])
        );
    }

    /**
     * Delete Link
     */
    public function destroyLink(string $id)
    {
        return response()->json(
            $this->nawala->deleteLink($id)
        );
    }
}