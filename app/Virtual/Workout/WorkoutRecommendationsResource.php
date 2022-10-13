<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout recommendations resource"
 * )
 */
class WorkoutRecommendationsResource
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
