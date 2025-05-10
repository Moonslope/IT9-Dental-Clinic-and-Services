<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Dentist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $request->session()->flash('login_success', 'You have logged in successfully!');
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            elseif ($user->role === 'patient') {
                return redirect()->route('patient.main');
            } 
            elseif ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            } 
            elseif ($user->role === 'dentist') {
                return redirect()->route('dentist.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // show register form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $baseValidation = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'role' => 'required|in:patient,dentist,staff,admin',
        ];
    
        if ($request->role === 'dentist') {
            $baseValidation['specialization'] = 'required|string';
        }
    
        $data = $request->validate($baseValidation);
    
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact_number' => $data['contact_number'],
            'address' => $data['address'],
            'role' => $data['role'],
        ]);
    
        if ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'age' => null, 
                'gender' => null, 
            ]);
            Auth::login($user);

            return redirect()->route('patient.main');

        } elseif ($user->role === 'dentist') {
            Dentist::create([
                'user_id' => $user->id,
                'specialization' => $data['specialization'], 
            ]);

            return redirect()->route('admin.dentist')->with('added_success','Dentist successfully added!');

        } else {
            return redirect()->route('admin.staff')->with('added_success','Staff successfully added!');
        }
    }
    
    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}