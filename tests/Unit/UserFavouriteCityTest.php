<?php

namespace Tests\Unit;

use App\Interfaces\PermissionInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserFavouriteCityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_have_favourite_cities()
    {
        $user = User::factory()->create();

        $this->assertCount(0, $user->favouriteCities);

        $user->favouriteCities()->create([
            'name' => 'London',
            'lat' => 51.5074,
            'lon' => 0.1278,
            'country' => 'GB',
            'state' => 'London',
        ]);

        $this->assertCount(1, $user->fresh()->favouriteCities);
    }
}
