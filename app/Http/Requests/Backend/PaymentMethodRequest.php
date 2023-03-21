<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => ['required', 'max:255'],
                    'code' => ['required', 'max:255', 'unique:payment_methods,code'],
                    'status' => ['nullable'],
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => ['required', 'max:255'],
                    'code' => ['required', 'max:255', 'unique:payment_methods,code,' . $this->route()->payment_method->id],
                    'status' => ['nullable'],
                ];
            }
            default: break;
        }
    }
}
