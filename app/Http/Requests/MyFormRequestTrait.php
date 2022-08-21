<?php

namespace App\Http\Requests;

trait MyFormRequestTrait
{
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->messages()) {
                $validator->errors()->add("message", message()->warning(__("messages.validations.invalid_data"))->render());
            }
        });
    }
}
