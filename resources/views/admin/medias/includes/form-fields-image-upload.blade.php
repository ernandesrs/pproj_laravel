<form class="jsFormSubmit" action="" method="post">
    <div class="form-row">
        @csrf

        {{-- message area --}}
        <div class="col-12">
            @include('includes.message')
        </div>

        {{-- file --}}
        <div class="col-12">
            <div class="form-group">
                <label for="file">Imagem:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file"
                        lang="{{ app()->getLocale() }}">
                    <label class="custom-file-label" for="file">Escolher arquivo</label>
                </div>
            </div>
        </div>

        {{-- name --}}
        <div class="col-12">
            <div class="form-group">
                <label for="name">Nome <small>(opcional)</small>:</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
        </div>

        {{-- tags --}}
        <div class="col-12">
            <div class="form-group">
                <label for="tags">Tags <small>(opcional)</small>:</label>
                <input class="form-control" type="text" name="tags" id="tags">
                <small class="text-muted text-help">
                    Palavras separadas por vírgulas que remetam as esta imagem.
                </small>
            </div>
        </div>

        {{-- submit button --}}
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary {{ icon_class('checkLg') }}"
                data-active-icon="{{ icon_class('checkLg') }}" data-alt-icon="{{ icon_class('loading') }}"></button>
        </div>

    </div>
</form>
