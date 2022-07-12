<div class="form-row">
    <div class="col-12 col-md-4">
        <div class="form-row">
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

            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="content_type">Tipo de conteúdo:</label>
                    <select class="form-control" name="content_type" id="content_type">
                    </select>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                <div class="form-group">
                    <label for="status">Salvar como:</label>
                    <select class="form-control" name="status" id="status">
                    </select>
                </div>
            </div>

            <div class="col-12 d-none jsScheduleField">
                <div class="form-group">
                    <label for="schedule">Agendar para:</label>
                    <input class="form-control" type="date" name="schedule" id="schedule">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-8">
        <div class="form-row">
            <div class="col-12 col-md-8 col-xl-10">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ input_value($page ?? null, 'title') }}">
                </div>
            </div>

            <div class="col-12 col-md-4 col-xl-2">
                <div class="form-group">
                    <label for="lang">Idioma:</label>
                    @php
                        $locales = config('app.locales') ?? [config('app.locale')];
                    @endphp
                    <select class="form-control" name="lang" id="lang"
                        {{ count($locales) <= 1 ? 'disabled' : null }}>
                        @foreach ($locales as $locale)
                            <option value="{{ $locale }}">{{ str_replace('_', '-', strtoupper($locale)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input class="form-control" type="text" name="slug" id="slug"
                        value="{{ input_value($page ?? null, 'slug') }}">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea class="form-control" name="description" id="description">{{ input_value($page ?? null, 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
