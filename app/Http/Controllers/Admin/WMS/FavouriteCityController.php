<?php

namespace App\Http\Controllers\Admin\WMS;

use App\Actions\WMS\FavouriteCity\FavouriteCityQueryAction;
use App\Actions\WMS\FavouriteCity\FavouriteCityStoreAction;
use App\Actions\WMS\FavouriteCity\FavouriteCityUpdateAction;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\WMS\FavouriteCity\FavouriteCityIndexRequest;
use App\Http\Requests\Admin\WMS\FavouriteCity\FavouriteCityStoreRequest;
use App\Http\Requests\Admin\WMS\FavouriteCity\FavouriteCityUpdateRequest;
use App\Http\Resources\Admin\WMS\FavouriteCityResource;
use App\Interfaces\AppInterface;
use App\Interfaces\PermissionInterface;
use App\Models\FavouriteCity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\UnauthorizedException;
use Inertia\Inertia;
use Inertia\Response;

class FavouriteCityController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->addMetaTitleSection('WMS');
        $this->addMetaTitleSection('Favourite Cities');

        $this->middleware(
            PermissionInterface::getMiddlewareString(PermissionInterface::CREATE_WMS)
        )->only(['create', 'store']);

        $this->middleware(
            PermissionInterface::getMiddlewareString(PermissionInterface::DELETE_WMS)
        )->only('destroy');

        $this->middleware(
            PermissionInterface::getMiddlewareString(PermissionInterface::EDIT_WMS)
        )->only(['edit', 'update']);

        $this->middleware(
            PermissionInterface::getMiddlewareString(PermissionInterface::VIEW_WMS)
        )->only('index');
    }

    public function create() : Response
    {
        $this->addMetaTitleSection('Create')->shareMeta();
        return Inertia::render('admin/wms/favourite_city/Create');
    }

    public function destroy(FavouriteCity $favouriteCity) : RedirectResponse
    {
        $this->canManageFavouriteCity(
            $favouriteCity,
            PermissionInterface::DELETE_WMS_ADMIN,
            'You are not allowed to delete this Favourite City.'
        );

        $favouriteCity->delete();

        return Redirect::back(303)->with(
            'success',
            'Favourite City deleted.'
        );
    }

    public function edit(FavouriteCity $favouriteCity) : Response
    {
        $this->canManageFavouriteCity(
            $favouriteCity,
            PermissionInterface::EDIT_WMS_ADMIN,
            'You are not allowed to delete this Favourite City.'
        );

        $this->addMetaTitleSection('Edit - ' . $favouriteCity->name)->shareMeta();
        return Inertia::render('admin/wms/favourite_city/Edit', [
            'favouriteCity' => function () use ($favouriteCity) {
                FavouriteCityResource::withoutWrapping();
                return FavouriteCityResource::make($favouriteCity);
            }
        ]);
    }

    public function index(FavouriteCityIndexRequest $request) : Response
    {
        $search_options = $request->validated();

        $user = auth()->user();
        if (!$user->hasPermissionTo(PermissionInterface::VIEW_WMS_ADMIN)) {
            $search_options['favourite_city_user_id'] = $user->id;
        }

        $this->shareMeta();
        return Inertia::render('admin/wms/favourite_city/Index', [
            'searchOptions' => $search_options,
            'favouriteCities' => function () use ($search_options, $user) {
                $query = app(FavouriteCityQueryAction::class)->handle($search_options);

                // Allow admins to view the user associated with the favourite city
                if ($user->can(PermissionInterface::VIEW_WMS_ADMIN)) {
                    $query->with('user');
                }

                return $query->paginate(AppInterface::getSearchPaginationParam($search_options));
            }
        ]);
    }

    public function store(FavouriteCityStoreRequest $request) : RedirectResponse
    {
        $data = $request->validated();

        $favouriteCity = app(FavouriteCityStoreAction::class)->handle($data);
        return Redirect::to(route('admin.wms.favourite-cities.edit', $favouriteCity))
            ->with('success', 'Favourite City created.');
    }

    public function update(FavouriteCityUpdateRequest $request, FavouriteCity $favouriteCity) : RedirectResponse
    {
        app(FavouriteCityUpdateAction::class)->handle($favouriteCity, $request->validated(), true);
        return Redirect::to(route('admin.wms.favourite-cities.edit', $favouriteCity))
            ->with('success', 'Favourite City updated.');
    }


    protected function canManageFavouriteCity(
        FavouriteCity $favouriteCity,
        string $permission,
        string $errorMessage
    ): void
    {
        $user = auth()->user();
        if (
            $favouriteCity->user_id !== $user->id &&
            $user->cannot($permission)
        ) {
            throw new UnauthorizedException($errorMessage);
        }
    }
}