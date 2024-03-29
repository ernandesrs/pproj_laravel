@extends('layouts.admin', [
    'buttons' => [Template::buttonLink('btn btn-primary', route('admin.users.index'), null, icon_class('arrowLeft'), 'Voltar'), Template::buttonLink('btn btn-outline-success', route('admin.users.create'), null, icon_class('plusLg'), 'Novo usuário')],
])

@section('content')
    <div class="row justify-content-center py-4 section-user-edit">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 mb-4 mb-md-0 text-center">
            <div class="d-flex flex-column justify-content-center align-items-center position-relative">
                <img class="avatar img-fluid rounded-circle img-thumbnail"
                    src="{{ Thumb::thumb($user->photo, 'user.normal') }}" alt="{{ $user->name }}">
                @if ($user->photo)
                    @include('includes.button-confirmation', [
                        'button' => Template::buttonConfirmation(
                            'danger',
                            'btn btn-sm btn-danger position-absolute',
                            'Você está excluindo a foto deste usuário e isso não pode ser desfeito!',
                            route('admin.users.photoRemove', ['user' => $user->id]),
                            icon_class('trash'),
                            'Excluir foto'
                        ),
                    ])
                @endif
            </div>
            <div class="py-2">
                <p class="mb-1">
                    <span
                        class="badge badge-secondary {{ icon_class($user->level == \App\Models\User::LEVEL_9 ? 'shieldFill' : 'userFill') }}">
                        {{ ucfirst(__('terms.user_level.' . $user->level)) }}
                    </span>
                </p>
                <small>
                    <p class="mb-0">
                        Registrado em: {{ $user->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p class="mb-0">
                        @if ($user->email_verified_at)
                            Verificado em: {{ $user->email_verified_at->format('d/m/Y H:i') }}
                        @else
                            Aguardando verificação
                        @endif
                    </p>
                    <hr>
                    <div>
                        @if ($user->level > \App\Models\User::LEVEL_1)
                            @include('includes.button-confirmation', [
                                'button' => Template::buttonConfirmation(
                                    'danger',
                                    'btn btn-sm btn-outline-danger',
                                    'Você está rebaixando <strong>' .
                                        $user->name .
                                        '</strong> em um nível e isso o removerá todas permissões do nível de usuário atual.',
                                    route('admin.users.demote', ['user' => $user->id]),
                                    icon_class('userMinus'),
                                    'Rebaixar'
                                ),
                            ])
                            <span class="mx-1"></span>
                        @endif

                        @if ($user->level < \App\Models\User::LEVEL_9)
                            @include('includes.button-confirmation', [
                                'button' => Template::buttonConfirmation(
                                    'success',
                                    'btn btn-sm btn-outline-success',
                                    'Você está promovendo <strong>' .
                                        $user->name .
                                        '</strong> para o próximo nível e isso o consede todas permissões deste nível de usuário.',
                                    route('admin.users.promote', ['user' => $user->id]),
                                    icon_class('userPlus'),
                                    'Promover'
                                ),
                            ])
                        @endif
                    </div>
                </small>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-8">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.users.includes.users-form-fields')

                    <button class="btn btn-primary {{ icon_class('checkLg') }}"
                        data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                        type="submit">
                        Atualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
