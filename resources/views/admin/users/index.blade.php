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
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex">
                                <img class="img-fluid img-thumbnail rounded-circle mr-2 d-none d-sm-block"
                                    src="{{ m_user_photo_thumb($user, 'small') }}" alt="{{ $user->name }}"
                                    style="width: 75px; height: 75px;">
                                <div class="d-flex flex-column">
                                    <span>{{ $user->name }}</span>
                                    <span class="pb-1"><small>{{ $user->email }}</small></span>
                                    <div class="d-flex">
                                        <span
                                            class="badge badge-secondary {{ $user->level == \App\Models\User::LEVEL_9 ? icon_class('shieldFill') : icon_class('userFill') }}"><span
                                                class="ml-1">{{ ucfirst(__('terms.user_level.' . $user->level)) }}</span></span>
                                        <span class="mx-1"></span>
                                        <span
                                            class="badge badge-{{ $user->email_verified_at ? 'info ' . icon_class('checkCircleFill') : 'light-dark ' . icon_class('xCircleFill') }}">
                                            <span
                                                class="ml-1">{{ $user->email_verified_at ? 'Verificado' : 'Não verificado' }}</span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-sm btn-info {{ icon_class('pencilSquare') }}"
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

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center py-2">
            {{ $users->onEachSide(2)->links() }}
        </div>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
