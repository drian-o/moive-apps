<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    protected AIService $ai;

    public function __construct(AIService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Halaman AI Assistant
     */
    public function index()
    {
        return view('admin.ai.index', [
            'models' => $this->ai->models(),
        ]);
    }

    /**
     * Chat AI
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'file'    => 'nullable|file|max:10240',
            'model'   => 'nullable|string',
        ]);

        try {

            $reply = $this->ai->ask(
                $request->message,
                $request->model,
                $request->file('file')
            );

            return response()->json([
                'success' => true,
                'reply'   => $reply,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
}