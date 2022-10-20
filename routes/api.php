<?php

use App\Http\Controllers\ApiV1\Course\CourseFavoriteController;
use App\Http\Controllers\ApiV1\CourseController;
use App\Http\Controllers\ApiV1\FavoriteController;
use App\Http\Controllers\ApiV1\FileController;
use App\Http\Controllers\ApiV1\RatingController;
use App\Http\Controllers\ApiV1\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('check.token')->group(function () {
    // Course routes
    Route::get('courses/my', [CourseController::class, 'my']);
    Route::get('/courses/all', [CourseController::class, 'all']);
    Route::post('/courses/{course}/change-progress', [CourseController::class, 'changeProgress']);
    Route::post('/courses/{course}/change-activity', [CourseController::class, 'changeActivity']);
    Route::apiResource('courses', CourseController::class);

    // Favorites route
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::post('/favorites/delete', [FavoriteController::class, 'destroy']);

    // Ratings route
    Route::post('/ratings', [RatingController::class, 'store']);

    // Workout routes
    Route::get('/workouts/my', [WorkoutController::class, 'my']);
    Route::get('/workouts/all', [WorkoutController::class, 'all']);
    Route::post('/workouts/{workout}/change-progress', [WorkoutController::class, 'changeProgress']);
    Route::post('/workouts/{workout}/change-activity', [WorkoutController::class, 'changeActivity']);
    Route::get('/workouts/{workout}/videos', [WorkoutController::class, 'getExternalVideos']);
    Route::post('/workouts/{workout}/videos/upload', [WorkoutController::class, 'uploadVideoById']);
    Route::get('/workouts/{workout}/videos/{video}', [WorkoutController::class, 'getVideoById']);
    Route::apiResource('workouts', WorkoutController::class);

    // File routes
    Route::post('/files/upload', [FileController::class, 'upload']);
    Route::get('/files/{model}/{folder}/{filename}', [FileController::class, 'file']);
    Route::get('/files/image/{model}/{folder}/{filename}/{width}/{height}', [FileController::class, 'image']);
});
