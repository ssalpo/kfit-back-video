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
    // Course routes
    Route::get('courses/my', [\App\Http\Controllers\ApiV1\CourseController::class, 'my']);
    Route::post('/courses/{course}/change-progress', [\App\Http\Controllers\ApiV1\CourseController::class, 'changeProgress']);
    Route::apiResource('courses', \App\Http\Controllers\ApiV1\CourseController::class);

    // Workout routes
    Route::get('workouts/my', [\App\Http\Controllers\ApiV1\WorkoutController::class, 'my']);
    Route::post('/workouts/{workout}/change-progress', [\App\Http\Controllers\ApiV1\WorkoutController::class, 'changeProgress']);
    Route::apiResource('workouts', \App\Http\Controllers\ApiV1\WorkoutController::class);

    // File routes
    Route::post('/files/upload', [\App\Http\Controllers\ApiV1\FileController::class, 'upload']);
    Route::get('/files/{model}/{folder}/{filename}', [\App\Http\Controllers\ApiV1\FileController::class, 'file']);
    Route::get('/files/image/{model}/{folder}/{filename}/{width}/{height}', [\App\Http\Controllers\ApiV1\FileController::class, 'image']);
});
