<?php

namespace App\Virtual\Course;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Course resource"
 * )
 */
class CourseResource
{
    /**
     * @OA\Property(
     *     title="id"
     * )
     *
     * @var int
     */
    private $id;

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
     *     title="cover",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $cover;

    /**
     * @OA\Property(
     *     title="duration",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $duration;

    /**
     * @OA\Property(
     *     title="level",
     *     default="1",
     *     description="Available labels [Beginner=1, Middle=2, Advanced=3]",
     *     example="2"
     * )
     *
     * @var string
     */
    private $level;

    /**
     * @OA\Property(
     *     title="muscles",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $muscles;

    /**
     * @OA\Property(
     *     title="type",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     title="recommendations",
     *     @OA\Items(ref="#/components/schemas/CourseRecommendationsResource")
     * )
     *
     * @var array
     */
    private $recommendations;

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
     *     title="course_type",
     *     description="Course type, available types [Course=1, Workout=2]",
     *     default="1",
     *     example="2"
     * )
     *
     * @var int
     */
    private $course_type;

    /**
     * @OA\Property(
     *     title="trainer_id",
     *     nullable=true
     * )
     *
     * @var int
     */
    private $trainer_id;

    /**
     * @OA\Property(
     *     title="direction",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $direction;

    /**
     * @OA\Property(
     *     title="active_area",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $active_area;

    /**
     * @OA\Property(
     *     title="inventory",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $inventory;

    /**
     * @OA\Property(
     *     title="pulse_zone",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $pulse_zone;
}
