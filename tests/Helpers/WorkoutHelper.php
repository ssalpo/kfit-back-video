<?php

namespace Tests\Helpers;

use App\Models\Workout;

class WorkoutHelper
{
    public static function getOneRandom()
    {
        Workout::factory(5)->create();

        return Workout::inRandomOrder()->first();
    }
}
