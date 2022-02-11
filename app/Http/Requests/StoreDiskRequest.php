<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class StoreDiskRequest extends FormRequest
{
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
        return [
            "author_name" => "required|string|min:3|max:255",
            "title" => "required|string|min:3|max:255",
            "year" => "required|digits:4|integer|max:" . (date('Y') + 1)
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            Log::channel('scanner')->error('error request', [
                'request' => $this->all(),
                'errors' => $validator->errors()->toArray()
            ]);
        });
    }
}
