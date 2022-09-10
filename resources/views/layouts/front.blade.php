<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! $seo->render() !!}

    <link rel="stylesheet" href="{{ asset('assets/css/front/styles.css') }}">

    @yield('styles')
</head>

<body>
    <header class="bg-dark sticky-top py-1">
        <div class="container py-2 d-flex align-items-center">
            <a href="{{ route('front.index') }}" title="Página inicial">{{ config('app.name') }}</a>
            <nav class="nav ml-auto">
                @php
                    $user = auth()->user();
                @endphp
                <a class="btn btn-primary dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    {{ $user ? substr($user->name, 0, 8) . (strlen($user->name) > 8 ? '...' : null) : 'Conta' }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="px-3 py-1">
                        @if ($user)
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img class="img-fluid rounded-circle img-thumbnail"
                                    src="{{ m_user_photo_thumb($user, 'sm') }}" alt="{{ $user->name }}"
                                    style="width: 75px;">
                                <div class="text-center font-weight-bold py-2 text-muted h5 mb-0">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="py-2">
                                <a class="btn btn-sm btn-primary px-4" href="{{ route('member.profile') }}">
                                    Perfil
                                </a>
                                <a class="btn btn-sm btn-outline-danger px-4" href="{{ route('auth.logout') }}">
                                    Logout
                                </a>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="py-2">
                                <a class="dropdown-item" href="{{ route('admin.index') }}">
                                    Admin
                                </a>
                                <a class="dropdown-item" href="{{ route('member.index') }}">
                                    Membro
                                </a>
                            </div>
                        @else
                            <a class="btn btn-sm btn-primary px-4" href="{{ route('auth.login') }}">
                                Login
                            </a>
                            <a class="btn btn-sm btn-outline-primary px-4" href="{{ route('auth.register') }}">
                                Criar conta
                            </a>
                        @endif
                    </div>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            @include('includes.message')
        </div>

        @yield('content')
    </main>

    <footer class="bg-light-light border-top">
        <div class="container pt-5 pb-2">
            <div class="row justify-content-start">
                <div class="col-12 col-lg-4 d-flex flex-column py-2 text-center text-lg-left">
                    <div class="pb-2">
                        <a class="text-dark" href="">
                            <h1 class="h4 mb-0 font-weight-bold">{{ config('app.name') }}</h1>
                        </a>
                    </div>
                    <div class="pb-2">
                        <a class="inline-block py-2" href="">Facebook</a>
                        <span class="px-2"></span>
                        <a class="inline-block py-2" href="">Instagram</a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="h5 mb-0 font-weight-bold">Menu #1</h3>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#">Link #1</a>
                        <a class="nav-link" href="#">Link #2</a>
                        <a class="nav-link" href="#">Link #3</a>
                        <a class="nav-link" href="#">Link #4</a>
                    </nav>
                </div>

                <div class="col-12 col-sm-6 col-lg-4 d-flex flex-column justify-content-center align-items-center">
                    <h3 class="h5 mb-0 font-weight-bold">Menu #2</h3>
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#">Link #1</a>
                        <a class="nav-link" href="#">Link #2</a>
                        <a class="nav-link" href="#">Link #3</a>
                        <a class="nav-link" href="#">Link #4</a>
                    </nav>
                </div>
            </div>
        </div>
        <hr>
        <div class="container py-2 pb-5">
            <div class="text-center">
                <small>
                    <p class="mb-0">
                        <a href="{{ route('front.index') }}">{{ config('app.name') }}</a> &copy; {{ date('Y') }}
                    </p>
                    <p class="mb-0">
                        <a href="{{ route('front.dinamicPage', ['slug' => 'politicas-de-privacidade']) }}">
                            Políticas de privacidade
                        </a>
                        <span class="px-1">|</span>
                        <a href="{{ route('front.dinamicPage', ['slug' => 'termos-de-uso']) }}">
                            Termos de uso
                        </a>
                    </p>
                </small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/front/scripts.js') }}"></script>

    @yield('scripts')
</body>

</html>
