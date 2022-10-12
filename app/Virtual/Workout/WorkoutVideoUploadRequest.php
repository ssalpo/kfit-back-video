<?php

namespace App\Virtual\Workout;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Workout video upload request",
 * )
 */
class WorkoutVideoUploadRequest
{
    /**
     * @OA\Property(
     *     title="filename",
     *     example="Video.mp4"
     * )
     *
     * @var string
     */
    private $filename;

    /**
     * @OA\Property(
     *     title="link"
     * )
     *
     * @var string
     */
    private $link;
}
