@extends('layouts.admin')

@section('content')
    {{-- admim home cards --}}
    <div class="row justify-content-center cards-list">
        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('users') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">
                        ({{ \App\Models\User::all()->count() }}) Usuários
                    </h5>
                    <div>
                        <small>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'verified']) }}">
                                ({{ \App\Models\User::whereNotNull('email_verified_at')->count() }}) Verificados
                            </a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('admin.users.index', ['filter' => true, 'status' => 'unverified']) }}">
                                ({{ \App\Models\User::whereNull('email_verified_at')->count() }}) Não verificados
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('pageEarmarkText') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">
                        ({{ \App\Models\Page::all()->count() }}) Páginas
                    </h5>
                    <div>
                        <small>
                            <a
                                href="{{ route('admin.pages.index', ['filter' => true, 'status' => \App\Models\Page::STATUS_SCHEDULED]) }}">
                                ({{ \App\Models\Page::where('status', \App\Models\Page::STATUS_SCHEDULED)->count() }})
                                Agendadas
                            </a>
                            <span class="mx-1">|</span>
                            <a
                                href="{{ route('admin.pages.index', ['filter' => true, 'status' => \App\Models\Page::STATUS_DRAFT]) }}">
                                ({{ \App\Models\Page::where('status', \App\Models\Page::STATUS_DRAFT)->count() }}) Rascunho
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 mb-4">
            <div class="card card-body d-flex flex-row align-items-center cards-list-item">
                {{ icon_elem('appIndicator') }}
                <div class="card-item-content">
                    <h5 class="h3 mb-0">Example</h5>
                    <div>
                        <small>
                            <a href=""># Example One</a>
                            <span class="mx-1">|</span>
                            <a href=""># Example Two</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
