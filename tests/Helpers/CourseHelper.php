<?php

namespace Tests\Helpers;

use App\Models\Course;

class CourseHelper
{
    public static function getOneRandom()
    {
        self::makeWithRecommendations();

        return Course::inRandomOrder()->first();
    }


    public static function makeWithRecommendations()
    {
        $createdCourses = Course::factory(10)->create();

        return $createdCourses
            ->each(function ($course) use ($createdCourses) {
                $course->recommendations()->sync($createdCourses->pluck('id')->random());
                $course->update(['is_public' => false]);
            });
    }
}
