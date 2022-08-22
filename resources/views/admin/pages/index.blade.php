@php
$keys = array_fill_keys(m_user_levels(), null);
foreach ($keys as $key => $value) {
    $keys[$key] = ucfirst(__('terms.user_level.' . $key));
}
@endphp

@extends('layouts.admin', [
    'filterFormAction' => route('admin.pages.index'),
    'filterFormFields' => [
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select',
            'options' => [
                \App\Models\Page::STATUS_DRAFT => ucfirst(__('terms.page_status.' . \App\Models\Page::STATUS_DRAFT)),
                \App\Models\Page::STATUS_SCHEDULED => ucfirst(__('terms.page_status.' . \App\Models\Page::STATUS_SCHEDULED)),
                \App\Models\Page::STATUS_PUBLISHED => ucfirst(__('terms.page_status.' . \App\Models\Page::STATUS_PUBLISHED)),
            ],
        ],
    ],
    'buttons' => [Template::buttonLink('btn btn-outline-success', route('admin.pages.create'), null, icon_class('plusLg'), 'Nova página')],
])

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-borderless">
            <tbody>
                @php
                    /** @var \App\Models\Page $page */
                @endphp
                @foreach ($pages as $page)
                    @php
                        /** @var \App\Models\User $author */
                        $author = $page->author();
                        
                        /** @var \App\Models\Slug $slugs */
                        $slugs = $page->slugs();
                        
                        $slug = $slugs->slug($page->lang);
                    @endphp
                    <tr>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <img class="img-fluid img-thumbnail mr-2 d-none d-sm-block" src="{{ m_page_cover_thumb($page, 'small') }}"
                                    alt="{{ $page->name }}" style="width: 125px; height: 75px;">
                                <div class="d-flex flex-column">
                                    <span>
                                        <a href="{{ route('front.dinamicPage', ['slug' => $slug]) }}" target="_blank">
                                            {{ $page->title }}
                                        </a>
                                    </span>
                                    <span class="pb-1">
                                        <small>
                                            {{ substr($page->description, 0, 75) }}...
                                        </small>
                                    </span>
                                    <div class="d-flex flex-wrap">
                                        <span class="badge badge-dark-light">
                                            {{ icon_elem('user') }}
                                            {{ $author ? substr($author->first_name, 0, 28) : null }}...
                                        </span>
                                        <span class="mx-1"></span>
                                        <span class="badge badge-light-dark" data-toggle="tooltip" data-placement="top"
                                            title="{{ ucfirst(__('terms.page_status.' . $page->status)) }}">
                                            @if ($page->scheduled_to)
                                                {{ icon_elem('calendarEvent') }}
                                                {{ date('d/m/Y H:i', strtotime($page->scheduled_to)) }}
                                            @elseif($page->published_at)
                                                {{ icon_elem('calendarCheck') }}
                                                {{ date('d/m/Y H:i', strtotime($page->published_at)) }}
                                            @else
                                                {{ icon_elem('calendarX') }}
                                                {{ date('d/m/Y H:i', strtotime($page->created_at)) }}
                                            @endif
                                        </span>
                                        <span class="mx-1"></span>
                                        <span class="badge badge-light">
                                            {{ $page->content_type == \App\Models\Page::CONTENT_TYPE_VIEW ? 'Página customizada' : 'Texto' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-right">
                            <a class="btn btn-sm btn-info {{ icon_class('pencilSquare') }}"
                                href="{{ route('admin.pages.edit', ['page' => $page->id]) }}"></a>

                            @include('includes.button-confirmation', [
                                'button' => Template::buttonConfirmation(
                                    'danger',
                                    'btn btn-sm btn-danger',
                                    "Você está excluindo a página <strong>{$page->title}</strong> e isso não pode ser desfeito.",
                                    route('admin.pages.destroy', ['page' => $page->id]),
                                    icon_class('trash')
                                ),
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
