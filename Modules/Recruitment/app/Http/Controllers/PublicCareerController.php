<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Recruitment\Models\JobVacancy;
use Modules\Recruitment\Models\JobApplication;

class PublicCareerController extends Controller
{
    public function index()
    {
        $vacancies = \Modules\Recruitment\Models\JobVacancy::where('status', 'open')
            ->where(function($q) {
                $q->whereNull('closing_date')
                  ->orWhere('closing_date', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('recruitment::career.index', compact('vacancies'));
    }

    public function show($id)
    {
        $vacancy = JobVacancy::where('status', 'open')->findOrFail($id);
        
        // Cek apakah user (pelamar) sudah melamar pekerjaan ini
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = JobApplication::where('user_id', Auth::id())
                                        ->where('job_vacancy_id', $id)
                                        ->exists();
        }

        return view('recruitment::career.show', compact('vacancy', 'hasApplied'));
    }

    public function apply(Request $request, $id)
    {
        $request->validate([
            'expected_salary' => 'required|string|max:255'
        ]);

        $vacancy = JobVacancy::where('status', 'open')->findOrFail($id);
        $user = Auth::user();

        // Pastikan role candidate
        if ($user->role !== 'candidate') {
            return redirect()->route('career.index')->with('error', 'Hanya pelamar yang dapat melamar pekerjaan.');
        }

        // Cek duplicate
        if (JobApplication::where('user_id', $user->id)->where('job_vacancy_id', $id)->exists()) {
            return back()->with('error', 'Anda sudah melamar posisi ini sebelumnya.');
        }

        // Pastikan pelamar sudah mengisi profil (punya CandidateProfile)
        if (!$user->candidateProfile || !$user->candidateProfile->phone || !$user->candidateProfile->cv_path) {
            return redirect()->route('career.dashboard')->with('error', 'Harap lengkapi profil dan upload CV Anda terlebih dahulu sebelum melamar pekerjaan.');
        }

        // Buat lamaran
        JobApplication::create([
            'user_id' => $user->id,
            'job_vacancy_id' => $vacancy->id,
            'cv_path' => $user->candidateProfile->cv_path,
            'expected_salary' => $request->expected_salary,
            'status' => 'pending'
        ]);

        return redirect()->route('career.dashboard')->with('success', 'Berhasil melamar posisi ' . $vacancy->title . '! Semoga sukses.');
    }
}
