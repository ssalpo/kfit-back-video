<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout video resource"
 * )
 */
class WorkoutVideoResource
{
    /**
     * @OA\Property(
     *     title="data"
     * )
     *
     * @var object
     */
    private $data;
}
