<?php

namespace App\Models;

use App\Models\User;
use App\Models\Teacher;
use App\Models\CourseUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'level',
        'teacher_id',
        'max_students',
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
