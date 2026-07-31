<?php

namespace App\Http\Controllers;

use App\Models\RawPaste;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RawPastePublicController extends Controller
{
    /**
     * Tampilan viewer seperti Pastefy.
     */
    public function show(RawPaste $rawPaste): View
    {
        $this->ensureAccessible($rawPaste);

        $rawPaste->increment('views');

return view(
    'pages.raw-online.show',
    compact('rawPaste')
);
    }

    /**
     * Menghasilkan isi teks mentah.
     */
    public function raw(RawPaste $rawPaste): Response
    {
        $this->ensureAccessible($rawPaste);

        $rawPaste->increment('views');

        $filename = $this->safeFilename(
            $rawPaste->filename
        );

        return response(
            $rawPaste->content,
            200,
            [
                'Content-Type' =>
                    'text/plain; charset=UTF-8',

                'Content-Disposition' =>
                    'inline; filename="'.$filename.'"',

                'X-Content-Type-Options' =>
                    'nosniff',

                'Cache-Control' =>
                    'no-store, private',
            ]
        );
    }

    /**
     * Download isi paste sebagai file.
     */
    public function download(
        RawPaste $rawPaste
    ): Response {
        $this->ensureAccessible($rawPaste);

        $filename = $this->safeFilename(
            $rawPaste->filename
        );

        return response(
            $rawPaste->content,
            200,
            [
                'Content-Type' =>
                    'text/plain; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="'.$filename.'"',

                'X-Content-Type-Options' =>
                    'nosniff',

                'Cache-Control' =>
                    'no-store, private',
            ]
        );
    }

    private function ensureAccessible(
        RawPaste $rawPaste
    ): void {
        abort_if(
            $rawPaste->visibility === 'private',
            404
        );

        abort_if(
            $rawPaste->isExpired(),
            410,
            'Raw paste sudah kedaluwarsa.'
        );
    }

    private function safeFilename(string $filename): string
    {
        return str_replace(
            ['"', "\r", "\n", '/', '\\'],
            '',
            $filename
        ) ?: 'file.txt';
    }
}