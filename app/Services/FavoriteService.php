<?php

namespace App\Services;

use App\Utils\User\ApiUser;

class FavoriteService
{
    /**
     * Store model to favorites
     *
     * @param int $modelId
     * @param string $modelType
     * @return mixed
     */
    public function store(int $modelId, string $modelType): mixed
    {
        if ($this->hasAny($modelId, $modelType)) {
            return null;
        }

        $modelClass = $this->model($modelType);

        $model = $modelClass::findOrFail($modelId);

        return $model->favorites()->create(['client_id' => app(ApiUser::class)->id]);
    }

    /**
     * Delete model form favorites
     *
     * @param int $modelId
     * @param string $modelType
     * @return void
     */
    public function delete(int $modelId, string $modelType): void
    {
        $modelClass = $this->model($modelType);

        $model = $modelClass::findOrFail($modelId);

        $model->favorites()
            ->where('client_id', app(ApiUser::class)->id)
            ->delete();
    }

    /**
     * Check model previously added to favorites
     *
     * @param int $modelId
     * @param string $modelType
     * @return mixed
     */
    public function hasAny(int $modelId, string $modelType): mixed
    {
        $modelClass = $this->model($modelType);

        $model = $modelClass::findOrFail($modelId);

        return $model->favorites()->where('client_id', app(ApiUser::class)->id)->exists();
    }

    /**
     * Get the model class
     *
     * @param string $type
     * @return string
     */
    private function model(string $type): string
    {
        return 'App\Models\\' . ucfirst($type);
    }
}
