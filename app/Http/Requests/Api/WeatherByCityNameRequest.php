<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WeatherByCityNameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'city_name' => 'required|string',
            'units'     => 'nullable|string|in:standard,metric,imperial',
        ];
    }
}