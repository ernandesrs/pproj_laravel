@extends('layouts.auth')

@section('content')
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
        <div class="card card-body">
            <form class="jsFormSubmit" action="{{ route('auth.store') }}" method="POST">
                @csrf
                @include('includes.message')

                <div class="form-row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="first_name">Nome:</label>
                            <input class="form-control" type="text" name="first_name" id="first_name">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="last_name">Sobrenome:</label>
                            <input class="form-control" type="text" name="last_name" id="last_name">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="username">Usuário:</label>
                            <input class="form-control" type="text" name="username" id="username">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="gender">Gênero:</label>
                            <select class="form-control" name="gender" id="gender">
                                @foreach (\App\Models\User::GENDERS as $gender)
                                    <option value="{{ $gender }}">
                                        {{ ucfirst(__('terms.user_gender.' . $gender)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="text" name="email" id="email">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input class="form-control" type="password" name="password" id="password"
                                autocomplete="new-password">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar senha:</label>
                            <input class="form-control" type="password" name="password_confirmation"
                                id="password_confirmation">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group d-flex justify-content-center">
                            {!! GRecaptcha::render() !!}
                        </div>
                    </div>
                </div>

                <div class="form-group d-flex align-items-center">
                    <button class="btn btn-primary">Registrar</button>
                    <a class="ml-auto" href="{{ route('auth.login') }}">Eu tenho conta</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {!! GRecaptcha::render() !!}

    <script src="{{ asset('assets/js/jquery-mask.min.js') }}"></script>
    <script>
        $('#phone').mask('+00 (00) 0 0000-0000');
    </script>
@endsection
