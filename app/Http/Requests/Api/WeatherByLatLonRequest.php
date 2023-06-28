<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WeatherByLatLonRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lat'   => 'required|numeric',
            'lon'   => 'required|numeric',
            'units' => 'nullable|string|in:standard,metric,imperial',
        ];
    }
}