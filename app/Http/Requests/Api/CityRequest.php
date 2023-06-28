<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'city_name' => 'required|string',
            'limit'     => 'nullable|integer',
        ];
    }
}