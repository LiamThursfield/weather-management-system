<?php

namespace App\Services\OpenWeatherMap;

use Exception;
use GuzzleHttp\Client;

class OpenWeatherMapService
{
    protected $base_uri = 'https://api.openweathermap.org/';

    /**
     * @var string
     */
    protected $api_key;


    public function __construct()
    {
        $this->api_key = config('services.openweathermap.api_key');

        if (!$this->api_key) {
            throw new Exception('OpenWeatherMap API key not set in config/services.php');
        }
    }


    /**
     *  Get a list of cities by city name
     *  For further information about this service see: https://openweathermap.org/api/geocoding-api
     */
    public function getCities(string $city_name, int $limit = 5): array
    {
        return $this->performRequest('/geo/1.0/direct', 'GET', [
            'q' => $city_name,
            'limit' => $limit,
        ]);
    }

    /**
     *  Get current weather data by city id
     *  For further information about this service see: https://openweathermap.org/current
     */
    public function getWeatherByLatLon(float $lat, float $lon, string $units = 'metric'): array
    {
        return $this->performRequest('data/2.5/weather', 'GET', [
            'lat' => $lat,
            'lon' => $lon,
            'units' => $units,
        ]);
    }

    /**
     *  Get current weather data by city name
     *  For further information about this service see: https://openweathermap.org/current
     */
    public function getWeatherByCityName(string $city_name, string $units = 'metric'): array
    {
        return $this->performRequest('data/2.5/weather', 'GET', [
            'q' => $city_name,
            'units' => $units,
        ]);
    }




    protected function performRequest(string $url, string $method = 'GET', array $data = []): array
    {
        $client = new Client([
            'base_uri' => $this->base_uri,
        ]);

        $response = $client->request($method, $url, [
            'query' => array_merge($data, [
                'appid' => $this->api_key,
            ]),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}