<?php

namespace App\Services;

use App\Jobs\RecalculateModelTypeRating;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class RatingService
{
    /**
     * Store model to ratings
     *
     * @param int $clientId
     * @param int $modelId
     * @param string $modelType
     * @param int $rating
     * @return mixed
     */
    public function store(int $clientId, int $modelId, string $modelType, int $rating): mixed
    {
        if ($this->hasAny($clientId, $modelId, $modelType)) {
            return null;
        }

        $modelClass = $this->modelByType($modelType);

        $model = $modelClass::findOrFail($modelId);

        $rating =  $model->ratings()->create([
            'client_id' => $clientId,
            'rating' => $rating
        ]);

        RecalculateModelTypeRating::dispatch($modelId, $modelType);

        return $rating;
    }

    /**
     * Check model previously added to ratings
     *
     * @param int $clientId
     * @param int $modelId
     * @param string $modelType
     * @return mixed
     */
    public function hasAny(int $clientId, int $modelId, string $modelType): mixed
    {
        $modelClass = $this->modelByType($modelType);

        $model = $modelClass::findOrFail($modelId);

        return $model->ratings()->where('client_id', $clientId)->exists();
    }

    public function recalculateModelRatings(int $modelId, string $modelType): void
    {
        $ratings = Rating::select('ratingable_id', DB::raw('CAST(AVG(rating) AS DECIMAL(5, 2)) as rating'))
            ->where('ratingable_type', $modelType)
            ->where('ratingable_id', $modelId)
            ->groupBy('ratingable_id')
            ->get()
            ->pluck('rating', 'ratingable_id');

        $modelClass = $this->modelByType($modelType);

        $modelItems = $modelClass::whereIn('id', $ratings->keys())->get();

        $modelItems->each(fn($modelItem) => $modelItem->update(['rating' => $ratings[$modelItem->id]]));
    }

    /**
     * Get the model class
     *
     * @param string $type
     * @return string
     */
    public function modelByType(string $type): string
    {
        return 'App\Models\\' . ucfirst($type);
    }
}
