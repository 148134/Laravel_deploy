<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Course;
use App\Models\Scholarship;
use App\Models\Region;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_unis'    => University::count(),
            'active_unis'   => University::where('is_active', 1)->count(),
            'inactive_unis' => University::where('is_active', 0)->count(),
            'total_courses' => Course::count(),
            'total_schols'  => Scholarship::count(),
            'total_regions' => Region::count(),
        ];

        $recentUnis = University::select('university_name', 'city', 'year_established')
                                ->latest('university_id')
                                ->limit(5)
                                ->get();

        return view('admin.dashboard.index', compact('stats', 'recentUnis'));
    }
}
