<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
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
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'user_id' => ['required'],
                    'address_title' => ['required'],
                    'name' => ['string'],
                    'email' => ['string', 'email'],
                    'phone_one' => 'required|phone:CM',
                    'phone_two' => 'required|phone:CM',
                    'city_id' => ['required'],
                    'zip_code' => ['nullable'],
                    'po_box' => ['nullable'],
                ];
            }
            default: break;
        }

    }
}
