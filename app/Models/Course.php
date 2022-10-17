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
        'active',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'active' => 'boolean'
    ];

    public function clientProgress()
    {
        return $this->morphOne(Progress::class, 'progressable')->whereClientId(app(ApiUser::class)->id);
    }
}
