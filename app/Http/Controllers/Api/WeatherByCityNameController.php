<?php

namespace App\Http\Controllers\Api;

use App\Actions\OpenWeatherMap\GetWeatherByCityNameAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeatherByCityNameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class WeatherByCityNameController extends Controller
{
    public function __invoke(WeatherByCityNameRequest $request): JsonResponse
    {
        $data = $request->validated();

        $weather = app(GetWeatherByCityNameAction::class)->handle(
            Arr::get($data, 'city_name'),
            Arr::get($data, 'units')
        );

        return response()->json($weather);
    }
}