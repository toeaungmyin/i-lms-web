<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'course_id',
        'file',
        'due_date',
    ];

    public function studentHasAssignment()
    {
        return $this->hasOne(StudentHasAssignment::class);
    }
}
