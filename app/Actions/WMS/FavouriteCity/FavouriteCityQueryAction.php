<?php

namespace App\Actions\WMS\FavouriteCity;

use App\Actions\AbstractQueryAction;
use App\Models\FavouriteCity;
use Illuminate\Database\Eloquent\Builder;

class FavouriteCityQueryAction extends AbstractQueryAction
{
    protected array $searchable_fields_equals  = [
        'user_id' => 'favourite_city_user_id',
    ];
    protected array $searchable_fields_likes  = [
        'country'   => 'favourite_city_country',
        'name'      => 'favourite_city_name',
        'state'     => 'favourite_city_state',
    ];

    protected string $order_by = 'name';

    protected function getQueryBuilder(): Builder
    {
        return FavouriteCity::query();
    }
}