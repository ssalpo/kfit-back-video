<?php

namespace App\Virtual\Rating;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="rating request"
 * )
 */
class RatingRequest
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Model id",
     *     example="1"
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     title="type",
     *     description="Model type 'course, workout'",
     *     example="course"
     * )
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     title="rating",
     *     description="Numeric rating between 1-5",
     *     example="3"
     * )
     *
     * @var int
     */
    private $rating;
}
