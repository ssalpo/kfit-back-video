<?php

namespace App\ApiRequests;

use App\Constants\GoodsType;
use Illuminate\Support\Facades\Http;

class User
{
    /**
     * Get list of related courses from network
     *
     * @return array
     */
    public static function getRelatedCourseIds(): array
    {
        $relatedCourses = Http::withAuth()->get('/api/v1/users/goods/' . GoodsType::COURSE);

        return array_column($relatedCourses->json(), 'related_id');
    }
}
