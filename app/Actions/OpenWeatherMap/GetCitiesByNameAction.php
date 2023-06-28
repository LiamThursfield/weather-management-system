<?php

namespace App\Actions\OpenWeatherMap;

use App\Services\OpenWeatherMap\OpenWeatherMapService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class GetCitiesByNameAction
{
    public function handle(string $city_name, ?int $limit = 5, bool $cache = true): array
    {
        if (!$limit) {
            $limit = 5;
        }

        if ($cache) {
            // Cities shouldn't change too often, so cache for 60 minutes
            return Cache::remember(
                'openweathermap.cities.' . $city_name . '.' . $limit,
                Carbon::now()->addMinutes(60),
                function () use ($city_name, $limit) {
                    return $this->getCities($city_name, $limit);
                }
            );
        }

        return $this->getCities($city_name, $limit);
    }

    protected function getCities(string $city_name, int $limit): array
    {
        $service = new OpenWeatherMapService();
        return $service->getCities($city_name, $limit);
    }
}