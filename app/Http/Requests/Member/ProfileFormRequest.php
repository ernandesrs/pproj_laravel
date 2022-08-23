<?php

namespace App\Http\Requests\Member;

use App\Http\Requests\TraitMyFormRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileFormRequest extends FormRequest
{
    use TraitMyFormRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "first_name" => ["required", "max:25"],
            "last_name" => ["required", "max:75"],
            "username" => ["required", "unique:users,username," . $this->user()->id, "max:25"],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "photo" => ["nullable", "mimes:jpg,png", "max:2048"],
            "password" => ["required", "min:6", "max:18", "confirmed"]
        ];

        if (empty($this->password))
            unset($rules["password"]);

        return $rules;
    }
}
