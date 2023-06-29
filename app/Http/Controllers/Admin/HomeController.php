<?php

namespace App\Http\Controllers\Admin;

use App\Actions\WMS\FavouriteCity\FavouriteCityQueryAction;
use App\Http\Controllers\AdminController;
use App\Http\Resources\Admin\WMS\FavouriteCityResource;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends AdminController
{
    /**
     * Show the admin index.
     *
     * @return Response
     */
    public function index()
    {
        $this->shareMeta();

        return Inertia::render('admin/home/Index', [
            'favouriteCities' => function () {
                $query = app(FavouriteCityQueryAction::class)->handle([
                    'favourite_city_user_id' => auth()->user()->id,
                ]);

                FavouriteCityResource::withoutWrapping();
                return FavouriteCityResource::collection(
                    $query->limit(4)->get()
                );
            }
        ]);
    }
}
