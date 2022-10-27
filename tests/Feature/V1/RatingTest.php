<?php

namespace Tests\Feature\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\TestCase;

class RatingTest extends TestCase
{
    /**
     * @return void
     */
    public function test_client_can_add_rating_to_courses()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedCourses = AuthServiceFakerHelper::relatedCourses();

        $response = $this->post('/api/v1/ratings/', [
            'id' => $relatedCourses[0],
            'type' => 'course',
            'rating' => 3.5
        ]);

        $response->assertStatus(200);

        $response = $this->getJson('/api/v1/courses/my');

        $ratings = array_values(array_filter(
            $response->json('data') ?? [],
            static fn($item) => $item['rating'] !== 0
        ));

        $response->assertStatus(200);

        $this->assertGreaterThan(0, $ratings[0]['rating']);
    }

    /**
     * @return void
     */
    public function test_client_can_add_rating_to_workouts()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedWorkouts = AuthServiceFakerHelper::relatedWorkouts();

        $response = $this->post('/api/v1/ratings/', [
            'id' => $relatedWorkouts[0],
            'type' => 'workout',
            'rating' => 2.5
        ]);

        $response->assertStatus(200);

        $response = $this->getJson('/api/v1/workouts/my');

        $ratings = array_values(array_filter($response->json('data'), fn($item) => $item['rating'] != 0));

        $response->assertStatus(200);

        $this->assertGreaterThan(0, $ratings[0]['rating']);
    }
}
