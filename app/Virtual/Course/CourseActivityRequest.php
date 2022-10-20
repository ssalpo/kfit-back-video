<?php

namespace App\Virtual\Course;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Course activity request"
 * )
 */
class CourseActivityRequest
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
