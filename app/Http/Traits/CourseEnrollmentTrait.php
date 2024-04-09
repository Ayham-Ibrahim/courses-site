<?php

namespace App\Http\Traits;

trait CourseEnrollmentTrait
{
    public function is_course_full($course): bool
    {
        return $course->max_students !== null && $course->users()->count() >= $course->max_students;
    }
}