<?php

namespace App\Http\Controllers\Api;

use App\Actions\OpenWeatherMap\GetCitiesByNameAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CityRequest;
use App\Services\OpenWeatherMap\OpenWeatherMapService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class CitiesController extends Controller
{
    public function __invoke(CityRequest $request): JsonResponse
    {
        $data = $request->validated();

        $cities = app(GetCitiesByNameAction::class)->handle(
            Arr::get($data, 'city_name'),
            Arr::get($data, 'limit'),
        );

        return response()->json(compact('cities'));
    }
}