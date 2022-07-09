<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} Membro - {{ $pageTitle }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/member/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/boxicons.min.css') }}">
    @yield('styles')
</head>

<body>

    <header class="header d-flex align-items-center">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="d-flex left">
                    <h1 class="mb-0 d-none d-lg-block">Logo</h1>
                    <button class="ml-auto bx bx-menu btn-menu-toggler"></button>
                </div>
                <nav class="nav ml-auto">
                    <a class="text-danger" href="{{ route('auth.logout') }}">
                        <i class='bx bx-log-out'></i> Sair
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <div class="wrapp d-flex py-3">
        <aside class="sidebar d-none d-lg-flex">
            <div class="container-fluid py-3">
                <p>
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Fuga et tenetur consectetur dolorem
                    quibusdam.
                    Doloremque obcaecati optio aspernatur. Aperiam voluptatum at iure itaque commodi! Voluptatum atque
                    labore
                    laudantium temporibus molestiae!
                </p>
            </div>
        </aside>

        <main class="main">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/boostrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.min.js') }}"></script>
    <script src="{{ asset('assets/js/member/scripts.js') }}"></script>

    @yield('scripts')
</body>

</html>
