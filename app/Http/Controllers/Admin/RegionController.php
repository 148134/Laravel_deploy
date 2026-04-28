<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Province;

class RegionController extends Controller
{
    public function index()
    {
        $regions   = Region::orderBy('region_id')->get();
        $provinces = Province::orderBy('province_name')->get()->groupBy('region_id');
        return view('admin.regions.index', compact('regions', 'provinces'));
    }
}
