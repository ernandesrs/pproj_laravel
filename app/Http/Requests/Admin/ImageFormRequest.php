<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\MyFormRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ImageFormRequest extends FormRequest
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
            "name" => ["nullable", "max:125"],
            "tags" => ["nullable", "max:100"]
        ];

        if (!$this->image)
            $rules += ["file" => ["required", "max:5000", "mimes:png,jpg,webp"]];

        return $rules;
    }
}
