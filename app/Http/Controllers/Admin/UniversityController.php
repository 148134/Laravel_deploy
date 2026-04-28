<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\UniversityType;
use App\Models\Province;
use App\Models\Region;
use App\Models\AccreditationLevel;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    private function sharedData(): array
    {
        return [
            'univTypes'    => UniversityType::orderBy('type_id')->get(),
            'provinces'    => Province::orderBy('province_name')->get(),
            'regions'      => Region::orderBy('region_id')->get(),
            'accredLevels' => AccreditationLevel::orderBy('accred_id')->get(),
        ];
    }

    public function index(Request $request)
    {
        $query = University::with(['type', 'province.region', 'accreditation'])
                           ->orderBy('university_name');

        if ($q = $request->q) {
            $query->where(function ($b) use ($q) {
                $b->where('university_name', 'like', "%{$q}%")
                  ->orWhere('abbreviation',  'like', "%{$q}%")
                  ->orWhere('city',          'like', "%{$q}%");
            });
        }
        if ($request->type_id)   $query->where('type_id',   $request->type_id);
        if ($request->region_id) $query->whereHas('province', fn($p) => $p->where('region_id', $request->region_id));
        if ($request->active !== null && $request->active !== '') {
            $query->where('is_active', (int) $request->active);
        }

        $universities = $query->limit(200)->get();

        return view('admin.universities.index', array_merge(
            $this->sharedData(),
            compact('universities')
        ));
    }

    public function create()
    {
        return view('admin.universities.create', $this->sharedData());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'university_name'  => 'required|string|max:250',
            'abbreviation'     => 'nullable|string|max:50',
            'type_id'          => 'nullable|integer',
            'province_id'      => 'nullable|integer',
            'city'             => 'nullable|string|max:100',
            'year_established' => 'nullable|integer|min:1800|max:2099',
            'website'          => 'nullable|url|max:200',
            'email'            => 'nullable|email|max:150',
            'phone'            => 'nullable|string|max:80',
            'accred_id'        => 'nullable|integer',
            'is_active'        => 'boolean',
            'description'      => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        University::create($data);

        return redirect()->route('admin.universities.index')
                         ->with('success', 'University created successfully.');
    }

    public function edit(University $university)
    {
        return view('admin.universities.edit', array_merge(
            $this->sharedData(),
            compact('university')
        ));
    }

    public function update(Request $request, University $university)
    {
        $data = $request->validate([
            'university_name'  => 'required|string|max:250',
            'abbreviation'     => 'nullable|string|max:50',
            'type_id'          => 'nullable|integer',
            'province_id'      => 'nullable|integer',
            'city'             => 'nullable|string|max:100',
            'year_established' => 'nullable|integer|min:1800|max:2099',
            'website'          => 'nullable|url|max:200',
            'email'            => 'nullable|email|max:150',
            'phone'            => 'nullable|string|max:80',
            'accred_id'        => 'nullable|integer',
            'is_active'        => 'boolean',
            'description'      => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $university->update($data);

        return redirect()->route('admin.universities.index')
                         ->with('success', 'University updated successfully.');
    }

    public function destroy(University $university)
    {
        $university->delete(); 
        return redirect()->route('admin.universities.index')
                         ->with('success', 'University deleted.');
    }

    public function toggle(University $university)
    {
        $university->update(['is_active' => ! $university->is_active]);
        return back()->with('success', 'Status toggled.');
    }
}
