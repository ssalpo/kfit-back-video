<?php

namespace Tests\Helpers;

use App\Models\Workout;

class WorkoutHelper
{
    public static function getOneRandom()
    {
        self::makeWithRecommendations();

        return Workout::inRandomOrder()->first();
    }

    public static function makeWithRecommendations()
    {
        $createdWorkouts = Workout::factory(10)->create();

        return $createdWorkouts
            ->each(function($workout) use ($createdWorkouts){
                $workout->recommendations()->sync($createdWorkouts->pluck('id')->random());
                $workout->update(['is_public' => false]);
            });
    }
}
