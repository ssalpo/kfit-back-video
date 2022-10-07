<?php

namespace App\Constants;

interface Course
{
    const LEVEL_BEGINNER = 1;
    const LEVEL_MIDDLE = 2;
    const LEVEL_ADVANCED = 3;

    const LEVELS = [
        self::LEVEL_BEGINNER,
        self::LEVEL_MIDDLE,
        self::LEVEL_ADVANCED,
    ];
}
