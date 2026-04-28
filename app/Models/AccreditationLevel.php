<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccreditationLevel extends Model
{
    protected $primaryKey = 'accred_id';
    public    $timestamps = false;
    protected $fillable   = ['level_name', 'body', 'base_tuition', 'description'];
}
