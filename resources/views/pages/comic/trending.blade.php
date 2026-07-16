@extends('layouts.app')

@section('content')

@include('pages.comic.partials.grid',['comics'=>$comics['comics']])

@endsection