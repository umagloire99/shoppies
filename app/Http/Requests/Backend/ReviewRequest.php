<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|email',
            'title' => ['required', 'min:3', 'string'],
            'message' => ['required', 'min:3', 'string'],
            'images' => ['nullable'],
            'images.*' => ['mimes:jpg,jpeg,png,gif', 'max:3000']
        ];
    }
}
