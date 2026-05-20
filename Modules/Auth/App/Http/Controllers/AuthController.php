<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function editProfile()
    {
        $user      = Auth::user();
        $positions = Position::active()->orderBy('name')->get();
        return view('auth::profile', compact('user', 'positions'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diubah.');
    }

    // Director only — reset password akun lain
    public function resetPasswordForm(User $user)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }
        return view('auth::reset-password', compact('user'));
    }

    public function resetPassword(Request $request, User $user)
    {
        if (!Auth::user()->isDirector()) {
            abort(403);
        }

        $data = $request->validate([
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('dashboard.users')
            ->with('success', 'Password ' . $user->name . ' berhasil direset.');
    }
}
