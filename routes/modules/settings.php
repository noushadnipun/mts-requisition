<?php

use App\Http\Controllers\SettingController;

Route::group(['middleware' => 'role:1'], function () {
    Route::any('settings/global/{id}', [SettingController::class, 'global'])->name('settings.global');
    Route::any('settings/payment/{id}', [SettingController::class, 'payment'])->name('settings.payment');
    Route::any('settings/time/{id}', [SettingController::class, 'time'])->name('settings.time');
    Route::any('settings/email/{id}', [SettingController::class, 'email'])->name('settings.email');
    Route::any('settings/other/{id}', [SettingController::class, 'other'])->name('settings.other');


    Route::resources([
        'settings' => SettingController::class,
    ]);
});
