<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout progress request",
 *     @OA\Xml(
 *         name="WorkoutProgressRequest"
 *     )
 * )
 */
class WorkoutProgressRequest
{
    /**
     * @OA\Property(
     *     title="status"
     * )
     *
     * @var int
     */
    private $status;
}
