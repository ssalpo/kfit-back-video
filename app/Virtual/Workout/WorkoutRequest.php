<?php

namespace App\Virtual\Workout;

/**
 * @OA\Schema(
 *     title="Workout store/update request",
 *     @OA\Xml(
 *         name="WorkoutRequest"
 *     )
 * )
 */
class WorkoutRequest
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
