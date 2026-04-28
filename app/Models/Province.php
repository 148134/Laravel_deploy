<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $primaryKey = 'province_id';
    public    $timestamps = false;
    protected $fillable   = ['province_name', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }

    public function universities()
    {
        return $this->hasMany(University::class, 'province_id', 'province_id');
    }
}
