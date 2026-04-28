<?php

namespace App\Http\Controllers;

use App\Services\UniversityService;
use Illuminate\Http\Request;

class CourseFinderController extends Controller
{
    public function __construct(private UniversityService $svc) {}

    public function index(Request $request)
    {
        $filters = [
            'course' => $request->integer('course') ?: null,
            'region' => $request->integer('region') ?: null,
            'free'   => $request->boolean('free'),
            'board'  => $request->boolean('board'),
        ];

        $results      = $filters['course'] ? $this->svc->getCourseFinder($filters) : collect();
        $courses      = $this->svc->getCourses();
        $regions      = $this->svc->getRegions();

        return view('pages.courses', compact('results', 'courses', 'regions', 'filters'));
    }
}
