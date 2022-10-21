<?php

namespace App\Http\Controllers\ApiV1;

use App\ApiRequests\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseActivityRequest;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Services\CourseService;
use App\Utils\User\ApiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->middleware('role:admin')->except('index', 'my', 'changeProgress');

        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/courses",
     *     tags={"Courses"},
     *     summary="Display a listing of the resource.",
     *     @OA\Parameter(
     *         in="path",
     *         name="direction",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="duration",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="duration",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="active_area",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="inventory",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="pulse_zone",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CourseResource::collection(
            Course::with('recommendations')->filter()->paginate()
        );
    }

    /**
     * Display a listing of the all resource.
     *
     * @OA\Get(
     *     path="/courses/all",
     *     tags={"Courses"},
     *     summary="Display a listing of the all resource.",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function all(): AnonymousResourceCollection
    {
        return CourseResource::collection(Course::all());
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
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param CourseRequest $request
     * @return CourseResource
     */
    public function store(CourseRequest $request): CourseResource
    {
        return new CourseResource(
            $this->courseService->create($request->validated())
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
        $course->load('recommendations');

        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/courses/{course}",
     *     tags={"Courses"},
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
     * @param int $course
     * @return CourseResource
     */
    public function update(CourseRequest $request, int $course): CourseResource
    {
        return new CourseResource(
            $this->courseService->update($course, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/courses/{course}",
     *     tags={"Courses"},
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
     * @param int $course
     * @return CourseResource
     */
    public function destroy(int $course): CourseResource
    {
        return new CourseResource(
            $this->courseService->delete($course)
        );
    }

    /**
     * Display a list of related courses for current user
     *
     * @OA\Get(
     *     path="/courses/my",
     *     tags={"Courses"},
     *     summary="Display a list of related courses for current user",
     *     @OA\Parameter(
     *         in="path",
     *         name="direction",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="duration",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="duration",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="active_area",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="inventory",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="path",
     *         name="pulse_zone",
     *         description="Filter param",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/CourseCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function my(): AnonymousResourceCollection
    {
        return CourseResource::collection(
            Course::whereIn('id', User::getRelatedCourseIds())
                ->with('clientProgress')
                ->with('recommendations')
                ->orWhere('is_public', true)
                ->filter()
                ->paginate()
        );
    }

    /**
     * Change course progress for current user
     *
     * @OA\Put(
     *     path="/courses/{course}/change-progress",
     *     tags={"Courses"},
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
     *         response=200,
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
        $ids = User::getRelatedCourseIds();

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
     * Change course activity status
     *
     * @OA\Put(
     *     path="/courses/{course}/change-activity",
     *     tags={"Courses"},
     *     summary="Change course activity status",
     *     @OA\Parameter(
     *         in="path",
     *         name="course",
     *         required=true,
     *         @OA\Schema(type="int"),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CourseActivityRequest")
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/CourseResource")
     *     )
     * )
     *
     * @param CourseActivityRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function changeActivity(CourseActivityRequest $request, Course $course): CourseResource
    {
        $course->update(['active' => $request->status]);

        return new CourseResource(
            $course->refresh()
        );
    }
}
