<?php

namespace App\Http\Controllers;

use App\Services\UniversityService;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function __construct(private UniversityService $svc) {}

    public function index(Request $request)
    {
        $filters = [
            'q'        => trim($request->q ?? ''),
            'region'   => $request->integer('region') ?: null,
            'province' => $request->integer('province') ?: null,
            'type'     => $request->integer('type') ?: null,
            'course'   => $request->integer('course') ?: null,
            'free'     => $request->boolean('free'),
            'accred'   => $request->integer('accred') ?: null,
        ];

        $universities = $this->svc->searchUniversities($filters);
        $regions      = $this->svc->getRegions();
        $univTypes    = $this->svc->getUniversityTypes();
        $courses      = $this->svc->getCourses();
        $accredLevels = $this->svc->getAccredLevels();

        return view('pages.universities', compact(
            'universities', 'regions', 'univTypes', 'courses', 'accredLevels', 'filters'
        ));
    }

    public function show(int $id)
    {
        $university  = $this->svc->getUniversity($id);

        abort_if(!$university, 404);

        $courses     = $this->svc->getUniversityCourses($id);
        $scholarships= $this->svc->getUniversityScholarships($id);

        // Group courses by degree type
        $coursesByDegree = [];
        foreach ($courses as $c) {
            $coursesByDegree[$c->degree_type][] = $c;
        }

        return view('pages.university', compact(
            'university', 'courses', 'scholarships', 'coursesByDegree'
        ));
    }
}
