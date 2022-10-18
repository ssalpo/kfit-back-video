<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Services\RatingService;
use App\Utils\User\ApiUser;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RatingController extends Controller
{
    /**
     * Store rating for model
     *
     * @OA\Post(
     *     path="/ratings",
     *     tags={"Ratings"},
     *     summary="Add model to ratings",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/RatingRequest")
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
     * @param RatingRequest $request
     * @param RatingService $ratingService
     * @return void
     */
    public function store(RatingRequest $request, RatingService $ratingService): void
    {
        $ratingService->store(
            app(ApiUser::class)->id,
            $request->id,
            $request->type,
            $request->rating,
        );
    }
}
