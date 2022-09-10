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
            <a href="">{{ config('app.name') }}</a>
            <nav class="nav ml-auto">
                @auth
                    @if (auth()->user()->level === 9)
                        <a class="nav-link" href="{{ route('admin.index') }}">Administração</a>
                    @endif
                    <a class="nav-link" href="{{ route('member.index') }}">Painel</a>
                    <a class="nav-link jsLogout" href="{{ route('auth.logout') }}">Sair</a>
                @else
                    <a class="nav-link" href="{{ route('auth.register') }}">Registro</a>
                    <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                @endauth
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
                    <h3 class="h5 mb-0 font-weight-bold">Menu #1</h3>
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
                    <a href="{{ route('front.index') }}">{{ config('app.name') }}</a> &copy; {{ date('Y') }}
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
