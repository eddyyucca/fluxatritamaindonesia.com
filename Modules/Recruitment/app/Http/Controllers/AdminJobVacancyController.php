<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Models\JobVacancy;

class AdminJobVacancyController extends Controller
{
    public function index()
    {
        $vacancies = JobVacancy::orderBy('created_at', 'desc')->paginate(10);
        return view('recruitment::admin.vacancies.index', compact('vacancies'));
    }

    public function create()
    {
        return view('recruitment::admin.vacancies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:open,closed',
            'closing_date' => 'nullable|date',
        ]);

        \Modules\Recruitment\Models\JobVacancy::create($validated);

        return redirect()->route('admin.vacancies.index')->with('success', 'Lowongan kerja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $vacancy = \Modules\Recruitment\Models\JobVacancy::findOrFail($id);
        return view('recruitment::admin.vacancies.edit', compact('vacancy'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'status' => 'required|in:open,closed',
            'closing_date' => 'nullable|date',
        ]);

        $vacancy = \Modules\Recruitment\Models\JobVacancy::findOrFail($id);
        $vacancy->update($validated);

        return redirect()->route('admin.vacancies.index')->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        JobVacancy::findOrFail($id)->delete();
        return back()->with('success', 'Lowongan berhasil dihapus.');
    }
}
