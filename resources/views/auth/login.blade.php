@extends('layouts.auth')

@section('content')
    <div class="col-10 col-md-8 col-lg-6 col-xl-4">
        <form action="{{ route('auth.authenticate') }}" method="POST">
            @csrf

            @include('includes.message')

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input class="form-control" type="text" name="email" id="email">
            </div>

            <div class="form-group">
                <label for="password">Senha:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="form-group d-flex align-items-center">
                <button class="btn btn-primary">Login</button>
                <a class="ml-auto" href="{{ route('auth.register') }}">Registrar</a>
                <span class="mx-1">|</span>
                <a class="" href="{{ route('password.request') }}">Recuperar senha</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $("form").on("submit", function(e) {
            e.preventDefault();
            let form = $(this);
            let data = new FormData(form[0]);
            let action = form.attr("action");

            $.ajax({
                type: "POST",
                url: action,
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,

                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                        return;
                    }

                    form.find(".message-area").html($(
                            `<div class="alert alert-danger text-center">${response.message}</div>`)
                        .hide().fadeIn());
                }
            });
        });
    </script>
@endsection
