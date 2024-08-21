<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'quizzes';
    protected $fillable = [
        'course_id',
        'question',
        'answer'
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }


}
