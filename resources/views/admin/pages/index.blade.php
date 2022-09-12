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
    <div class="">
        @foreach ($pages as $page)
            @php
                /** @var \App\Models\User $author */
                $author = $page->author();
                
                /** @var \App\Models\Slug $slugs */
                $slugs = $page->slugs();
                
                $slug = $slugs->slug($page->lang);
            @endphp

            @component('components.panel.list-item',
                [
                    'cover' => Thumb::thumb($page->cover, 'cover.small'),
                    'title' => $page->title,
                    'description' => $page->description,
                    'url' => route('front.dinamicPage', ['slug' => $slug]),
                ])
                @slot('tags')
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
                @endslot

                @slot('actions')
                    @include('includes.button', [
                        'button' => Template::buttonLink(
                            'btn btn-sm btn-primary',
                            route('admin.pages.edit', ['page' => $page->id]),
                            null,
                            icon_class('pencilSquare'),
                            null
                        ),
                    ])

                    @include('includes.button-confirmation', [
                        'button' => Template::buttonConfirmation(
                            'danger',
                            'btn btn-sm btn-danger',
                            "Você está excluindo a página <strong>{$page->title}</strong> e isso não pode ser desfeito.",
                            route('admin.pages.destroy', ['page' => $page->id]),
                            icon_class('trash')
                        ),
                    ])
                @endslot
            @endcomponent
        @endforeach
    </div>

    @component('components.navigation',
        [
            'model' => $pages,
        ])
        @slot('text')
            Páginas
        @endslot
    @endcomponent
@endsection

@section('modals')
    @include('includes.modal-confirmation')
@endsection
