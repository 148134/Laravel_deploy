<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class University extends Model
{
    protected $primaryKey = 'university_id';
    public    $timestamps = false;

    protected $fillable = [
        'university_name', 'abbreviation', 'type_id', 'province_id',
        'city', 'year_established', 'website', 'email', 'phone',
        'accred_id', 'is_active', 'description',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'year_established' => 'integer',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(UniversityType::class, 'type_id', 'type_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function accreditation(): BelongsTo
    {
        return $this->belongsTo(AccreditationLevel::class, 'accred_id', 'accred_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'university_courses', 'university_id', 'course_id')
                    ->withPivot(['uc_id', 'tuition_sem', 'slots_per_year']);
    }

    public function universityCourses(): HasMany
    {
        return $this->hasMany(UniversityCourse::class, 'university_id', 'university_id');
    }

    public function scholarships(): BelongsToMany
    {
        return $this->belongsToMany(Scholarship::class, 'university_scholarships', 'university_id', 'scholarship_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'university_id', 'university_id');
    }
}
