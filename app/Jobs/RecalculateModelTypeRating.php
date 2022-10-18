<?php

namespace App\Jobs;

use App\Models\Rating;
use App\Services\RatingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RecalculateModelTypeRating implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $modelId;
    private string $modelType;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $modelId, string $modelType)
    {
        $this->modelId = $modelId;
        $this->modelType = $modelType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(RatingService $ratingService)
    {
        $ratingService->recalculateModelRatings(
            $this->modelId,
            $this->modelType,
        );
    }
}
