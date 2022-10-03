<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('check.token')->group(function () {
    Route::apiResource('courses', \App\Http\Controllers\ApiV1\CourseController::class);
    Route::apiResource('workouts', \App\Http\Controllers\ApiV1\WorkoutController::class);
});
