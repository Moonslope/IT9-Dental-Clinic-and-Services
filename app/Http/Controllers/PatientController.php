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
        // Get the patient record linked to the logged-in user
        $patient = Patient::where('user_id', Auth::id())->first();

        // Get the authenticated user object
        $user = Auth::user();

        // Get appointments with related services if patient exists, otherwise return empty
        $appointments = $patient
            ? $patient->appointments()->with('service')->get()
            : collect();

        // Get prescriptions with nested relations (treatment → appointment → dentist → user)
        $prescriptions = $patient
            ? $patient->prescriptions()->with('treatment.appointment.dentist.user')->get()
            : collect();

        $services = Service::all();

        // Return data to the patient profile view
        return view('patient.profile', [
            'patient'       => $patient,
            'appointments'  => $appointments,
            'prescriptions' => $prescriptions,
            'services'      => $services,
            'user'          => $user
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

    public function admin_patient(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('patient')
            ->where('role', 'patient')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('admin.patient', ['users' => $users]);
    }

    public function staff_patient(Request $request)
    {
        // Get the search input from the request
        $search = $request->input('search');

        // Retrieve patients based on search criteria, if provided
        $users = User::with('patient')
            ->where('role', 'patient')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        // Return the view with the retrieved users
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
        // Base validation rules for user input
        $baseValidation = [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:8',
            'contact_number'    => 'required|string',
            'address'           => 'required|string',
            'role'              => 'required|in:patient,dentist,staff,admin',
        ];

        // Additional validation for patient-specific fields
        if ($request->role === 'patient') {
            $baseValidation['age']    = 'nullable|integer|min:1';
            $baseValidation['gender'] = 'nullable|string|max:10';
        }

        // Additional validation for patient-specific fields
        $data = $request->validate($baseValidation);

        // Create the new user in the database
        $user = User::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'contact_number'    => $data['contact_number'],
            'address'           => $data['address'],
            'role'              => $data['role'],
        ]);

        // If the user is a patient, create the corresponding patient record
        if ($user->role === 'patient') {
            Patient::create([
                'user_id'   => $user->id,
                'age'       => $data['age'],
                'gender'    => $data['gender'],
            ]);

            return redirect()->back()->with('added_success', 'Successfully added!');
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
        // Validate the incoming request data for the user update
        $validatedData = $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'contact_number'    => 'required|string',
            'address'           => 'required|string',
            'password'          => 'nullable|min:8',
        ]);

        // If a password is provided, hash it, otherwise, remove it from the update data
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Update the user record with the validated data
        $user->update($validatedData);

        // If the user is a patient, validate and update patient-specific details
        if ($user->role === 'patient') {
            $request->validate([
                'age'       => 'nullable|integer|min:1',
                'gender'    => 'nullable|string|max:10'
            ]);

            // If the user already has a related patient record, update the patient details
            if ($user->patient) {
                $user->patient->update([
                    'age'       => $request->age,
                    'gender'    => $request->gender,
                ]);
            }
        }

        return redirect()->back()->with('updated_success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect()->back()->with('deleted_success', 'Successfully deleted!');
    }
}
