<?php

namespace Tests\Feature\V1;

use App\Constants\ProgressStatus;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\CourseHelper;
use Tests\TestCase;

class CourseTest extends TestCase
{
    const RESOURCE_STRUCTURE = [
        'id', 'name', 'cover', 'duration', 'level', 'muscles', 'type', 'active'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Course::factory(10)->create();
    }

    /**
     * @return void
     */
    public function test_client_can_see_list_of_courses()
    {
        AuthServiceFakerHelper::actAsClient();

        $response = $this->get('/api/v1/courses');

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
    public function test_admin_can_add_new_course()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $form = [
            'name' => 'First course for clients',
            'duration' => '2:15',
            'level' => 1,
            'muscles' => 'some muscules',
            'type' => 'course'
        ];

        $response = $this->postJson('/api/v1/courses', $form);

        $response->assertStatus(201)
            ->assertJson(['data' => $form])
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_see_course_info_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = CourseHelper::getOneRandom();

        $response = $this->getJson('/api/v1/courses/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_can_edit_course_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = CourseHelper::getOneRandom();

        $form = [
            'name' => 'Updated course check'
        ];

        $response = $this->putJson('/api/v1/courses/' . $record->id, $form);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ])
            ->assertJsonPath('data.name', $form['name'])
            ->assertJsonPath('data.id', $record->id);
    }

    /**
     * @return void
     */
    public function test_admin_can_delete_course_by_id()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $record = CourseHelper::getOneRandom();

        $response = $this->deleteJson('/api/v1/courses/' . $record->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);
    }

    /**
     * @return void
     */
    public function test_admin_with_role_guest_can_not_work_with_course_data()
    {
        AuthServiceFakerHelper::actAsAdminGuest();

        $record = CourseHelper::getOneRandom();

        // Show
        $this->getJson('/api/v1/courses/' . $record->id)
            ->assertStatus(403);

        // Add
        $this->postJson('/api/v1/courses')
            ->assertStatus(403);

        // Edit
        $this->putJson('/api/v1/courses/' . $record->id)
            ->assertStatus(403);

        // Delete
        $this->deleteJson('/api/v1/courses/' . $record->id)
            ->assertStatus(403);

    }

    /**
     * @return void
     */
    public function test_client_can_see_their_related_courses()
    {
        AuthServiceFakerHelper::actAsClient();

        AuthServiceFakerHelper::relatedCourses();

        $response = $this->get('/api/v1/courses/my');

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
    public function test_client_can_change_their_course_progress_status()
    {
        AuthServiceFakerHelper::actAsClient();


        $relatedCourses = AuthServiceFakerHelper::relatedCourses();

        $response = $this->post('/api/v1/courses/' . $relatedCourses[0] . '/change-progress', [
            'status' => ProgressStatus::START
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => array_merge(self::RESOURCE_STRUCTURE, ['progress'])
            ])
            ->assertJsonPath('data.progress.status', ProgressStatus::START);
    }

    /**
     * @return void
     */
    public function test_admin_can_change_courses_activity_status()
    {
        AuthServiceFakerHelper::actAsAdmin();

        $course = CourseHelper::getOneRandom();

        $response = $this->post('/api/v1/courses/' . $course->id . '/change-activity', [
            'status' => 1
        ]);

        $response->assertStatus(200);

        $response = $this->getJson('/api/v1/courses/' . $course->id);

        $response->assertStatus(200)
            ->assertJsonPath('data.active', true);
    }
}
