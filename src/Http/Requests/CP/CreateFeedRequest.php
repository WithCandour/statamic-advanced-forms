<?php

namespace WithCandour\StatamicAdvancedForms\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'type' => 'required',
        ];
    }
}
