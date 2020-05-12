<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'card_id' => 'required|string',
            'category' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'value' => 'required',
        ];
    }
}
