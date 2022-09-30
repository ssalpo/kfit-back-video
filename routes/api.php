<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::middleware('check.token')->get('/products', function (Request $request) {
    return response()->json(
        Http::baseUrl(config('services.kfit.urls.auth'))
            ->acceptJson()
            ->withToken($request->bearerToken())
            ->get('/api/v1/clients/4/products')
            ->json()
    );
});
