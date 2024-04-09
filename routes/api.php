<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes accessible only to users
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    // User-specific routes
    Route::post('/enroll/{course}', [EnrollmentController::class,'enroll']);
    Route::get('/user-courses', [EnrollmentController::class,'showUserCourses']);

});

// Routes accessible only to admins
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Admin-specific routes

    // teachers routes
        Route::get('teachers', [TeacherController::class, 'index']);
        Route::get('teacher/{teacher}', [TeacherController::class, 'show']);
        Route::post('add-teacher', [TeacherController::class, 'store']);
        Route::post('update-teacher/{teacher}', [TeacherController::class, 'update']);
        Route::delete('delete-teacher/{teacher}', [TeacherController::class, 'destroy']);
    //the end of teachers routes

    // courses routes
        Route::post('add-course', [CourseController::class, 'store']);
        Route::put('update-course/{course}', [CourseController::class, 'update']);
        Route::delete('delete-course/{course}', [CourseController::class, 'destroy']);
    //the end of courses routes
});

// Routes accessible for admins and users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('course/{course}', [CourseController::class, 'show']);
});












