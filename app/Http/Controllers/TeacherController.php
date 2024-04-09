<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TeacherRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\TeacherResource;
use App\Http\Requests\UpdateTeacherRequest;

class TeacherController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teachers = Teacher::all();
            return $this->customeResponse(TeacherResource::collection($teachers),'Done',200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        try {
            $teacher = Teacher::create([
                'name'      =>$request->name,
                'specialty' =>$request->specialty,
            ]);
            return $this->customeResponse(new TeacherResource($teacher), 'teacher Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        try {
            return $this->customeResponse(new TeacherResource($teacher), 'Done', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        try {
            $teacher->name = $request->input('name') ?? $teacher->name;
            $teacher->specialty = $request->input('specialty') ?? $teacher->specialty;
            $teacher->save();
            return $this->customeResponse(new TeacherResource($teacher), 'teacher updated Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            return $this->customeResponse("", 'deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
