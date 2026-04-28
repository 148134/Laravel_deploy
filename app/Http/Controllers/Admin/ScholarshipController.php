<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::orderBy('scholarship_type')->orderBy('scholarship_name')->get();
        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'scholarship_name' => 'required|string|max:250',
            'provider'         => 'required|string|max:150',
            'scholarship_type' => 'required|in:Government,Institutional,Private,External',
            'coverage'         => 'nullable|string',
            'eligibility'      => 'nullable|string',
            'website'          => 'nullable|url|max:200',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Scholarship::create($data);

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship created.');
    }

    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $data = $request->validate([
            'scholarship_name' => 'required|string|max:250',
            'provider'         => 'required|string|max:150',
            'scholarship_type' => 'required|in:Government,Institutional,Private,External',
            'coverage'         => 'nullable|string',
            'eligibility'      => 'nullable|string',
            'website'          => 'nullable|url|max:200',
            'is_active'        => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $scholarship->update($data);

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship updated.');
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->universityScholarships()->delete();
        $scholarship->delete();
        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship deleted.');
    }
}
