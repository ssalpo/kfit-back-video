<?php

namespace App\Services\External\VideoHosting;

use App\Models\Workout;
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

    /**
     * @inheritDoc
     */
    public function list(): array
    {
        return $this->client()->get(
            '/videos', ['per_page' => 100, 'project_id' => $this->projectId]
        )->json('data', []);
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): array
    {
        return $this->client()->get('/videos/' . $id)->json('data', []);
    }


    /**
     * @inheritDoc
     */
    public function upload(Workout $workout, string $filename, string $link): array
    {
        return $this->client()
            ->baseUrl(config('services.kinescope.uploader_url'))
            ->withHeaders([
                'X-Project-ID' => $workout->source_id,
                'X-Video-Title' => $workout->title,
                'X-File-Name' => $filename,
                'X-Video-URL' => $link,
            ])
            ->post('/video')
            ->json('data', []);
    }
}
