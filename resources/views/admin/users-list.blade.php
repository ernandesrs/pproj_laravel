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
        <table class="table table-hover table-striped table-sm">
            <thead>
                <tr>
                    <th class="text-center">#ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th class="d-none d-lg-block">Data de registro</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-none d-lg-block">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
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
