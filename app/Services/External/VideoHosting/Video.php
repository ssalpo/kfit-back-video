<?php

namespace App\Services\External\VideoHosting;

use App\Models\Workout;
use Illuminate\Http\Client\PendingRequest;

interface Video
{
    public function client(): PendingRequest;

    /**
     * List of videos
     *
     * @return mixed
     */
    public function list(): array;

    /**
     * Find by id
     *
     * @param string $id
     * @return mixed
     */
    public function findById(string $id): array;

    /**
     * Upload video
     *
     * @param Workout $workout
     * @param string $filename
     * @param string $link
     * @return array
     */
    public function upload(Workout $workout, string $filename, string $link): array;
}
