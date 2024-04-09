<?php

namespace App\Http\Traits;

trait CourseEnrollmentTrait
{

    // check if the cource if closed or not
    public function is_course_full($course): bool
    {
        return $course->max_students !== null && $course->users()->count() >= $course->max_students;
    }
}