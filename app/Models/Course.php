<?php

namespace App\Models;

use App\Utils\User\ApiUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cover',
        'duration',
        'level',
        'muscles',
        'type',
        'description',
        'is_public',
        'rating',
        'active',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'active' => 'boolean'
    ];

    public function scopeClientFavorites($q): void
    {
        $q->whereHas('favorites', fn($q) => $q->where('client_id', app(ApiUser::class)->id));
    }

    public function scopeFilter($q)
    {
        $q->when(request('favorite'), fn($q) => $q->clientFavorites());
    }

    public function clientProgress()
    {
        return $this->morphOne(Progress::class, 'progressable')->whereClientId(app(ApiUser::class)->id);
    }

    public function recommendations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'recommended_courses', 'course_id', 'recommended_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }
}
