<?php

namespace App\Actions\WMS\FavouriteCity;


use App\Models\FavouriteCity;
use App\Models\User;
use Illuminate\Support\Arr;

class FavouriteCityStoreAction
{
    public function handle(array $favourite_city_data) : FavouriteCity
    {
        if (!Arr::has($favourite_city_data, 'user_id')) {
            $favourite_city_data['user_id'] = auth()->user()->id ?? null;
        }

        return FavouriteCity::create($favourite_city_data);
    }
}
