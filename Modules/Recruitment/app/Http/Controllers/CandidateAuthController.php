<?php

namespace Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class CandidateAuthController extends Controller
{
    public function showRegister()
    {
        return view('recruitment::auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'candidate',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function showLogin()
    {
        return view('recruitment::auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'candidate'], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('career.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau Anda bukan kandidat pelamar.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('career.login');
    }

    public function notice()
    {
        return view('recruitment::auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('career.dashboard');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim ulang ke email Anda!');
    }

    public function dashboard()
    {
        $profile = \Modules\Recruitment\Models\CandidateProfile::where('user_id', Auth::id())->first();
        $applications = \Modules\Recruitment\Models\JobApplication::with('vacancy')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Ambil lowongan aktif untuk ditampilkan di dashboard
        $vacancies = \Modules\Recruitment\Models\JobVacancy::where('status', 'open')
            ->where(function($q) {
                $q->whereNull('closing_date')
                  ->orWhere('closing_date', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('recruitment::dashboard.index', compact('profile', 'applications', 'vacancies'));
    }

    public function profile()
    {
        $profile = \Modules\Recruitment\Models\CandidateProfile::firstOrNew(['user_id' => Auth::id()]);
        return view('recruitment::dashboard.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'date_of_birth' => 'required|date',
            'education_level' => 'required|string|max:100',
            'major' => 'required|string|max:150',
            'university' => 'required|string|max:150',
            'experience_years' => 'required|integer|min:0',
            'skills' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $profile = \Modules\Recruitment\Models\CandidateProfile::firstOrNew(['user_id' => Auth::id()]);
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->gender = $request->gender;
        $profile->date_of_birth = $request->date_of_birth;
        $profile->education_level = $request->education_level;
        $profile->major = $request->major;
        $profile->university = $request->university;
        $profile->experience_years = $request->experience_years;
        $profile->skills = $request->skills;

        if ($request->hasFile('cv_file')) {
            $path = $request->file('cv_file')->store('cv_files', 'public');
            $profile->cv_path = $path;
        }

        $profile->save();

        return back()->with('success', 'Data diri dan CV berhasil disimpan!');
    }
}
