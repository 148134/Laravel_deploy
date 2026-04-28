<?php

namespace App\Http\Controllers;

use App\Services\UniversityService;

class RegionController extends Controller
{
    public function __construct(private UniversityService $svc) {}

    public function index()
    {
        $regionStats = $this->svc->getRegionStats();
        $regions     = $this->svc->getRegions();
        return view('pages.regions', compact('regionStats', 'regions'));
    }
}
