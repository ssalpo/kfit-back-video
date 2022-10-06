<?php

namespace App\Virtual\Course;

/**
 * @OA\Schema(
 *     title="Course resource",
 *     @OA\Xml(
 *         name="CourseResource"
 *     )
 * )
 */
class CourseResource
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
