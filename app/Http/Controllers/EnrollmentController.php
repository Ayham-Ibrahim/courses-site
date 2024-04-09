<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CourseResource;
use App\Http\Traits\CourseEnrollmentTrait;

class EnrollmentController extends Controller
{
    use ApiResponseTrait,CourseEnrollmentTrait;

    public function enroll(Request $request, Course $course)
    {
        
        try {
            $user = Auth::user();
            if ($this->is_course_full($course)) {
                return response()->json(['message' => 'Course is full'], 400);
            }
            $user->courses()->attach($course);
            return response()->json(['message' => 'Enrolled successfully'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    public function showUserCourses(){
        try {
            $user = auth()->user();
            $courses = $user->courses()->get();
            return $this->customeResponse(CourseResource::collection($courses),'Done',200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

}
