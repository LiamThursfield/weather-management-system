<?php

namespace App\Actions\OpenWeatherMap;

use App\Services\OpenWeatherMap\OpenWeatherMapService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class GetWeatherByCityNameAction
{
    public function handle(string $city_name, ?string $units = 'metric', bool $cache = true): array
    {
        if (!$units) {
            $units = 'metric';
        }

        if ($cache) {
            // Due to the frequency of weather changes, cache for 15 minutes
            return Cache::remember(
                'openweathermap.weatherbycityname.' . $city_name . '.' . $units,
                Carbon::now()->addMinutes(15),
                function () use ($city_name, $units) {
                    return $this->getWeather($city_name, $units);
                }
            );
        }

        return $this->getWeather($city_name, $units);
    }

    protected function getWeather(string $city_name, string $units): array
    {
        $service = new OpenWeatherMapService();
        return $service->getWeatherByCityName($city_name, $units);
    }
}