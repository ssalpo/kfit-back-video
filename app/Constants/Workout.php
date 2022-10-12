<?php

namespace App\Constants;

interface Workout
{
    const SOURCE_KINESKOP = 1;

    const SOURCE_LIST = [
        self::SOURCE_KINESKOP
    ];

    const SOURCE_KEYS = [
        self::SOURCE_KINESKOP => 'kinescope'
    ];
}
