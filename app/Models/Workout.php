<?php

namespace App\Models;

use App\Utils\User\ApiUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'source_type',
        'source_id',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean'
    ];

    public function clientProgress()
    {
        return $this->morphOne(Progress::class, 'progressable')->whereClientId(app(ApiUser::class)->id);
    }

    public function recommendations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'recommended_workouts', 'workout_id', 'recommended_id');
    }
}
