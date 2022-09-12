@extends('layouts.front')

@php

$banners = [
    [
        'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing ',
        'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus distinctio, modi et molestias dignissimos deleniti consequuntur!',
        'page_id' => 1,
        'alignment' => 'left',
        'type' => 'banner',
        'ilustration' => asset('assets/img/ilustration_01.png'),
        'buttons' => (object) [
            [
                'text' => 'Lorem button',
                'style' => 'btn-primary',
                'url' => '#',
                'target' => '_self',
            ],
            [
                'text' => 'Button ipsum',
                'style' => 'btn-outline-primary',
                'url' => 'https://www.google.com.br',
                'target' => '_blank',
            ],
        ],
        'content' => (object) [
            'background' => null,
            'duration' => 5000,
        ],
    ],
    [
        'title' => 'Lorem ipsum dolor sit amet consectetur adipisicing ',
        'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus distinctio, modi et molestias dignissimos deleniti consequuntur!',
        'page_id' => 1,
        'alignment' => 'right',
        'type' => 'banner',
        'ilustration' => asset('assets/img/ilustration_02.png'),
        'buttons' => (object) [
            [
                'text' => 'Lorem button',
                'style' => 'btn-dark',
                'url' => '#',
                'target' => '_self',
            ],
            [
                'text' => 'Button ipsum',
                'style' => 'btn-outline-dark',
                'url' => 'https://www.google.com.br',
                'target' => '_blank',
            ],
        ],
        'content' => (object) [
            'background' => null,
            'duration' => 5000,
        ],
    ],
];

@endphp

@section('content')
    {{-- banner --}}
    <div class="banner d-flex align-items-center py-5">
        <div class="container">
            <div id="homeBanner" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($banners as $key => $banner)
                        @php
                            $banner = (object) $banner;
                            $buttons = $banner->buttons ?? [];
                        @endphp
                        <div class="carousel-item {{ $key == 0 ? 'active' : null }}"
                            data-interval="{{ $banner->content->duration }}">
                            <div class="row justify-content-center">
                                <div
                                    class="col-10 col-sm-8 col-lg-5 {{ $banner->alignment == 'left' ? 'order-lg-12' : '' }} mb-4 mb-lg-0">
                                    <img class="img-fluid" src="{{ $banner->ilustration }}" alt="">
                                </div>

                                <div
                                    class="col-12 col-lg-7 d-flex flex-column justify-content-center text-center text-lg-left">
                                    <div class="pb-3">
                                        <h1 class="title">
                                            {{ $banner->title }}
                                        </h1>
                                        <p class="subtitle">
                                            {{ $banner->subtitle }}
                                        </p>
                                    </div>
                                    <div>
                                        @foreach ($buttons as $button)
                                            @php
                                                $button = (object) $button;
                                            @endphp
                                            <a class="btn btn-lg {{ $button->style }} mb-2 mb-lg-0"
                                                href="{{ $button->url }}" target="{{ $button->target }}">
                                                {{ $button->text }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if (count($banners) > 1)
                    <a class="carousel-control-prev" href="#homeBanner" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#homeBanner" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    {{-- /banner --}}

    {{-- seção 2 --}}
    <div class="bg-dark py-5 text-light" id="section2">
        <div class="container">
            <div class="row py-5">
                <div class="col-12 col-md-5 col-lg-6 order-md-12 text-center mb-4 mb-md-0 px-5">
                    <img src="https://via.placeholder.com/425x425?text=Seção 2" alt="Seção 2" class="img-fluid">
                </div>
                <div
                    class="col-12 col-md-7 col-lg-6 d-flex flex-column align-items-center align-items-md-start text-center text-md-left">
                    <h2 class="h1">Lorem ipsum dolor sit adipisicing consectetur</h2>
                    <p class="h5 mb-0">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum esse sint, neque obcaecati aliquam
                        illum
                        consequuntur modi a, aliquid voluptatibus.
                    </p>
                    <div class="py-4">
                        <a class="btn btn-lg btn-primary" href="#prices">
                            Ver preços
                        </a>
                        <button class="btn btn-lg btn-outline-primary">
                            Conhecer mais
                        </button>
                    </div>
                </div>
            </div>

            <div class="row py-5">
                <div class="col-12 col-md-5 col-lg-6 text-center mb-4 mb-md-0 px-5">
                    <img src="https://via.placeholder.com/425x425?text=Seção 3" alt="Seção 3" class="img-fluid">
                </div>
                <div
                    class="col-12 col-md-7 col-lg-6 d-flex flex-column align-items-center align-items-md-start text-center text-md-left">
                    <h2 class="h1">Lorem ipsum dolor sit adipisicing consectetur</h2>
                    <p class="h5">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum esse sint, neque obcaecati aliquam
                        illum
                        consequuntur modi a, aliquid voluptatibus.
                    </p>
                    <h3 class="h4">
                        Sit dolor ipsum dolor antus
                    </h3>
                    <p class="">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis numquam quis laborum voluptatem
                        pariatur, eligendi <strong class="text-primary">quas libero natus error recusandae</strong>.
                    </p>
                    <div class="pb-4">
                        <a class="btn btn-lg btn-outline-primary" href="#prices">
                            Ver preços
                        </a>
                        <button class="btn btn-lg btn-primary">
                            Criar uma conta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /seção 2 --}}

    {{-- prices --}}
    <div class="bg-light-light py-5" id="prices">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-12 col-md-10 col-lg-8 text-center">
                    <h2 class="h1">
                        Preços
                    </h2>
                    <p class="mb-0 h5">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum magnam odit delectus, aut aspernatur
                        quos praesentium expedita sed.
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Plano 1</h2>
                        </div>
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="">
                                    <span class="h1">R$ 0</span>
                                    <span class="h5 text-muted">/mês</span>
                                </div>
                            </div>

                            <div class="pb-4">
                                <ul class="list-group text-left">
                                    <li class="list-group-item border-0 py-2">
                                        10 Lorem ipsum sit
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        1 Ipsum dolor
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        4 Ipsum
                                    <li class="list-group-item border-0 py-2">
                                        100 Ipsum dolor
                                    </li>
                                </ul>
                            </div>

                            <a href="#" class="btn btn-block btn-primary">
                                Escolher este
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Plano 2</h2>
                        </div>
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="">
                                    <span class="h1">R$ 50</span>
                                    <span class="h5 text-muted">/mês</span>
                                </div>
                            </div>

                            <div class="pb-4">
                                <ul class="list-group text-left">
                                    <li class="list-group-item border-0 py-2">
                                        20 Lorem ipsum sit
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        10 Ipsum dolor
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        40 Ipsum
                                    <li class="list-group-item border-0 py-2">
                                        1000 Ipsum dolor
                                    </li>
                                </ul>
                            </div>

                            <a href="#" class="btn btn-block btn-primary">
                                Escolher este
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-header">
                            <h2>Plano 3</h2>
                        </div>
                        <div class="card-body">
                            <div class="pb-4">
                                <div class="">
                                    <span class="h1">R$ 10</span>
                                    <span class="h5 text-muted">/mês</span>
                                </div>
                            </div>

                            <div class="pb-4">
                                <ul class="list-group text-left">
                                    <li class="list-group-item border-0 py-2">
                                        1000 Lorem ipsum sit
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        1500 Ipsum dolor
                                    </li>
                                    <li class="list-group-item border-0 py-2">
                                        4050 Ipsum
                                    <li class="list-group-item border-0 py-2">
                                        10000 Ipsum dolor
                                    </li>
                                </ul>
                            </div>

                            <a href="#" class="btn btn-block btn-primary">
                                Escolher este
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- /prices --}}

    <div class="bg-dark py-5 text-light" id="section3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-11 col-lg-9 col-xl-7 text-center">
                    <h2 class="h1">Lorem ipsum dolor sit amet</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quibusdam laborum in omnis autem quaerat
                        nihil assumenda veniam praesentium, repudiandae aliquam?</p>
                    <a class="btn btn-lg btn-outline-primary h5 mb-0" href="">
                        <span class="mr-2">Lorem ipsum link</span>
                        {{ icon_elem('arrowRight') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
