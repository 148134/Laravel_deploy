<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('degree_type')->orderBy('course_name')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => 'required|string|max:30',
            'course_name' => 'required|string|max:200',
            'degree_type' => 'required|in:Certificate,Associate,Bachelor,Master,Doctorate,Professional',
            'years'       => 'required|integer|min:1|max:8',
            'board_exam'  => 'boolean',
        ]);

        $data['course_code'] = strtoupper(trim($data['course_code']));
        $data['board_exam']  = $request->boolean('board_exam');

        Course::create($data);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course created.');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'course_code' => 'required|string|max:30',
            'course_name' => 'required|string|max:200',
            'degree_type' => 'required|in:Certificate,Associate,Bachelor,Master,Doctorate,Professional',
            'years'       => 'required|integer|min:1|max:8',
            'board_exam'  => 'boolean',
        ]);

        $data['course_code'] = strtoupper(trim($data['course_code']));
        $data['board_exam']  = $request->boolean('board_exam');

        $course->update($data);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        $course->universityCourses()->delete();
        $course->delete();
        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course deleted.');
    }
}
