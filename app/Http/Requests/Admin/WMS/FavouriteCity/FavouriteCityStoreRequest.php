<?php

namespace App\Http\Requests\Admin\WMS\FavouriteCity;

use App\Http\Requests\BaseRequest;

class FavouriteCityStoreRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'country'   => 'required|string|max:255',
            'lat'       => 'required|numeric',
            'lon'       => 'required|numeric',
            'name'      => 'required|string|max:255',
            'state'     => 'nullable|string|max:255',
        ];
    }
}