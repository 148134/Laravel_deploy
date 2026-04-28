<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $primaryKey = 'scholarship_id';
    public    $timestamps = false;

    protected $fillable = [
        'scholarship_name', 'provider', 'scholarship_type',
        'coverage', 'eligibility', 'website', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function universityScholarships()
    {
        return $this->hasMany(UniversityScholarship::class, 'scholarship_id', 'scholarship_id');
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'university_scholarships', 'scholarship_id', 'university_id');
    }
}
