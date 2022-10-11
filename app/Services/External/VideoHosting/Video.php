<?php

namespace App\Services\External\VideoHosting;

use Illuminate\Http\Client\PendingRequest;

interface Video
{
    public function client(): PendingRequest;

    /**
     * List of videos
     *
     * @return mixed
     */
    public function list();

    /**
     * Find by Id
     * @param string $id
     * @return mixed
     */
    public function findById(string $id);
}
