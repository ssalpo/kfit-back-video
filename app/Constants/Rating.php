<?php

namespace App\Constants;

interface Rating
{
    public const TYPE_COURSE = 'course';
    public const TYPE_WORKOUT = 'workout';

    public const TYPES = [
        self::TYPE_COURSE,
        self::TYPE_WORKOUT,
    ];
}
