<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Recruitment\Models\JobApplication;

class AdminRecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \Modules\Recruitment\Models\JobApplication::with(['user.candidateProfile', 'vacancy'])->orderBy('created_at', 'desc');
        
        if ($request->has('vacancy_id')) {
            $query->where('job_vacancy_id', $request->vacancy_id);
        }
        
        $applications = $query->paginate(20);
        return view('recruitment::admin.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recruitment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('recruitment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('recruitment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,rejected,hired'
        ]);

        $application = JobApplication::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function viewCv($path)
    {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
        }
        
        abort(404, 'CV tidak ditemukan.');
    }
}
