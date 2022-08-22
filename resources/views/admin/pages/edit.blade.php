@extends('layouts.admin', [
    'buttons' => [Template::buttonLink('btn btn-primary', route('admin.pages.index'), null, icon_class('arrowLeft'), 'Voltar'), Template::buttonLink('btn btn-outline-success', route('admin.pages.create'), null, icon_class('plusLg'), 'Nova página')],
])

@php
$formAction = route('admin.pages.store');
if ($page ?? null) {
    $formAction = route('admin.pages.update', ['page' => $page->id]);
}
@endphp

@section('content')
    <div class="row justify-content-center py-4 section-page-edit">
        <div class="col-12">
            <div class="card card-body">
                <form class="jsFormSubmit" action="{{ $formAction }}" method="post" enctype="multipart/form-data">
                    <div class="form-row">

                        @csrf

                        <div class="col-12 col-md-8">
                            <div class="form-row">
                                {{-- título --}}
                                <div class="col-12 col-md-8 col-xl-10">
                                    <div class="form-group">
                                        <label for="title">Título:</label>
                                        <input class="form-control" type="text" name="title" id="title"
                                            value="{{ input_value($page ?? null, 'title') }}">
                                    </div>
                                </div>

                                {{-- idioma --}}
                                <div class="col-12 col-md-4 col-xl-2">
                                    <div class="form-group">
                                        <label for="lang">Idioma:</label>
                                        @php
                                            $locales = config('app.locales') ?? [config('app.locale')];
                                        @endphp
                                        <select class="form-control" name="lang" id="lang"
                                            {{ count($locales) <= 1 ? 'disabled' : null }}>
                                            @foreach ($locales as $locale)
                                                <option value="{{ $locale }}"
                                                    {{ input_value($page ?? null, 'lang') == $locale ? 'selected' : null }}>
                                                    {{ str_replace('_', '-', strtoupper($locale)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- descrição --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Descrição:</label>
                                        <textarea class="form-control" name="description" id="description">{{ input_value($page ?? null, 'description') }}</textarea>
                                    </div>
                                </div>

                                {{-- tipo de conteúdo --}}
                                <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                                    <div class="form-group">
                                        <label for="content_type">Tipo de conteúdo:</label>
                                        <select class="form-control" name="content_type" id="content_type"
                                            {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                                            @foreach (m_page_content_types() as $content_type)
                                                <option value="{{ $content_type }}"
                                                    {{ input_value($page ?? null, 'content_type') == $content_type ? 'selected' : null }}>
                                                    {{ ucfirst(__('terms.page_content_types.' . $content_type)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- follow --}}
                                <div class="col-12 col-sm-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="follow"
                                                name="follow"
                                                {{ input_value($page ?? null, 'follow') ? 'checked' : null }}>
                                            <label class="custom-control-label" for="follow">
                                                Permitir que buscadores encontre esta página
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- view path field --}}
                                <div
                                    class="col-12 {{ $page ?? null ? ($page->content_type != \App\Models\Page::CONTENT_TYPE_VIEW ? 'd-none' : null) : 'd-none' }} jsViewPathField">
                                    <div class="form-group">
                                        <label for="view_path">Caminho para a página customizada:</label>
                                        @php
                                            $content = json_decode($page->content ?? '');
                                        @endphp
                                        <input class="form-control" type="text" name="view_path" id="view_path"
                                            value="{{ $content && ($content->view_path ?? null) ? $content->view_path : null }}"
                                            {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                                    </div>
                                </div>

                                {{-- text field --}}
                                <div
                                    class="col-12 {{ $page ?? null ? ($page->content_type != \App\Models\Page::CONTENT_TYPE_TEXT ? 'd-none' : null) : null }} jsTextField">
                                    <div class="form-group">
                                        <label for="content">Conteúdo:</label>
                                        <textarea id="summernoteContent" name="content">{{ input_value($page ?? null, 'content') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-row">

                                {{-- cover preview --}}
                                <div class="col-12 d-flex justify-content-center mb-3">
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="width:200px;height:100px;">
                                        @if ($page ?? null)
                                            <img class="img-fluid img-thumbnail"
                                                src="{{ m_page_cover_thumb($page, [200, 100]) }}">
                                        @else
                                            <p class="mb-0 text-muted">
                                                <small>Cover Preview</small>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- cover upload --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cover">Capa:</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="cover" id="cover"
                                                lang="{{ config('app.locale') }}">
                                            <label class="custom-file-label" for="cover">Escolher capa</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- status --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status">Salvar como:</label>
                                        <select class="form-control" name="status" id="status"
                                            {{ input_value($page ?? null, 'protection') == \App\Models\Page::PROTECTION_SYSTEM ? 'disabled' : null }}>
                                            @foreach (m_page_status() as $status)
                                                <option value="{{ $status }}"
                                                    {{ input_value($page ?? null, 'status') == $status ? 'selected' : null }}>
                                                    {{ ucfirst(__('terms.page_status.' . $status)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- schedule field --}}
                                <div
                                    class="col-12 {{ $page ?? null ? ($page->status !== \App\Models\Page::STATUS_SCHEDULED ? 'd-none' : null) : 'd-none' }} jsScheduleField">
                                    <div class="form-group">
                                        <label for="scheduled_to">Agendar para:</label>
                                        @php
                                            $scheduledTo = input_value($page ?? null, 'scheduled_to');
                                        @endphp
                                        <input class="form-control" type="date" name="scheduled_to" id="scheduled_to"
                                            value="{{ $scheduledTo ? date('Y-m-d', strtotime($scheduledTo)) : null }}">
                                    </div>
                                </div>

                                {{-- submit button --}}
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary {{ icon_class('checkLg') }}"
                                        data-active-icon="{{ icon_class('checkLg') }}"
                                        data-alt-icon="{{ icon_class('loading') }}" type="submit">
                                        @if ($page ?? null)
                                            Atualizar
                                        @else
                                            Salvar
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('assets/js/summernote.script.min.js') }}"></script>

    <script>
        /*
         * ALTERNA CAMPO DE CONTEÚDO DE ACORDO COM O TIPO DE CONTEÚDO ESCOLHIDO
         */
        $("#content_type").on("change", function() {
            if ($(this).val() == {{ \App\Models\Page::CONTENT_TYPE_VIEW }}) {
                $(".jsViewPathField").removeClass("d-none").hide().show("blind");
                $(".jsTextField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            } else if (!$(".jsViewPathField").hasClass("d-none")) {
                $(".jsTextField").removeClass("d-none").hide().show("blind");
                $(".jsViewPathField").hide("blind", function() {
                    $(this).addClass("d-none");
                });
            }
        });

        /*
         * MOSTRA/OCULTA CAMPO DE DATA 
         */
        $("#status").on("change", function() {
            let select = $(this);
            let option = select.val();

            if (option == {{ \App\Models\Page::STATUS_SCHEDULED }}) {
                $("#scheduled_to").parent().parent().removeClass("d-none").hide().show("blind", function() {
                    select.parents().eq(5).find("button[type=submit]").text("Agendar página");
                });
            } else {
                $("#scheduled_to").parent().parent().hide("blind", function() {
                    $(this).addClass("d-none");
                    select.parents().eq(5).find("button[type=submit]").text("Salvar página");
                });
            }
        });
    </script>
@endsection
