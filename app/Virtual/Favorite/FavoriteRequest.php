<?php

namespace App\Virtual\Favorite;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Favorite request"
 * )
 */
class FavoriteRequest
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
}
