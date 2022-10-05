<?php

namespace App\Http\Controllers\ApiV1;

use App\Constants\GoodsType;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutRequest;
use App\Http\Resources\WorkoutResource;
use App\Models\Workout;
use App\Utils\User\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/workouts",
     *     tags={"Workouts"},
     *     summary="Display a listing of the resource.",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return WorkoutResource::collection(Workout::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/workouts",
     *     tags={"Workouts"},
     *     summary="Store a newly created resource in storage.",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/WorkoutRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *     )
     * )
     *
     * @param WorkoutRequest $request
     * @return WorkoutResource
     */
    public function store(WorkoutRequest $request): WorkoutResource
    {
        return new WorkoutResource(
            Workout::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/workouts/{workout}",
     *     tags={"Workouts"},
     *     summary="Display the specified resource.",
     *     @OA\Parameter(
     *         in="path",
     *         name="workout",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *      )
     * )
     *
     * @param Workout $workout
     * @return WorkoutResource
     */
    public function show(Workout $workout): WorkoutResource
    {
        return new WorkoutResource($workout);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/workouts/{workout}",
     *     tags={"Workouts"},
     *     summary="Update the specified resource in storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="workout",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/WorkoutRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=202,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *     )
     * )
     *
     * @param WorkoutRequest $request
     * @param Workout $workout
     * @return WorkoutResource
     */
    public function update(WorkoutRequest $request, Workout $workout): WorkoutResource
    {
        return new WorkoutResource($workout);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/workouts/{workout}",
     *     tags={"Workouts"},
     *     summary="Remove the specified resource from storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *     )
     * )
     *
     * @param Workout $workout
     * @return WorkoutResource
     */
    public function destroy(Workout $workout): WorkoutResource
    {
        $workout->delete();

        return new WorkoutResource($workout);
    }


    /**
     * Display a list of related workouts for current user
     *
     * @OA\Get(
     *     path="/workouts/my",
     *     tags={"Workouts"},
     *     summary="Display a list of related workouts for current user",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function my(): AnonymousResourceCollection
    {
        return WorkoutResource::collection(
            Workout::whereIn('id', $this->getRelatedWorkoutIds())->paginate()
        );
    }

    /**
     * Change course progress for current user
     *
     * @OA\Put(
     *     path="/workouts/{workout}/change-progress",
     *     tags={"Workouts"},
     *     summary="Change workout progress for current user",
     *     @OA\Parameter(
     *         in="path",
     *         name="workout",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/WorkoutProgressRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=202,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *     )
     * )
     *
     * @param Request $request
     * @param Workout $workout
     * @return WorkoutResource
     */
    public function changeProgress(Request $request, Workout $workout): WorkoutResource
    {
        $ids = $this->getRelatedWorkoutIds();

        if (!in_array($workout->id, $ids) && !$workout->is_public) {
            abort(404, 'Связанных тренировок не найдено.');
        }

        $workout->clientProgress()->updateOrCreate(
            ['client_id' => app(ApiUser::class)->id],
            ['status' => (int)$request->status]
        );

        return new WorkoutResource($workout->refresh());
    }

    /**
     * Get list of related courses from network
     *
     * @return array
     */
    private function getRelatedWorkoutIds(): array
    {
        $relatedWorkouts = Http::withAuth()->get('/api/v1/users/goods/' . GoodsType::WORKOUT);

        return array_column($relatedWorkouts->json(), 'related_id');
    }
}
