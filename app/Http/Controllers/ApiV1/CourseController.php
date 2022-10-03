<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except('index');
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
}
