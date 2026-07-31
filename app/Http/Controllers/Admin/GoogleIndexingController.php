<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoogleIndexingSetting;
use App\Services\GoogleIndexingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoogleIndexingController extends Controller
{
    /**
     * Halaman
     */
    public function index()
    {
    $googleSetting = GoogleIndexingSetting::latest()->first();

    return view('admin.google-indexing.index', compact('googleSetting'));
    }

    /**
     * Upload Service Account JSON
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credential' => 'required|file|mimes:json|max:1024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {

            $json = json_decode(
                file_get_contents($request->file('credential')->getRealPath()),
                true
            );

            if (!$json) {
                return back()->withErrors([
                    'credential' => 'JSON tidak valid.'
                ]);
            }

            GoogleIndexingSetting::updateOrCreate(
                ['id' => 1],
                [
                    'credential' => $json,
                    'is_connected' => false,
                    'last_test_at' => null,
                ]
            );

            return back()->with('success', 'Credential berhasil disimpan.');

        } catch (\Throwable $e) {

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);

        }
    }

    /**
     * Test Connection
     */
public function test(GoogleIndexingService $google)
{
    try {

        $google->test();

        $setting = GoogleIndexingSetting::first();

        if ($setting) {

            $setting->update([
                'is_connected' => true,
                'last_test_at' => now()
            ]);

        }

        return back()->with('success', 'Google berhasil terhubung.');

    } catch (\Throwable $e) {

        $setting = GoogleIndexingSetting::first();

        if ($setting) {

            $setting->update([
                'is_connected' => false
            ]);

        }

        return back()->withErrors([
            'error' => $e->getMessage()
        ]);

    }
}

    /**
     * Hapus Credential
     */
    public function delete()
    {
        GoogleIndexingSetting::query()->delete();

        return back()->with('success','Credential berhasil dihapus.');
    }

/**
 * Submit URL
 */
public function submit(Request $request, GoogleIndexingService $google)
{
    $request->validate([
        'url' => 'required|url'
    ]);

    try {

    $response = $google->submit($request->url);

    return back()->with([
        'success' => 'URL berhasil dikirim.',
        'submit_result' => [
            'status' => 'success',
            'url' => $request->url,
            'type' => 'URL_UPDATED',
            'time' => now()->format('d M Y H:i:s'),
            'response' => json_decode(json_encode($response), true),
        ]
    ]);

    } catch (\Throwable $e) {

        return back()->with([
            'submit_result' => [
                'status' => 'error',
                'url' => $request->url,
                'time' => now()->format('d M Y H:i:s'),
                'message' => $e->getMessage(),
            ]
        ]);

    }
}

    /**
     * Metadata
     */
    public function metadata(Request $request, GoogleIndexingService $google)
    {
        $request->validate([
            'url'=>'required|url'
        ]);

        return response()->json(
            json_decode(
                $google->metadata($request->url)->toJson(),
                true
            )
        );
    }

    /**
     * Remove URL
     */
    public function remove(Request $request, GoogleIndexingService $google)
    {
        $request->validate([
            'url'=>'required|url'
        ]);

        $google->remove($request->url);

        return response()->json([
            'success'=>true
        ]);
    }
}