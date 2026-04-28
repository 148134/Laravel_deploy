<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccreditationLevel;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    public function index()
    {
        $levels = AccreditationLevel::orderBy('accred_id')->get();
        return view('admin.accreditation.index', compact('levels'));
    }

    public function edit(int $id)
    {
        $level = AccreditationLevel::findOrFail($id);
        return view('admin.accreditation.edit', compact('level'));
    }

    public function update(Request $request, int $id)
    {
        $level = AccreditationLevel::findOrFail($id);

        $data = $request->validate([
            'level_name'   => 'required|string|max:80',
            'body'         => 'nullable|string|max:80',
            'base_tuition' => 'required|integer|min:0',
            'description'  => 'nullable|string|max:255',
        ]);

        $level->update($data);

        return redirect()->route('admin.accreditation.index')
                         ->with('success', 'Accreditation level updated.');
    }
}
