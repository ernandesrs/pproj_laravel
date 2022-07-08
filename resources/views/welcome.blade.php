<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Página inicial</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    @yield('styles')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <header class="bg-light border-bottom">
        <div class="container py-2 d-flex align-items-center">
            <a href="">{{ config('app.name') }}</a>
            <nav class="nav ml-auto">
                @auth
                    @if (auth()->user()->level === 9)
                        <a class="nav-link" href="{{ route('admin.home') }}">Administração</a>
                    @endif
                    <a class="nav-link" href="{{ route('member.home') }}">Painel</a>
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
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
