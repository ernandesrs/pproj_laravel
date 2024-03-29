<div id="jsImageToolsModal" class="modal fade modal-image-tools" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-body border-0 px-2 py-2">

                    <div class="form-row">

                        {{-- new upload --}}
                        <div class="col-12 col-md-5 col-lg-4 mb-4 mb-md-0 order-md-12">
                            <h2 class="mb-0 h5">
                                Novo upload
                            </h2>
                            <hr>
                            <div class="card card-body border-0 px-2 py-2 modal-image-upload">
                                @include('admin.medias.includes.form-fields-image-upload', [
                                    'action' => route('admin.medias.images.store', ['redirect' => false]),
                                ])
                            </div>
                        </div>

                        {{-- images list --}}
                        <div class="col-12 col-md-7 col-lg-8 order-md-1">
                            <h2 class="mb-0 h5">
                                Imagens existentes
                            </h2>
                            <hr>
                            <div class="modal-image-search">
                                <div class="card card-body border-0 px-2 py-2">
                                    <form class="d-flex jsImageToolsSearchFormSubmit"
                                        action="{{ route('admin.medias.images.index') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="filter" id="filter" value="1">
                                        <input class="form-control" type="search" name="search" id="search">
                                        <button class="btn bg-transparent {{ icon_class('filter') }}"></button>
                                    </form>
                                </div>
                            </div>

                            <div class="modal-image-list">
                                <div class="model d-none">
                                    <div class="col-6 col-lg-4 col-xl-4 modal-image-list-item">
                                        <div class="card card-body border-0 d-flex align-items-center flex-column">

                                            {{-- data filds --}}
                                            <input type="hidden" name="image_id" id="image_id">
                                            <input type="hidden" name="image_name" id="image_name">
                                            <input type="hidden" name="image_url" id="image_url">
                                            <input type="hidden" name="image_thumb" id="image_thumb">

                                            <img class="img-fluid img-thumbnail" src="" alt="">
                                            <div class="mb-2"></div>
                                            @include('includes.button', [
                                                'button' => Template::button(
                                                    'btn btn-sm btn-dark-light',
                                                    '',
                                                    'jsInsertImageFromImageToolsModal',
                                                    icon_class('check'),
                                                    'Inserir'
                                                ),
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center modal-list"></div>
                            </div>
                            <hr>
                            <div class="modal-image-pagination d-flex justify-content-center"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
