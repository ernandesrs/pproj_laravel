@extends('layouts.front')

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Esta seria uma view customizada para: {{ $page->title }}</h1>
            <p class="lead">{{ $page->description }}</p>
            <hr class="my-4">
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium ex enim unde. Quam, minus in. Atque
                officiis deleniti commodi numquam! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Obcaecati ad quo voluptatum beatae? Architecto, dignissimos suscipit autem laborum adipisci quisquam. Commodi incidunt fugiat voluptatum illum deserunt quod eveniet autem ut!
            </p>
        </div>
    </div>
@endsection
