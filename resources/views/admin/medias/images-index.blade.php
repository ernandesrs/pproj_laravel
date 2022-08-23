@extends('layouts.admin', [
    'filterFormAction' => route('admin.medias.images.index'),
    'buttons' => [Template::button('btn btn-outline-success', route('admin.medias.images.store'), 'jsOpenImageUploadModal', icon_class('plusLg'), 'Novo upload'), Template::button('btn btn-outline-success', route('admin.medias.images.index'), 'jsOpenImageToolsModal', icon_class('image'), '')],
])

@section('content')
    <div class="row justify-content-center">
        @if ($images->count())
            @foreach ($images as $image)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card card-body border-0">
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
                                        'button' => Template::buttonConfirmation(
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
    @include('admin.medias.includes.modal-image')
    @include('admin.medias.includes.modal-image-tools')
    @include('includes.modal-confirmation')
@endsection

@section('scripts')
    <script>
        let modalImageUpload = $("#jsImageModal");

        /**
         * Abre modal para upload de nova imagem
         */
        $(".jsOpenImageUploadModal").on("click", function(e) {
            let button = $(this);

            modalImageUpload.find(".modal-title").html("Upload de nova imagem");
            modalImageUpload.find("form").attr("action", button.attr("data-action"));
            modalImageUpload.find("button[type=submit]").text("Salvar imagem");

            modalImageUpload.modal();

        });

        /**
         * Abre modal para editar imagem
         */
        $(".jsOpenImageEditModal").on("click", function(e) {
            let button = $(this);

            ajaxRequest(button.attr("data-action"), null, function(response) {

                modalImageUpload.find(".modal-title").html("Editar dados da imagem");
                modalImageUpload.find("form").attr("action", response.action);
                modalImageUpload.find("#name").val(response.image.name);
                modalImageUpload.find("#tags").val(response.image.tags);
                modalImageUpload.find("#file").parents().eq(2).addClass("d-none");
                modalImageUpload.find("button[type=submit]").text("Atualizar imagem");

                modalImageUpload.modal();

            });

        });

        /**
         * Reseta os dados do modal
         */
        modalImageUpload.on("hidden.bs.modal", function() {

            modalImageUpload.find(".modal-title").html("");
            modalImageUpload.find("form").attr("action", "");
            modalImageUpload.find("#name").val("");
            modalImageUpload.find("#tags").val("");
            modalImageUpload.find("#file").parents().eq(2).removeClass("d-none");
            modalImageUpload.find("button[type=submit]").text("");

        });
    </script>
@endsection
