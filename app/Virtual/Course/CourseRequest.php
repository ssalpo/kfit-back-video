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
     * @var string
     */
    private $level;

    /**
     * @OA\Property(
     *     title="muscles"
     * )
     *
     * @var string
     */
    private $muscles;

    /**
     * @OA\Property(
     *     title="type"
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     title="is_public"
     * )
     *
     * @var bool
     */
    private $is_public;

    /**
     * @OA\Property(
     *     title="course_type"
     * )
     *
     * @var int
     */
    private $course_type;

    /**
     * @OA\Property(
     *     title="trainer_id"
     * )
     *
     * @var int
     */
    private $trainer_id;

    /**
     * @OA\Property(
     *     title="direction"
     * )
     *
     * @var string
     */
    private $direction;

    /**
     * @OA\Property(
     *     title="active_area"
     * )
     *
     * @var string
     */
    private $active_area;

    /**
     * @OA\Property(
     *     title="inventory"
     * )
     *
     * @var string
     */
    private $inventory;

    /**
     * @OA\Property(
     *     title="pulse_zone"
     * )
     *
     * @var string
     */
    private $pulse_zone;
}
