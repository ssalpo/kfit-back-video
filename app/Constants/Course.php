<?php

namespace App\Constants;

interface Course
{
    public const TYPE_COURSE = 1;
    public const TYPE_WORKOUT = 2;

    public const COURSE_TYPES = [
        self::TYPE_COURSE,
        self::TYPE_WORKOUT,
    ];

    public const LEVEL_BEGINNER = 1;
    public const LEVEL_MIDDLE = 2;
    public const LEVEL_ADVANCED = 3;

    public const LEVELS = [
        self::LEVEL_BEGINNER,
        self::LEVEL_MIDDLE,
        self::LEVEL_ADVANCED,
    ];
}
