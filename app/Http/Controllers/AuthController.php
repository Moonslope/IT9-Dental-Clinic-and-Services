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
        // Validate the email and password input
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        $errors = [];
        // If user not found, show error
        if (!$user) {
            $errors['email']    = 'This email is not registered.';
            $errors['password'] = 'Incorrect password.';
        }
        // If password does not match, show error
        elseif (!Hash::check($request->password, $user->password)) {
            $errors['password'] = 'Incorrect password.';
        }

        // If there are any errors, redirect back with input and error messages
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate session
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Flash success message to session
            $request->session()->flash('login_success', 'You have logged in successfully!');

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'patient') {
                return redirect()->route('patient.main');
            } elseif ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            } elseif ($user->role === 'dentist') {
                return redirect()->route('dentist.dashboard');
            }
        }
    }

    // show register form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // set basic validation rules for all users
        $baseValidation = [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:8',
            'contact_number'  => 'required|string',
            'address'         => 'required|string',
            'role'            => 'required|in:patient,dentist,staff,admin',
        ];

        // if role is dentist, add specialization field
        if ($request->role === 'dentist') {
            $baseValidation['specialization'] = 'required|string';
        }

        // validate input data
        $data = $request->validate($baseValidation);

        // create new user
        $user = User::create([
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'email'          => $data['email'],
            'password'       => Hash::make($data['password']),
            'contact_number' => $data['contact_number'],
            'address'        => $data['address'],
            'role'           => $data['role'],
        ]);

        // if user is patient, create patient record and login
        if ($user->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'age'     => null,
                'gender'  => null,
            ]);
            Auth::login($user);
            return redirect()->route('patient.main');
        } elseif ($user->role === 'dentist') {
            Dentist::create([
                'user_id'        => $user->id,
                'specialization' => $data['specialization'],
            ]);

            return redirect()->route('admin.dentist')->with('added_success', 'Dentist successfully added!');
        } else {
            return redirect()->route('admin.staff')->with('added_success', 'Staff successfully added!');
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
