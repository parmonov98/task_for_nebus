<?php

use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
    // Organization Routes
    Route::prefix('organizations')->group(function () {
        Route::get('building/{buildingId}', [OrganizationController::class, 'getByBuilding']);
        Route::get('category/{categoryId}', [OrganizationController::class, 'getByCategory']);
        Route::post('location', [OrganizationController::class, 'getByLocation']);
        Route::get('search/category/{name}', [OrganizationController::class, 'searchByCategory']);
        Route::get('search', [OrganizationController::class, 'searchByName']);
        Route::get('{id}', [OrganizationController::class, 'show']);
    });

    // Building Routes
    Route::prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index']);
        Route::get('{id}', [BuildingController::class, 'show']);
    });
});