<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RawPaste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RawPasteController extends Controller
{
    public function index(Request $request): View
    {
        $pastes = RawPaste::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = trim($request->string('search'));

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('filename', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
                    });
                }
            )
            ->when(
                $request->filled('visibility'),
                fn ($query) => $query->where(
                    'visibility',
                    $request->string('visibility')
                )
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.raw-online.index', compact('pastes'));
    }

    public function create(): View
    {
        return view('admin.raw-online.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePaste($request);

        $paste = RawPaste::create([
            'created_by' => auth()->id(),
            'filename' => $validated['filename'],
            'language' => $validated['language'],
            'visibility' => $validated['visibility'],
            'content' => $validated['content'],
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('admin.raw-online.edit', $paste)
            ->with('success', 'Raw paste berhasil dibuat.');
    }

    public function edit(RawPaste $rawPaste): View
    {
        return view(
            'admin.raw-online.edit',
            compact('rawPaste')
        );
    }

    public function update(
        Request $request,
        RawPaste $rawPaste
    ): RedirectResponse {
        $validated = $this->validatePaste($request);

        $rawPaste->update([
            'filename' => $validated['filename'],
            'language' => $validated['language'],
            'visibility' => $validated['visibility'],
            'content' => $validated['content'],
            'expires_at' => $validated['expires_at'] ?? null,
        ]);

        return redirect()
            ->route('admin.raw-online.edit', $rawPaste)
            ->with('success', 'Raw paste berhasil diperbarui.');
    }

    public function destroy(
        RawPaste $rawPaste
    ): RedirectResponse {
        $rawPaste->delete();

        return redirect()
            ->route('admin.raw-online.index')
            ->with('success', 'Raw paste berhasil dihapus.');
    }

    private function validatePaste(Request $request): array
    {
        return $request->validate([
            'filename' => [
                'required',
                'string',
                'max:150',
                'regex:/^[A-Za-z0-9._-]+$/',
            ],

            'language' => [
                'required',
                Rule::in([
                    'text',
                    'html',
                    'css',
                    'javascript',
                    'json',
                    'php',
                    'blade',
                    'sql',
                    'bash',
                    'markdown',
                    'xml',
                ]),
            ],

            'visibility' => [
                'required',
                Rule::in([
                    'public',
                    'unlisted',
                    'private',
                ]),
            ],

            'content' => [
                'required',
                'string',
                'max:2000000',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],
        ]);
    }
    public function extractor(
    RawPaste $rawPaste
    ): \Illuminate\View\View {
        return view(
            'admin.raw-online.extractor',
            compact('rawPaste')
        );
    }
}