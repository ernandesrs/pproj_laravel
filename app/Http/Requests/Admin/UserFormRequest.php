<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyFormRequestTrait;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    use MyFormRequestTrait;

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
            "username" => ["required", "max:25"],
            "email" => ["required", "email", "unique:users,email"],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "photo" => ["nullable", "mimes:jpg,png", "max:2048"],
            "password" => ["required", "min:6", "max:12", "confirmed"]
        ];

        if ($this->user) {
            $rules["email"] = ["required", "email", "unique:users,email," . $this->user->id];

            if (empty($this->password))
                unset($rules["password"]);
        }

        return $rules;
    }
}
