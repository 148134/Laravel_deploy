<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'course_id';
    public    $timestamps = false;

    protected $fillable = ['course_code', 'course_name', 'degree_type', 'years', 'board_exam'];

    protected $casts = ['board_exam' => 'boolean'];

    public function universityCourses()
    {
        return $this->hasMany(UniversityCourse::class, 'course_id', 'course_id');
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'university_courses', 'course_id', 'university_id');
    }
}
