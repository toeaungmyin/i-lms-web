<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_has_student_id',
        'started_at',
        'submitted_at',
        'status',
        'mark',
    ];

    public function course_has_student()
    {
        return $this->belongsTo(CourseHasStudent::class, 'course_has_student_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
