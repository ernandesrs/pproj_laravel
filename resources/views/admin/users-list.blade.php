@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
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
        ],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex">
                                @php
                                    $hash = md5(strtolower(trim($user->email)));

                                    $avatar = $user->photo ? Storage::url($user->photo) : 'https://www.gravatar.com/avatar/' . $hash . '?s=75&d=robohash';
                                @endphp
                                <img class="img-fluid img-thumbnail rounded-circle mr-2" src="{{ $avatar }}"
                                    alt="{{ $user->name }}" style="width: 75px; height: 75px;">
                                <div class="d-flex flex-column">
                                    <span>{{ $user->name }}</span>
                                    <span><small>{{ $user->email }}</small></span>
                                    <div class="d-flex">
                                        <span
                                            class="badge badge-secondary">{{ ucfirst(__('terms.user_level.' . $user->level)) }}</span>
                                        <span class="mx-1"></span>
                                        <span
                                            class="badge badge-{{ $user->email_verified_at ? 'info' : 'light-dark' }}">{{ $user->email_verified_at ? 'Verificado' : 'Não verificado' }}</span>
                                    </div>
                                </div>

                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-sm btn-info bi bi-pencil-square"
                                href="{{ route('admin.users.edit', ['user' => $user->id]) }}"></a>

                            @include('includes.button-confirmation', [
                                'btnAction' => route('admin.users.destroy', ['user' => $user->id]),
                                'btnClass' => 'btn-sm btn-outline-danger',
                                'btnIcon' => 'bi bi-trash3-fill',
                                'btnType' => 'danger',
                                'btnMessage' =>
                                    'Você está excluindo <strong>"' .
                                    $user->email .
                                    '"</strong> permanentemente e isso não pode ser desfeito, confirme para continuar.',
                                'btnText' => '',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
