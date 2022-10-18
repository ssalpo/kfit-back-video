<?php

namespace Tests\Feature\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\CourseHelper;
use Tests\Helpers\WorkoutHelper;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    public const COURSE_RESOURCE_STRUCTURE = [
        'id', 'name', 'cover', 'duration', 'level', 'muscles', 'type'
    ];

    public const WORKOUT_RESOURCE_STRUCTURE = [
        'id', 'title', 'source_type', 'source_id', 'is_public', 'recommendations'
    ];

    /**
     * @return void
     */
    public function test_client_can_add_course_to_favorites()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedCourses = AuthServiceFakerHelper::relatedCourses();

        $form = [
            'id' => $relatedCourses[0],
            'type' => 'course',
        ];

        $response = $this->postJson('/api/v1/favorites', $form);

        $response->assertStatus(200);

        $response = $this->get('/api/v1/courses/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(1, 'data');
    }

    /**
     * @return void
     */
    public function test_client_can_remove_course_from_favorites()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedCourses = AuthServiceFakerHelper::relatedCourses();

        $form = [
            'id' => $relatedCourses[0],
            'type' => 'course',
        ];

        $this->postJson('/api/v1/favorites', $form);

        $response = $this->get('/api/v1/courses/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(1, 'data');

        $form = [
            'id' => $relatedCourses[0],
            'type' => 'course',
        ];

        $response = $this->postJson('/api/v1/favorites/delete', $form);

        $response->assertStatus(200);

        $response = $this->get('/api/v1/courses/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }

    /**
     * @return void
     */
    public function test_client_can_add_workout_to_favorites()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedWorkouts = AuthServiceFakerHelper::relatedWorkouts();

        $form = [
            'id' => $relatedWorkouts[0],
            'type' => 'workout',
        ];

        $response = $this->postJson('/api/v1/favorites', $form);

        $response->assertStatus(200);

        $response = $this->get('/api/v1/workouts/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(1, 'data');
    }

    /**
     * @return void
     */
    public function test_client_can_remove_workout_from_favorites()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedWorkouts = AuthServiceFakerHelper::relatedWorkouts();

        $form = [
            'id' => $relatedWorkouts[0],
            'type' => 'workout',
        ];

        $this->postJson('/api/v1/favorites', $form);

        $response = $this->get('/api/v1/workouts/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(1, 'data');

        $form = [
            'id' => $relatedWorkouts[0],
            'type' => 'workout',
        ];

        $response = $this->postJson('/api/v1/favorites/delete', $form);

        $response->assertStatus(200);

        $response = $this->get('/api/v1/workouts/my?favorite=1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonCount(0, 'data');
    }
}
