<?php

namespace App\Virtual\Course;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Course all collection resource")
 */
class CourseAllCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/CourseResource")
     * )
     *
     * @var array
     */
    private $data;
}
