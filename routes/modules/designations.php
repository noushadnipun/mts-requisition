<?php

use App\Http\Controllers\DesignationController;

Route::group(['middleware' => 'role:1,7'], function () {
    Route::resources([
        'designations' => DesignationController::class,
    ]);
});
