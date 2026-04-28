<?php
// ── Region ────────────────────────────────────────────────────────────────
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Region extends Model {
    protected $primaryKey = 'region_id';
    public    $timestamps = false;
    protected $fillable   = ['region_code', 'region_name'];
    public function provinces() { return $this->hasMany(Province::class, 'region_id', 'region_id'); }
}
