<?php

use App\Http\Controllers\RoutelistController;

Route::group(['middleware' => 'role:1'], function () {
    Route::any('routelists/search', [RoutelistController::class, 'search'])->name('routelists.search');

    Route::resources([
        'routelists' => RoutelistController::class,
    ]);
});
