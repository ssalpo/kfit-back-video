<?php

namespace App\Http\Controllers\ApiV1;

use App\Constants\GoodsType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Utils\User\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except('index', 'my', 'changeProgress');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/courses",
     *     tags={"Courses"},
     *     summary="Display a listing of the resource.",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CourseResource::collection(
            Course::paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/courses",
     *     tags={"Courses"},
     *     summary="Store a newly created resource in storage.",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CourseRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     )
     * )
     *
     * @param CourseRequest $request
     * @return CourseResource
     */
    public function store(CourseRequest $request): CourseResource
    {
        return new CourseResource(
            Course::create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/courses/{course}",
     *     tags={"Courses"},
     *     summary="Display the specified resource.",
     *     @OA\Parameter(
     *         in="path",
     *         name="course",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *      )
     * )
     *
     * @param Course $course
     * @return CourseResource
     */
    public function show(Course $course): CourseResource
    {
        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/courses/{course}",
     *     tags={"Workouts"},
     *     summary="Update the specified resource in storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="course",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CourseRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=202,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     )
     * )
     *
     * @param CourseRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function update(CourseRequest $request, Course $course): CourseResource
    {
        $course->update($request->validated());

        return new CourseResource(
            $course->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/courses/{course}",
     *     tags={"Workouts"},
     *     summary="Remove the specified resource from storage.",
     *     @OA\Parameter(
     *         in="path",
     *         name="course",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     )
     * )
     *
     * @param Course $course
     * @return CourseResource
     */
    public function destroy(Course $course): CourseResource
    {
        $course->delete();

        return new CourseResource(
            $course->refresh()
        );
    }

    /**
     * Display a list of related courses for current user
     *
     * @OA\Get(
     *     path="/courses/my",
     *     tags={"Courses"},
     *     summary="Display a list of related courses for current user",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function my(): AnonymousResourceCollection
    {
        return CourseResource::collection(
            Course::whereIn('id', $this->getRelatedCourseIds())
                ->with('clientProgress')
                ->orWhere('is_public', true)
                ->paginate()
        );
    }

    /**
     * Change course progress for current user
     *
     * @OA\Put(
     *     path="/courses/{course}/change-progress",
     *     tags={"Workouts"},
     *     summary="Change course progress for current user",
     *     @OA\Parameter(
     *         in="path",
     *         name="course",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CourseProgressRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=202,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     )
     * )
     *
     * @param Request $request
     * @param Course $course
     * @return CourseResource
     */
    public function changeProgress(Request $request, Course $course): CourseResource
    {
        $ids = $this->getRelatedCourseIds();

        if (!in_array($course->id, $ids) && !$course->is_public) {
            abort(404, 'Связанных курсов не найдено.');
        }

        $course->clientProgress()->updateOrCreate(
            ['client_id' => app(ApiUser::class)->id],
            ['status' => (int)$request->status]
        );

        return new CourseResource($course->refresh());
    }

    /**
     * Get list of related courses from network
     *
     * @return array
     */
    private function getRelatedCourseIds(): array
    {
        $relatedCourses = Http::withAuth()->get('/api/v1/users/goods/' . GoodsType::COURSE);

        return array_column($relatedCourses->json(), 'related_id');
    }
}
