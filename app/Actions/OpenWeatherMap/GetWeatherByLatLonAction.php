<?php

namespace App\Actions\OpenWeatherMap;

use App\Services\OpenWeatherMap\OpenWeatherMapService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class GetWeatherByLatLonAction
{
    public function handle(float $lat, float $lon, ?string $units = 'metric', bool $cache = true): array
    {
        if (!$units) {
            $units = 'metric';
        }

        if ($cache) {
            // Due to the frequency of weather changes, cache for 15 minutes
            return Cache::remember(
                'openweathermap.weatherbylatlon.' . $lat . '.' . $lon . '.' . $units,
                Carbon::now()->addMinutes(15),
                function () use ($lat, $lon, $units) {
                    return $this->getWeather($lat, $lon, $units);
                }
            );
        }

        return $this->getWeather($lat, $lon, $units);
    }

    protected function getWeather(float $lat, float $lon, string $units): array
    {
        $service = new OpenWeatherMapService();
        return $service->getWeatherByLatLon($lat, $lon, $units);
    }
}