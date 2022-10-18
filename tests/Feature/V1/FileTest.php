<?php

namespace Tests\Feature\V1;

use App\Services\TempFileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Helpers\AuthServiceFakerHelper;
use Tests\Helpers\CourseHelper;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    const RESOURCE_STRUCTURE = ['id', 'user_filename'];

    /**
     * @return void
     */
    public function test_admin_can_upload_file()
    {
        Storage::fake('local');

        AuthServiceFakerHelper::actAsAdmin();

        $file = UploadedFile::fake()->image('cover.jpg');

        $response = $this->postJson('/api/v1/files/upload', [
            'file' => $file,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => self::RESOURCE_STRUCTURE
            ]);

        $path = TempFileService::TMP_FOLDER_NAME . DIRECTORY_SEPARATOR . $response->json('data.id');

        Storage::disk('local')->assertExists($path);
    }

    public function test_user_can_view_their_course_cover_and_resize_it()
    {
        Storage::fake('local');

        AuthServiceFakerHelper::actAsAdmin();

        $course = CourseHelper::getOneRandom();

        $file = UploadedFile::fake()->image('cover.jpg');

        $response = $this->postJson('/api/v1/files/upload', [
            'file' => $file,
        ]);

        $cover = $response->json('data.id');

        $form = [
            'name' => $course->name,
            'cover' => $cover
        ];

        // Update cover
        $response = $this->putJson('/api/v1/courses/' . $course->id, $form);

        $response->assertStatus(200)
            ->assertJsonPath('data.cover', $cover);

        $path = '/files/course/cover/' . $cover;

        Storage::disk('local')->assertExists($path);

        $response = $this->getJson('/api/v1/files/course/cover/' . $cover);

        $response->assertHeader('Content-type', $file->getMimeType());

        $response = $this->getJson("/api/v1/files/image/course/cover/$cover/200/200");

        $response->assertHeader('Content-type', $file->getMimeType());
    }
}
