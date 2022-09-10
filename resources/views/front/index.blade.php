@extends('layouts.front')

@section('content')
    {{-- banner --}}
    <div class="banner py-5">
        <div class="container py-5">
            <div class="row py-md-5">
                <div class="col-12 col-lg-7 text-center text-lg-left">
                    <div class="pb-3">
                        <h1 class="title">
                            Lorem ipsum dolor sit amet consectetur adipisicing
                        </h1>
                        <p class="subtitle">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus distinctio, modi et molestias
                            dignissimos deleniti consequuntur!
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-lg btn-primary mb-2 mb-lg-0">
                            Lorem button
                        </button>
                        <button class="btn btn-lg btn-outline-primary mb-2 mb-lg-0">
                            Button ipsum
                        </button>
                    </div>
                </div>

                <div class="col-12 col-lg-5"></div>
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
@endsection
