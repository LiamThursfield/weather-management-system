<?php

namespace App\Http\Controllers\Api;

use App\Actions\OpenWeatherMap\GetWeatherByLatLonAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeatherByLatLonRequest;
use App\Services\OpenWeatherMap\OpenWeatherMapService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class WeatherByLatLonController extends Controller
{
    public function __invoke(WeatherByLatLonRequest $request): JsonResponse
    {
        $data = $request->validated();

        $weather = app(GetWeatherByLatLonAction::class)->handle(
            Arr::get($data, 'lat'),
            Arr::get($data, 'lon'),
            Arr::get($data, 'units')
        );

        return response()->json($weather);
    }
}