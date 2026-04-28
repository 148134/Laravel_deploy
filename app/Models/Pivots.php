<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityCourse extends Model
{
    protected $primaryKey = 'uc_id';
    public    $timestamps = false;
    protected $fillable   = [
        'university_id', 'course_id',
        'tuition_fee_per_semester', 'misc_fees',
        'slots_per_year', 'is_available', 'notes',
    ];

    protected $casts = [
        'is_available'             => 'boolean',
        'tuition_fee_per_semester' => 'integer',
        'misc_fees'                => 'integer',
        'slots_per_year'           => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id', 'university_id');
    }
}

class UniversityScholarship extends Model
{
    protected $primaryKey = 'us_id';
    public    $timestamps = false;
    protected $fillable   = ['university_id', 'scholarship_id'];
}

class Review extends Model
{
    protected $primaryKey = 'review_id';
    public    $timestamps = false;
    protected $fillable   = ['university_id', 'rating', 'comment', 'reviewer_name'];
}
