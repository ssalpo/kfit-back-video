<?php

namespace Tests\Helpers;

use App\Models\Course;

class CourseHelper
{
    public static function getOneRandom()
    {
        Course::factory(5)->create();

        return Course::inRandomOrder()->first();
    }
}
