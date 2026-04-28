<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\UniversityCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TuitionController extends Controller
{
    /**
     * Show the tuition/fees editor for all courses of a university.
     */
    public function edit(University $university)
    {
        $offerings = UniversityCourse::with('course')
            ->where('university_id', $university->university_id)
            ->get()
            ->sortBy(fn($uc) => $uc->course->course_name ?? '')
            ->groupBy(fn($uc) => $uc->course->degree_type ?? 'Other');

        // All courses NOT yet linked — for the "Add course" dropdown
        $linkedIds     = $offerings->flatten()->pluck('course_id')->toArray();
        $availableCourses = Course::whereNotIn('course_id', $linkedIds)
                                  ->orderBy('degree_type')
                                  ->orderBy('course_name')
                                  ->get();

        return view('admin.universities.tuition', compact(
            'university', 'offerings', 'availableCourses'
        ));
    }

    /**
     * Bulk-save all tuition rows submitted from the editor.
     */
    public function update(Request $request, University $university)
    {
        $rows = $request->input('fees', []);

        $request->validate([
            'fees.*.tuition_fee_per_semester' => 'nullable|integer|min:0|max:9999999',
            'fees.*.misc_fees'                => 'nullable|integer|min:0|max:9999999',
            'fees.*.slots_per_year'           => 'nullable|integer|min:0|max:9999',
            'fees.*.notes'                    => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($rows, $university) {
            foreach ($rows as $ucId => $data) {
                UniversityCourse::where('uc_id', $ucId)
                    ->where('university_id', $university->university_id) // safety check
                    ->update([
                        'tuition_fee_per_semester' => (int) ($data['tuition_fee_per_semester'] ?? 0),
                        'misc_fees'                => (int) ($data['misc_fees']                ?? 0),
                        'slots_per_year'           => (int) ($data['slots_per_year']           ?? 0),
                        'is_available'             => isset($data['is_available']) ? 1 : 0,
                        'notes'                    => trim($data['notes'] ?? '') ?: null,
                    ]);
            }
        });

        return redirect()
            ->route('admin.tuition.edit', $university->university_id)
            ->with('success', 'Tuition & fees updated successfully.');
    }

    /**
     * Add a new course offering to this university.
     */
    public function addCourse(Request $request, University $university)
    {
        $data = $request->validate([
            'course_id'                => 'required|integer|exists:courses,course_id',
            'tuition_fee_per_semester' => 'nullable|integer|min:0',
            'misc_fees'                => 'nullable|integer|min:0',
            'slots_per_year'           => 'nullable|integer|min:0',
        ]);

        // Upsert — prevents duplicate
        UniversityCourse::firstOrCreate(
            [
                'university_id' => $university->university_id,
                'course_id'     => $data['course_id'],
            ],
            [
                'tuition_fee_per_semester' => $data['tuition_fee_per_semester'] ?? 0,
                'misc_fees'                => $data['misc_fees']                ?? 0,
                'slots_per_year'           => $data['slots_per_year']           ?? 50,
                'is_available'             => 1,
            ]
        );

        return redirect()
            ->route('admin.tuition.edit', $university->university_id)
            ->with('success', 'Course added to offerings.');
    }

    /**
     * Remove a course offering from this university.
     */
    // public function removeCourse(Request $request, University $university, int $ucId)
    // {
    //     UniversityCourse::where('uc_id', $ucId)
    //         ->where('university_id', $university->university_id)
    //         ->delete();

    //     return redirect()
    //         ->route('admin.tuition.edit', $university->university_id)
    //         ->with('success', 'Course removed from offerings.');
    // }
}
