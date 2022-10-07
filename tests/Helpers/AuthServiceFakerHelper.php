<?php

namespace Tests\Helpers;

use App\Constants\GoodsType;
use App\Models\Course;
use App\Models\Workout;
use Illuminate\Support\Facades\Http;

class AuthServiceFakerHelper
{
    public static function actAsClient()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ayana Runolfsson",
                    "email" => "gussie91@example.com",
                    "avatar" => null,
                    "active" => true,
                ]
            ])
        ]);
    }

    public static function actAsAdmin()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ms. Burdette Gibson III",
                    "email" => "zgreenfelder@example.net",
                    "avatar" => null,
                    "active" => true,
                    "roles" => [
                        ['id' => 1, 'title' => 'Администратор', 'name' => 'admin']
                    ]
                ]
            ])
        ]);
    }

    public static function actAsAdminGuest()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ms. Burdette Gibson III",
                    "email" => "zgreenfelder@example.net",
                    "avatar" => null,
                    "active" => true,
                    "roles" => [
                        ['id' => 2, 'title' => 'Гость', 'name' => 'guest']
                    ]
                ]
            ])
        ]);
    }

    public static function relatedCourses(): array
    {
        $courses = Course::factory(10)->create()
            ->each(fn($course) => $course->update(['is_public' => false]))
            ->pluck('id')->toArray();

        $data = [];

        foreach ($courses as $course) {
            $data[] = [
                'product_id' => rand(1, 10),
                'related_id' => $course,
                'related_type' => GoodsType::COURSE
            ];
        }

        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/goods/' . GoodsType::COURSE => Http::response($data)
        ]);

        return $courses;
    }

    public static function relatedWorkouts(): array
    {
        $workouts = Workout::factory(10)->create()
            ->each(fn($workout) => $workout->update(['is_public' => false]))
            ->pluck('id')->toArray();

        $data = [];

        foreach ($workouts as $workout) {
            $data[] = [
                'product_id' => rand(1, 10),
                'related_id' => $workout,
                'related_type' => GoodsType::WORKOUT
            ];
        }

        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/goods/' . GoodsType::WORKOUT => Http::response($data)
        ]);

        return $workouts;
    }
}
