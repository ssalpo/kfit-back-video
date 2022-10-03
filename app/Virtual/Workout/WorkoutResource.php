<?php

namespace App\Virtual\Workout;

/**
 * @OA\Schema(
 *     title="Workout resource",
 *     @OA\Xml(
 *         name="WorkoutResource"
 *     )
 * )
 */
class WorkoutResource
{
    /**
     * @OA\Property(
     *     title="title"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @OA\Property(
     *     title="source_type"
     * )
     *
     * @var int
     */
    private $source_type;

    /**
     * @OA\Property(
     *     title="source_id"
     * )
     *
     * @var string
     */
    private $source_id;
}
