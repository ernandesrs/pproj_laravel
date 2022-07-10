@php

function input_value($data, $key)
{
    if (!$data) {
        return null;
    }
    $data = is_array($data) ? (object) $data : $data;
    return $data->$key;
}

@endphp
<div class="form-row">

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="first_name">Nome:</label>
            <input class="form-control" type="text" name="first_name" id="first_name"
                value="{{ input_value($user ?? null, 'first_name') }}">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="last_name">Sobrenome:</label>
            <input class="form-control" type="text" name="last_name" id="last_name"
                value="{{ input_value($user ?? null, 'last_name') }}">
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-12 col-xl-6">
        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="text" name="email" id="email"
                value="{{ input_value($user ?? null, 'email') }}" {{ $user ?? null ? 'readonly' : null }}>
        </div>
    </div>

    <div class="col-6 col-md-3 col-lg-6 col-xl-3">
        <div class="form-group">
            <label for="level">Tipo de usuário:</label>
            @php
                $levels = \App\Models\User::LEVELS;
            @endphp
            <select class="form-control" name="level" id="level"
                {{ $user ?? null ? ($user->id == auth()->user()->id ? 'disabled' : null) : null }}>
                @foreach ($levels as $level)
                    <option value="{{ $level }}"
                        {{ input_value($user ?? null, 'level') == $level ? 'selected' : null }}>
                        {{ ucfirst(__('terms.user_level.' . $level)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6 col-md-3 col-lg-6 col-xl-3">
        <div class="form-group">
            <label for="gender">Gênero:</label>
            @php
                $genders = \App\Models\User::GENDERS;
            @endphp
            <select class="form-control" name="gender" id="gender">
                @foreach ($genders as $gender)
                    <option value="{{ $gender }}"
                        {{ input_value($user ?? null, 'gender') == $gender ? 'selected' : null }}>
                        {{ ucfirst(__('terms.user_gender.' . $gender)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="photo">Foto:</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="photo" id="photo">
                <label class="custom-file-label" for="photo">Escolher arquivo</label>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="password">Senha:</label>
            <input class="form-control" type="password" name="password" id="password" autocomplete="new-password">
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirmar senha:</label>
            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                autocomplete="new-password">
        </div>
    </div>

</div>