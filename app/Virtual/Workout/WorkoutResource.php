<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout resource"
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

    /**
     * @OA\Property(
     *     title="recommendations",
     *     @OA\Items(ref="#/components/schemas/WorkoutRecommendationsResource")
     * )
     *
     * @var array
     */
    private $recommendations;
}
