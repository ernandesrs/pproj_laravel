@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
    ],
])

@section('content')
    <div class="row justify-content-center py-4">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 mb-4 mb-md-0 text-center">
            @php
                $hash = md5(strtolower(trim($user->email)));

                $avatar = $user->photo ? Storage::url($user->photo) : 'https://www.gravatar.com/avatar/' . $hash . '?s=250&d=robohash';
            @endphp
            <img class="avatar img-fluid rounded-circle img-thumbnail" src="{{ $avatar }}" alt="{{ $user->name }}">
        </div>

        <div class="col-12 col-md-7 col-lg-8">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.includes.users-form-fields')

                    <button class="btn btn-primary {{ icon_class('checkLg') }}"
                        data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                        type="submit">
                        Atualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
