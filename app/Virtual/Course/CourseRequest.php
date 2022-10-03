<?php

namespace App\Virtual\Course;

/**
 * @OA\Schema(
 *     title="Course request",
 *     @OA\Xml(
 *         name="CourseRequest"
 *     )
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
