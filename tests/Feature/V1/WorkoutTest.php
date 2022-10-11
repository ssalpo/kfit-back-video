<?php

namespace Tests\Feature\V1;

use App\Constants\ProgressStatus;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\WorkoutHelper;
use Tests\Helpers\WorkoutVideoFakeHelper;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    const RESOURCE_STRUCTURE = [
        'id', 'title', 'source_type', 'source_id', 'is_public',
    ];


    protected function setUp(): void
    {
        parent::setUp();

        Workout::factory(10)->create();
    }

    /**
     * @return void
     */
    public function test_client_can_see_list_of_workouts()
    {
        AuthServiceFakerHelper::actAsClient();

        $response = $this->get('/api/v1/workouts');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonStructure([
                'data' => [
                    '*' => self::RESOURCE_STRUCTURE
                ]
            ]);
    }


    /**
     * @return void
     */
    public function test_admin_can_add_new_workout()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $form = [
            'title' => 'First workout for client',
            'source_type' => 1,
            'source_id' => Str::random(),
            'is_public' => false,
        ];

        $response = $this->postJson('/api/v1/workouts', $form);

        $response->assertStatus(201)
            ->assertJson(['data' => $form])
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }


    /**
     * @return void
     */
    public function test_admin_can_see_workout_info_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = WorkoutHelper::getOneRandom();

        $response = $this->getJson('/api/v1/workouts/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_edit_workout_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = WorkoutHelper::getOneRandom();

        $form = [
            'title' => 'Updated workout check',
            'source_type' => $record->source_type,
            'source_id' => $record->source_id,
            'is_public' => true,
        ];

        $response = $this->putJson('/api/v1/workouts/' . $record->id, $form);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ])
            ->assertJsonPath('data.title', $form['title'])
            ->assertJsonPath('data.is_public', $form['is_public'])
            ->assertJsonPath('data.id', $record->id);
    }

    /**
     * @return void
     */
    public function test_admin_can_delete_workout_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = WorkoutHelper::getOneRandom();

        $response = $this->deleteJson('/api/v1/workouts/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_with_role_guest_can_not_work_with_workout_data()
    {
        AuthServiceFakerHelper::actAsAdminGuest();

        $record = WorkoutHelper::getOneRandom();

        // Show
        $this->getJson('/api/v1/workouts/' . $record->id)
            ->assertStatus(403);

        // Add
        $this->postJson('/api/v1/workouts')
            ->assertStatus(403);

        // Edit
        $this->putJson('/api/v1/workouts/' . $record->id)
            ->assertStatus(403);

        // Delete
        $this->deleteJson('/api/v1/workouts/' . $record->id)
            ->assertStatus(403);

    }

    /**
     * @return void
     */
    public function test_client_can_see_their_related_workouts()
    {
        AuthServiceFakerHelper::actAsClient();

        AuthServiceFakerHelper::relatedWorkouts();

        $response = $this->get('/api/v1/workouts/my');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonStructure([
                'data' => [
                    '*' => self::RESOURCE_STRUCTURE
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_client_can_change_their_workout_progress_status()
    {
        AuthServiceFakerHelper::actAsClient();

        $relatedWorkouts = AuthServiceFakerHelper::relatedWorkouts();

        $response = $this->post('/api/v1/workouts/' . $relatedWorkouts[0] . '/change-progress', [
            'status' => ProgressStatus::PROCESS
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(self::RESOURCE_STRUCTURE, ['progress'])
            ])
            ->assertJsonPath('data.progress.status', ProgressStatus::PROCESS);
    }

    /**
     * @return void
     */
    public function test_admin_can_see_workout_external_videos_list(): void
    {
        AuthServiceFakerHelper::actAsAdmin();

        WorkoutVideoFakeHelper::initServicesFakeData();

        $workout = WorkoutHelper::getOneRandom();

        $response = $this->get('/api/v1/workouts/' . $workout->id . '/videos');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'link'
                    ]
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_see_workout_external_video_by_id(): void
    {
        AuthServiceFakerHelper::actAsAdmin();

        WorkoutVideoFakeHelper::initServicesFakeData();

        $workout = WorkoutHelper::getOneRandom();

        $response = $this->get('/api/v1/workouts/' . $workout->id . '/videos/404743e1-4ec5-485e-b762-43440a8ab69b');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonStructure([
                'data' => [
                    'id', 'link'
                ]
            ]);
    }
}
