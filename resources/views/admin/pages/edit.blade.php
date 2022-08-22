@extends('layouts.admin', [
    'buttons' => [Template::buttonLink('btn btn-primary', route('admin.pages.index'), null, icon_class('arrowLeft'), 'Voltar'), Template::buttonLink('btn btn-outline-success', route('admin.pages.create'), null, icon_class('plusLg'), 'Nova página')],
])

@section('content')
    <div class="row justify-content-center py-4 section-page-edit">
        <div class="col-12">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ route('admin.pages.update', ['page' => $page->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    @include('admin.pages.includes.pages-form-fields')

                    <div class="text-right">
                        <button class="btn btn-primary {{ icon_class('checkLg') }}"
                            data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"
                            type="submit">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
