@extends('admin.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Domain Checker</h4>
    </div>

    <div class="card-body">

        <input
            class="form-control"
            id="domain"
            placeholder="example.com">

        <br>

        <button
            class="btn btn-primary"
            id="check">

            Check

        </button>

        <hr>

        <pre id="result"></pre>

    </div>
</div>

@endsection