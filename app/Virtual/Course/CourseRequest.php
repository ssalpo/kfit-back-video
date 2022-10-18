<?php

namespace App\Virtual\Course;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Course request"
 * )
 */
class CourseRequest
{
    /**
     * @OA\Property(
     *     title="name"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="cover"
     * )
     *
     * @var string
     */
    private $cover;

    /**
     * @OA\Property(
     *     title="duration"
     * )
     *
     * @var string
     */
    private $duration;

    /**
     * @OA\Property(
     *     title="level"
     * )
     *
     * @var int
     */
    private $level;

    /**
     * @OA\Property(
     *     title="muscles"
     * )
     *
     * @var int
     */
    private $muscles;

    /**
     * @OA\Property(
     *     title="type"
     * )
     *
     * @var int
     */
    private $type;
}
