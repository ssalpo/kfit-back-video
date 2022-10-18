<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout activity request"
 * )
 */
class WorkoutActivityRequest
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
