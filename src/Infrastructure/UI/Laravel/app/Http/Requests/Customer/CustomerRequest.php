<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pay_day' => 'required',
            'limit' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
