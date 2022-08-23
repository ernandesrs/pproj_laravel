@extends('layouts.admin', [
    'filterFormAction' => route('admin.medias.images.index'),
    'buttons' => [Template::button('btn btn-outline-success', route('admin.medias.images.store'), 'jsOpenImageUploadModal', icon_class('plusLg'), 'Nova')],
])

@section('content')
    <div class="row justify-content-center">
        @if ($images->count())
            @foreach ($images as $image)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card card-body border-0 shadow">
                        <div class="">
                            <img class="img-fluid img-thumbnail"
                                src="{{ thumb(Storage::path('public/' . $image->path), 350, 225) }}" alt="{{ $image->name }}"
                                data-toggle="tooltip" title="Tags: {{ $image->tags }}" data-placement="bottom">
                        </div>
                        <div class="pt-2 text-center">
                            <small>
                                <p class="mb-0">
                                    <span>
                                        Nome:
                                        <span data-toggle="tooltip" data-placement="top" title="{{ $image->name }}">
                                            <a href="{{ Storage::url($image->path) }}" target="_blank">
                                                {{ substr($image->name, 0, 12) }}...
                                            </a>
                                        </span>
                                    </span>
                                </p>
                                <p class="mb-2">
                                    <span>
                                        Tamanho:
                                        <span>
                                            {{ number_format($image->size / 1000000, 3, ',', ',') }} Mb
                                        </span>
                                    </span>
                                </p>
                                <div>
                                    @include('includes.button', [
                                        'button' => Template::button(
                                            'btn btn-sm btn-primary',
                                            route('admin.medias.images.show', ['image' => $image->id]),
                                            'jsOpenImageEditModal',
                                            icon_class('pencilSquare')
                                        ),
                                    ])
                                    @include('includes.button-confirmation', [
                                        'button' => Template::button(
                                            'danger',
                                            'btn btn-sm btn-danger',
                                            'Você está excluindo esta imagem definitivamente mesmo que ela esteja sendo utilizada e isso não pode ser desfeito.',
                                            route('admin.medias.images.destroy', ['image' => $image->id]),
                                            icon_class('trash')
                                        ),
                                    ])
                                </div>
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 col-sm-10 col-md-8">
                <p class="mb-0 py-3 text-center text-muted h5">
                    @if (empty(input_value($_GET ?? null, 'filter')))
                        Nenhuma imagem armazenada ainda
                    @else
                        Sem resultados para sua busca
                    @endif
                </p>
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            {{ $images->links() }}
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection