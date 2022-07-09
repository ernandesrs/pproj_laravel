@extends('layouts.admin')

@section('content')
    <h1>{{ $pageTitle }}</h1>
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
                            <a class="btn btn-sm btn-outline-danger bi bi-trash3-fill"
                                href="{{ route('admin.users.destroy', ['user' => $user->id]) }}"></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
