<hr class="my-5">

<h3 class="mb-3">
    Daftar Chapter
</h3>

@if(!empty($comic['chapters']) && count($comic['chapters']) > 0)

<div class="list-group">

    @foreach($comic['chapters'] as $chapter)

    <a href="{{ route('comic.read', $chapter['slug']) }}"
       class="list-group-item list-group-item-action bg-dark text-white border-secondary">

        <div class="d-flex justify-content-between align-items-center">

            <strong>

                {{ $chapter['title'] ?? $chapter['chapter'] ?? 'Chapter' }}

            </strong>

            <small class="text-secondary">

                {{ $chapter['date'] ?? ($chapter['created_at']['formatted'] ?? '-') }}

            </small>

        </div>

    </a>

    @endforeach

</div>

@else

<div class="alert alert-warning">

    Belum ada daftar chapter.

</div>

@endif