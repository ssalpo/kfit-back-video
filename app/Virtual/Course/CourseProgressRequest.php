<?php

namespace App\Virtual\Course;

/**
 * @OA\Schema(
 *     title="Course progress request",
 *     @OA\Xml(
 *         name="CourseProgressRequest"
 *     )
 * )
 */
class CourseProgressRequest
{
    /**
     * @OA\Property(
     *     title="status"
     * )
     *
     * @var int
     */
    private $status;
}
