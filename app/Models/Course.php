<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cover',
        'title',
        'description',
        'category_id',
        'instructor_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function instructor(){
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
