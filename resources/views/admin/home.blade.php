@extends('layouts.admin')

@section('content')
    {{-- admim home cards --}}
    <div class="row justify-content-center cards-list">
        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                <i class="icon bi bi-people-fill"></i>
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Usuários</h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'unverified']) }}">Não
                                verificados</a>
                            <span class="mx-1">|</span>
                            <a
                                href="{{ route('admin.users.index', ['filter' => true, 'status' => 'verified']) }}">Verificados</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                <i class="icon bi bi-app-indicator"></i>
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Example</h5>
                    <div>
                        <small>
                            <a href="">Example #1</a>
                            <span class="mx-1">|</span>
                            <a href="">Example #2</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
