<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use App\Models\Patient;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use function Pest\Laravel\get;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        $patient = Patient::where('user_id', Auth::id())->first();
        $user = Auth::user();
        $appointments = $patient ? $patient->appointments()->with('service')->get() : collect();
        $services = Service::all();

        return view('patient.profile', [
            'patient' => $patient,
            'appointments' => $appointments,
            'services' => $services,
            'user' => $user
        ]);
    }

    public function index()
    {
        $services = Service::all();
        $dentists = Dentist::all();
        return view('patient.main', [
            'services' => $services,
            'dentists' => $dentists,
        ]);
    }

    public function admin_patient(){

        $users = User::with('patient')->where('role', 'patient')->get();
        return view('admin.patient', ['users' => $users]);
    }

    public function staff_patient(){
        $users = User::with('patient')->where('role', 'patient')->get();
        return view('staff.patient', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
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

        if ($request->role === 'patient') {
            $baseValidation['age'] = 'nullable|integer|min:1';
            $baseValidation['gender'] = 'nullable|string|max:10';
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
                'age' => $data['age'], 
                'gender' => $data['gender'], 
            ]);

            return redirect($request->input('redirect_to', route('staff.patient')));
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'password' => 'nullable|min:8',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        if ($user->role === 'patient') {
            $request->validate([
                'age' => 'nullable|integer|min:1',
                'gender' => 'nullable|string|max:10'
            ]);

            if ($user->patient) {
                $user->patient->update([
                    'age' => $request->age,
                    'gender' => $request->gender,
                ]);
            }
        }

        $redirectTo = $request->input('redirect_to');

        if ($redirectTo) {
            return redirect($redirectTo);
        } elseif (Auth::user()->role === 'staff') {
            return redirect()->route('staff.patient');
        } else {
            return redirect()->back(); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect($request->input('redirect_to', route('staff.patient')));
    }
}
