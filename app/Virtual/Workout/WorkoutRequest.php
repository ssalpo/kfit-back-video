<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout store/update request"
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
     *     title="source_type",
     *     description="Source type for external services. Available source [kinescope=1]",
     *     nullable=true
     * )
     *
     * @var int
     */
    private $source_type;

    /**
     * @OA\Property(
     *     title="source_id",
     *     description="Source id need for external services",
     *     nullable=true
     * )
     *
     * @var string
     */
    private $source_id;
}
