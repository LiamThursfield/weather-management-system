<?php

namespace App\Actions\WMS\FavouriteCity;


use App\Models\FavouriteCity;
use App\Models\User;

class FavouriteCityUpdateAction
{
    public function handle(FavouriteCity $favouriteCity, array $favourite_city_data, bool $refresh = false) : FavouriteCity
    {
        $favouriteCity->update($favourite_city_data);

        if ($refresh) {
            $favouriteCity->refresh();
        }

        return $favouriteCity;
    }
}
