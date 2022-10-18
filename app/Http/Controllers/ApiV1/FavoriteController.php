<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequest;
use App\Models\Course;
use App\Services\FavoriteService;
use OpenApi\Annotations as OA;

class FavoriteController extends Controller
{
    private FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Add model to favorites
     *
     * @OA\Post(
     *     path="/favorites",
     *     tags={"Favorites"},
     *     summary="Add model to favorites",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/FavoriteRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param FavoriteRequest $request
     * @return void
     */
    public function store(FavoriteRequest $request): void
    {
        $this->favoriteService->store($request->id, $request->type);
    }

    /**
     * Destroy model from favorites
     *
     * @OA\Post(
     *     path="/favorites/delete",
     *     tags={"Favorites"},
     *     summary="Destroy model from favorites",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/FavoriteRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param FavoriteRequest $request
     * @return void
     */
    public function destroy(FavoriteRequest $request): void
    {
        $this->favoriteService->delete($request->id, $request->type);
    }
}
