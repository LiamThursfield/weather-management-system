<?php

namespace App\Http\Requests\Admin\WMS\FavouriteCity;

use App\Http\Requests\BaseIndexRequest;

class FavouriteCityIndexRequest extends BaseIndexRequest
{
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            'favourite_city_country'    => 'nullable|string',
            'favourite_city_name'       => 'nullable|string',
            'favourite_city_state'      => 'nullable|string',
        ]);
    }
}