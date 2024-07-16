<?php

use Illuminate\Support\Facades\Route;
use Modules\Coach\Http\Controllers\CoachController;
use Modules\Coach\Http\Controllers\API\CoachesProfileController;


Route::prefix('v1')->group(function () {
    Route::apiResource('coaches_profile', CoachesProfileController::class);
});
