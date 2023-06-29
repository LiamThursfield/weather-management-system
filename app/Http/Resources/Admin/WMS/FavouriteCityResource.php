<?php

namespace App\Http\Resources\Admin\WMS;

use App\Http\Resources\Admin\User\UserEditResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteCityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'country'   => $this->country,
            'id'        => $this->id,
            'lat'       => $this->lat,
            'lon'       => $this->lon,
            'name'      => $this->name,
            'state'     => $this->state,
            'user_id'   => $this->user_id,
            'user'      => UserEditResource::make($this->whenLoaded('user')),
        ];
    }
}
