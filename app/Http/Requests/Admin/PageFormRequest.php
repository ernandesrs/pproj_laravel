<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\TraitMyFormRequest;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageFormRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (empty($this->lang))
            $this->merge([
                "lang" => config("app.locale")
            ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "title" => ["required", "unique:pages,title", "max:100"],
            "description" => ["required", "max:160"],
            "cover" => ["mimes:jpg,png,webp", "max:2048", Rule::dimensions()->minWidth(800)->minHeight(600)],
            "lang" => [Rule::in(config("app.locales"))],
            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "content" => ["nullable"],
            "follow" => ["string"],
            "status" => ["required", Rule::in(Page::STATUS)],
            "scheduled_to" => ["required_if:status," . Page::STATUS_SCHEDULED],
            "view_path" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW],
        ];

        if ($this->page) {
            $rules["title"] = ["required", "unique:pages,title," . $this->page->id, "max:100"];

            if ($this->page->protection == Page::PROTECTION_SYSTEM) {
                unset($rules["content_type"]);
                unset($rules["status"]);
            }
        }

        return $rules;
    }
}
