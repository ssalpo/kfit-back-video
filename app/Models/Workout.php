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

    public function clientProgress()
    {
        return $this->morphOne(Progress::class, 'progressable')->whereClientId(app(ApiUser::class)->id);
    }
}
