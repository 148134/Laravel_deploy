<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class UniversityScholarship extends Model
{
    protected $primaryKey = 'us_id';
    public    $timestamps = false;
    protected $fillable   = ['university_id', 'scholarship_id'];
}
