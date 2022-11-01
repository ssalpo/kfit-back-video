<?php

namespace App\Http\Controllers\ApiV1;

use App\Constants\GoodsType;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkoutActivityRequest;
use App\Http\Requests\WorkoutRequest;
use App\Http\Requests\WorkoutVideoUploadRequest;
use App\Http\Resources\WorkoutResource;
use App\Models\Workout;
use App\Services\External\VideoHosting\VideoManager;
use App\Utils\User\ApiUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;
use OpenApi\Annotations as OA;

class WorkoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except('index', 'my', 'changeProgress');
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
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return WorkoutResource::collection(
            Workout::with('recommendations', 'course')->paginate()
        );
    }

    /**
     * Display a listing of the all resource.
     *
     * @OA\Get(
     *     path="/workouts/all",
     *     tags={"Workouts"},
     *     summary="Display a listing of the all resource.",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        return WorkoutResource::collection(Workout::all());
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
        $workout = Workout::create($request->validated());

        if($request->has('recommendations')) {
            $workout->recommendations()->sync($request->recommendations);
        }

        $workout->load('recommendations');

        return new WorkoutResource($workout->refresh());
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
        $workout->load('recommendations', 'course');

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
        $workout->load('recommendations', 'course');

        $workout->update($request->validated());

        if($request->has('recommendations')) {
            $workout->recommendations()->sync($request->recommendations);
        }

        return new WorkoutResource($workout->refresh());
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
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function my(): AnonymousResourceCollection
    {
        return WorkoutResource::collection(
            Workout::whereIn('id', $this->getRelatedWorkoutIds())
                ->with('recommendations', 'course')
                ->filter()
                ->paginate()
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

        return new WorkoutResource($workout->load('recommendations', 'course')->refresh());
    }

    /**
     * Change workout activity status
     *
     * @OA\Put(
     *     path="/workouts/{workout}/change-activity",
     *     tags={"Workouts"},
     *     summary="Change workout activity status",
     *     @OA\Parameter(
     *         in="path",
     *         name="workout",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/WorkoutActivityRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutResource")
     *     )
     * )
     *
     * @param WorkoutActivityRequest $request
     * @param Workout $workout
     * @return WorkoutResource
     */
    public function changeActivity(WorkoutActivityRequest $request, Workout $workout): WorkoutResource
    {
        $workout->update(['active' => $request->status]);

        return new WorkoutResource(
            $workout->refresh()
        );
    }

    /**
     * Find the list of videos from external services
     *
     * @OA\Get(
     *     path="/workouts/{workout}/videos",
     *     tags={"Workouts"},
     *     summary="Find the list of videos from external services",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutVideoResource")
     *      )
     * )
     *
     * @param Workout $workout
     * @return JsonResponse
     */
    public function getExternalVideos(Workout $workout): JsonResponse
    {
        $service = VideoManager::make($workout->source_type, $workout->source_id);

        return response()->json([
            'data' => $service->list()
        ]);
    }

    /**
     * Find external video by id
     *
     * @OA\Get(
     *     path="/workouts/{workout}/videos/{video}",
     *     tags={"Workouts"},
     *     summary="Find external video by id",
     *     @OA\Parameter(
     *         in="path",
     *         name="video",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/WorkoutVideoResource")
     *      )
     * )
     *
     * @param Workout $workout
     * @param string $videoId
     * @return JsonResponse
     */
    public function getVideoById(Workout $workout, string $videoId): JsonResponse
    {
        $service = VideoManager::make($workout->source_type, $workout->source_id);

        return response()->json([
            'data' => $service->findById($videoId)
        ]);
    }

    /**
     * Upload external video
     *
     * @OA\Post(
     *     path="/workouts/{workout}/videos/upload",
     *     tags={"Workouts"},
     *     summary="Upload external video",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/WorkoutVideoUploadRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/WorkoutVideoResource")
     *     )
     * )
     *
     * @param Workout $workout
     * @param WorkoutVideoUploadRequest $request
     * @return JsonResponse
     */
    public function uploadVideoById(Workout $workout, WorkoutVideoUploadRequest $request): JsonResponse
    {
        $service = VideoManager::make($workout->source_type, $workout->source_id);

        return response()->json([
            'data' => $service->upload($workout, $request->filename, $request->link)
        ]);
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
