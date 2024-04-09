<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CourseRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CourseResource;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courses = Course::all();
            return $this->customeResponse(CourseResource::collection($courses),'Done',200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        // try {
            $course = Course::create([
                'name' =>$request->name,
                'level' =>$request->level,
                'teacher_id' =>$request->teacher_id,
                'max_students' =>$request->max_students,
            ]);
            
            return $this->customeResponse(new CourseResource($course), 'course Created Successfuly', 200);
        // } catch (\Throwable $th) {
        //     Log::error($th);
        //     return $this->customeResponse(null,"Error, There somthing Rong here",500);
        // }
    }

    /** 
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        try {
            return $this->customeResponse(new CourseResource($course), 'Done', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        // try {
            $course->name = $request->input('name') ?? $course->name;
            $course->level = $request->input('level') ?? $course->level;
            $course->teacher_id = $request->input('teacher_id') ?? $course->teacher_id;
            $course->max_students = $request->input('max_students') ?? $course->max_students;
            $course->save();
            return $this->customeResponse(new CourseResource($course), 'course updated Successfuly', 200);
        // } catch (\Throwable $th) {
        //     Log::error($th);
        //     return $this->customeResponse(null,"Error, There somthing Rong here",500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return $this->customeResponse("", 'course deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
