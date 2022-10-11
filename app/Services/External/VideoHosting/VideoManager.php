<?php

namespace App\Services\External\VideoHosting;

use App\Constants\Workout;

class VideoManager
{
    public static function make(int $source, string $projectId): Video
    {
        $service = ucfirst(Workout::SOURCE_KEYS[$source]);
        $service = "App\Services\External\VideoHosting\\{$service}";

        return new $service($projectId);
    }
}
