@php
$keys = array_fill_keys(m_user_levels(), null);
foreach ($keys as $key => $value) {
    $keys[$key] = ucfirst(__('terms.user_level.' . $key));
}
@endphp

@extends('layouts.admin', [
    'mainBar' => [
        'title' => $pageTitle,
        'filterFormAction' => route('admin.pages.index'),
        'filterFormFields' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    'published' => 'Publicado',
                    'draft' => 'Rascunho',
                    'scheduled' => 'Agendado',
                ],
            ],
        ],
    ],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex">
                                <img class="img-fluid img-thumbnail rounded-circle mr-2"
                                    src="{{ m_user_photo_thumb($page, 'small') }}" alt="{{ $page->name }}"
                                    style="width: 125px; height: 75px;">
                                <div class="d-flex flex-column">
                                    <span>{{ $page->title }}</span>
                                    <span class="pb-1"><small>{{ substr($page->description, 0, 75) }}...</small></span>
                                    <div class="d-flex">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-sm btn-info {{ icon_class('pencilSquare') }}"
                                href="{{ route('admin.pages.edit', ['page' => $page->id]) }}"></a>

                            @include('includes.button-confirmation', [
                                'btnAction' => route('admin.pages.destroy', ['page' => $page->id]),
                                'btnClass' => 'btn-sm btn-outline-danger',
                                'btnIcon' => icon_class('trash'),
                                'btnType' => 'danger',
                                'btnMessage' =>
                                    'Você está excluindo <strong>"' .
                                    $page->title .
                                    '"</strong> permanentemente e isso não pode ser desfeito, confirme para continuar.',
                                'btnText' => '',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center py-2">
            {{ $pages->onEachSide(2)->links() }}
        </div>
    </div>
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
