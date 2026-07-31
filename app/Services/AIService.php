<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class AIService
{
    /**
     * API Key Gemini
     */
    protected string $apiKey;

    /**
     * Daftar model fallback
     */
    protected array $fallbackModels = [
        'models/gemini-3.1-flash-lite',
        'models/gemini-3.5-flash',
        'models/gemini-flash-latest',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Ambil seluruh model Gemini yang support generateContent
     */
    public function models(): Collection
    {
        $response = Http::get(
            "https://generativelanguage.googleapis.com/v1beta/models?key={$this->apiKey}"
        );

        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return collect($response->json('models'))
            ->filter(function ($model) {
                return in_array(
                    'generateContent',
                    $model['supportedGenerationMethods'] ?? []
                );
            })
            ->pluck('name')
            ->values();
    }

    /**
     * Chat ke Gemini (Text + Image/PDF)
     */
    public function ask(
        string $prompt,
        ?string $model = null,
        ?UploadedFile $file = null
    ): string {

        $models = $model
            ? [$model]
            : $this->fallbackModels;

        foreach ($models as $currentModel) {

            $url = "https://generativelanguage.googleapis.com/v1beta/{$currentModel}:generateContent?key={$this->apiKey}";

            $parts = [
                [
                    "text" => $prompt
                ]
            ];

            /**
             * Jika ada file
             */
            if ($file) {

                $parts[] = [

                    "inlineData" => [

                        "mimeType" => $file->getMimeType(),

                        "data" => base64_encode(
                            file_get_contents(
                                $file->getRealPath()
                            )
                        )

                    ]

                ];

            }

            try {

                $response = Http::retry(3, 1500)
                    ->timeout(120)
                    ->acceptJson()
                    ->post($url, [

                        "contents" => [
                            [
                                "parts" => $parts
                            ]
                        ]

                    ]);

                if ($response->successful()) {

                    return data_get(
                        $response->json(),
                        'candidates.0.content.parts.0.text',
                        'AI tidak memberikan jawaban.'
                    );

                }

            } catch (\Throwable $e) {

                continue;

            }
        }

        throw new \Exception(
            'Semua model Gemini sedang tidak tersedia.'
        );
    }

    /**
     * Test model tertentu
     */
    public function testModel(string $model)
    {
        try {

            return $this->ask(
                'Balas hanya dengan kata OK.',
                $model
            );

        } catch (\Throwable $e) {

            return $e->getMessage();

        }
    }
}