<?php

namespace Database\Seeders;

use App\Interfaces\RoleInterface;
use App\Models\FavouriteCity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FavouriteCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::factory(3)->create() as $user) {
            FavouriteCity::factory(4)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
