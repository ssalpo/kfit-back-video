<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'course' => Course::class,
            'workouts' => Workout::class,
        ]);

        Http::macro('withAuth', function () {
            return Http::baseUrl(config('services.kfit.urls.auth'))
                ->acceptJson()
                ->withToken(\request()->bearerToken());
        });
    }
}
