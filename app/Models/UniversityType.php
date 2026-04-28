<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityType extends Model
{
    protected $primaryKey = 'type_id';
    public    $timestamps = false;
    protected $fillable   = ['type_name', 'type_code'];
}
