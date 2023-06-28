<?php

namespace Database\Factories;

use App\Models\FavouriteCity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FavouriteCityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FavouriteCity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->longitude,
            'country' => $this->faker->countryCode,
            'state' => $this->faker->state,
            'user_id' => User::factory(),
        ];
    }
}
