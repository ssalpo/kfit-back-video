<?php

namespace App\Services\External\VideoHosting;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Kinescope implements Video
{
    private string $projectId;

    public function __construct(string $projectId)
    {
        $this->projectId = $projectId;
    }

    public function client(): PendingRequest
    {
        return Http::withToken(config('services.kinescope.token'))
            ->baseUrl(config('services.kinescope.url'));
    }

    public function list()
    {
        $data = $this->client()->get(
            '/videos', ['per_page' => 100, 'project_id' => $this->projectId]
        )->json('data', []);

        return array_map(
            fn($item) => [
                'id' => $item['id'],
                'link' => $item['play_link']
            ],
            $data
        );
    }

    public function findById(string $id)
    {
        $data = $this->client()->get('/videos/' . $id)->json('data');

        return [
            'id' => $data['id'],
            'link' => $data['play_link']
        ];
    }
}
