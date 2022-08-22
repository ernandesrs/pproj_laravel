@extends('layouts.front')

@section('content')
    <div class="container">
        <h1 class="mb-0 text-center">
            {{ $page->title }}
        </h1>
        <hr>
        <article>
            {!! $page->content !!}
        </article>
    </div>
@endsection
