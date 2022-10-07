<?php

namespace App\Services;

use App\Constants\TempFile;
use App\Models\Course;
use Illuminate\Support\Arr;

class CourseService
{
    private TempFileService $tempFileService;

    public function __construct(TempFileService $tempFileService)
    {
        $this->tempFileService = $tempFileService;
    }

    /**
     * Adds a new course
     *
     * @param array $data
     * @return Course
     */
    public function create(array $data): Course
    {
        $course = Course::create($data);

        if ($course->cover) $this->tempFileService->moveFromTmpFolder(TempFile::FOLDER_COURSE_COVER, $course->cover);

        return $course;
    }

    /**
     * Update course data by ID
     *
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function update(int $id, array $data): Course
    {
        $course = Course::findOrFail($id);

        $oldCover = $course->cover;

        $isCoverChanged = $course->cover !== Arr::get($data, 'cover');

        $course->update($data);

        if ($isCoverChanged) {
            $this->tempFileService->moveFromTmpFolder(TempFile::FOLDER_COURSE_COVER, $course->cover);

            if ($oldCover) $this->tempFileService->removeFileFromFolder(TempFile::FOLDER_COURSE_COVER, $oldCover);
        }

        return $course->refresh();
    }

    /**
     * Remove the course by id.
     *
     * @param int $id
     * @return Course
     */
    public function delete(int $id): Course
    {
        $course = Course::findOrFail($id);

        $course->delete();

        $this->tempFileService->removeFileFromFolder(TempFile::FOLDER_COURSE_COVER, $course->cover);

        return $course;
    }
}