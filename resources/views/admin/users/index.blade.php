@php
$keys = array_fill_keys(m_user_levels(), null);
foreach ($keys as $key => $value) {
    $keys[$key] = ucfirst(__('terms.user_level.' . $key));
}
@endphp

@extends('layouts.admin', [
    'filterFormAction' => route('admin.users.index'),
    'filterFormFields' => [
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select',
            'options' => [
                'verified' => 'Verificado',
                'unverified' => 'Não verificado',
            ],
        ],
        [
            'name' => 'level',
            'label' => 'Nível',
            'type' => 'select',
            'options' => $keys,
        ],
    ],
    'buttons' => [Template::buttonLink('btn btn-outline-success', route('admin.users.create'), null, icon_class('plusLg'), 'Novo usuário')],
])

@section('content')
    <div class="">
        @foreach ($users as $user)
            @component('components.panel.list-item',
                [
                    'cover' => Thumb::thumb($user->photo, 'user.small'),
                    'coverStyle' => 'square-rounded',
                ])
                @slot('content')
                    <div class="title">{{ $user->name }}</div>
                    <div class="description">{{ $user->email }}</div>
                @endslot

                @slot('tags')
                    <span
                        class="badge badge-secondary {{ $user->level == \App\Models\User::LEVEL_9 ? icon_class('shieldFill') : icon_class('userFill') }}"><span
                            class="ml-1">{{ ucfirst(__('terms.user_level.' . $user->level)) }}</span></span>
                    <span class="mx-1"></span>
                    <span
                        class="badge badge-{{ $user->email_verified_at ? 'info ' . icon_class('checkCircleFill') : 'light-dark ' . icon_class('xCircleFill') }}">
                        <span class="ml-1">{{ $user->email_verified_at ? 'Verificado' : 'Não verificado' }}</span>
                    </span>
                @endslot

                @slot('actions')
                    <a class="btn btn-sm btn-primary {{ icon_class('pencilSquare') }}"
                        href="{{ route('admin.users.edit', ['user' => $user->id]) }}"></a>

                    @include('includes.button-confirmation', [
                        'button' => Template::buttonConfirmation(
                            'danger',
                            'btn btn-sm btn-danger',
                            "Você está excluindo o usuário <strong>{$user->name}</strong> permanentemente e isso não pode ser desfeito!",
                            route('admin.users.destroy', ['user' => $user->id]),
                            icon_class('trash'),
                            null
                        ),
                    ])
                @endslot
            @endcomponent
        @endforeach
    </div>

    @component('components.navigation',
        [
            'model' => $users,
        ])
        @slot('text')
            Usuários
        @endslot
    @endcomponent
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
