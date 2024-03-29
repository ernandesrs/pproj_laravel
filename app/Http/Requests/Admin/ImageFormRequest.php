<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\TraitMyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ImageFormRequest extends FormRequest
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
            "name" => ["nullable", "max:125"],
            "tags" => ["nullable", "max:100"],
            "file" => ["required", "max:5000", "mimes:png,jpg,webp"],
        ];

        if ($this->image) {
            $rules["name"] = ["required", "max:125"];
            unset($rules["file"]);
        }

        return $rules;
    }
}
