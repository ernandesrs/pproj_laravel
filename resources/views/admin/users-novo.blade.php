@extends('layouts.admin')

@section('content')
    <h1>{{ $pageTitle }}</h1>

    <div class="row justify-content-center py-4">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.users.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.includes.users-form-fields')

                    <button class="btn btn-primary bi bi-check-lg" data-active-icon="bi bi-check-lg"
                        data-alt-icon="bi bi-arrow-clockwise" type="submit">
                        Registrar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
