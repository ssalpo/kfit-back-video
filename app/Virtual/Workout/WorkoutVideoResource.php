<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout video resource",
 *     @OA\Xml(
 *         name="WorkoutVideoResource"
 *     )
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
