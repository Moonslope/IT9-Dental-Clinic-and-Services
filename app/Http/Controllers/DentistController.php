<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\get;

class DentistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_dentist(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        // Fetch users with 'dentist' role and include dentist-related data
        $users = User::with('dentist')
            ->where('role', 'dentist')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhereHas('dentist', function ($q2) use ($search) {
                            $q2->where('specialization', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        // Return the view with the list of dentists
        return view('admin.dentist', ['users' => $users]);
    }

    public function index()
    {
        // Get the logged-in user
        $dentist = User::where('id', Auth::id())->first();

        // Get the dentist ID from the dentists table
        $dentistId = Dentist::where('user_id', Auth::id())->value('id');

        // Count the upcoming appointments
        $upcomingAppointmentsCount = Appointment::where('dentist_id', $dentistId)
            ->where('appointment_date', '>', today())
            ->where('status', 'Approved')
            ->count();

        // Count the completed appointments
        $completedAppointmentsCount = Appointment::where('dentist_id', $dentistId)
            ->where('appointment_date', '>', today())
            ->where('status', 'Completed')
            ->count();

        // Count today's appointments
        $todayAppointmentsCount = Appointment::where('dentist_id', $dentistId)
            ->whereDate('appointment_date', today())
            ->where('status', 'Approved')
            ->count();

        // Count total patients this dentist
        $totalPatientsHandled = Appointment::where('dentist_id', $dentistId)
            ->whereIn('status', ['Completed', 'Approved'])
            ->distinct('patient_id')
            ->count();

        // Get unique patient appointments assigned to this dentist
        $appointmentsAssigned = Appointment::where('dentist_id', $dentistId)
            ->get()
            ->unique('patient_id');

        // Return the dashboard view with all collected data
        return view('dentist.dashboard', [
            'dentist'                       => $dentist,
            'appointmentsAssigned'          => $appointmentsAssigned,
            'todayAppointmentsCount'        => $todayAppointmentsCount,
            'totalPatientsHandled'          => $totalPatientsHandled,
            'upcomingAppointmentsCount'     => $upcomingAppointmentsCount,
            'completedAppointmentsCount'    => $completedAppointmentsCount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the incoming request data
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


        // If the user is a dentist, update their specialization as well
        if ($user->role === 'dentist') {
            $request->validate([
                'specialization' => 'required|string',
            ]);

            // If the dentist's record exists, update the specialization
            if ($user->dentist) {
                $user->dentist->update([
                    'specialization' => $request->specialization,
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

    public function appointments(Request $request)
    {
        $userID = Auth::id();

        // Retrieve the dentist record using the user's ID
        $dentist = Dentist::where('user_id', $userID)->first();

        // Get the search term from the request
        $search = $request->input('search');

        // Fetch appointments for the dentist, including related patient and service data
        $appointments = Appointment::with(['service', 'patient.user'])
            ->where('dentist_id', $dentist->id)
            ->when($search, function ($query, $search) {
                $query->whereHas('patient.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                    ->orWhereHas('service', function ($q) use ($search) {
                        $q->where('service_name', 'like', "%{$search}%");
                    });
            })
            ->get();

        // Return the appointments view for the dentist
        return view('dentist.appointments', [
            'appointments'  => $appointments,
            'dentist'       => $dentist
        ]);
    }

    public function treatmentRecords(Request $request)
    {
        // Retrieve the logged-in dentist along with their appointments and treatments
        $dentist = Dentist::where('user_id', Auth::id())
            ->with('appointments.treatments')
            ->firstOrFail();

        // Get the search query from the request
        $search = $request->input('search');

        // Fetch appointments with related treatment, service, and patient data
        $appointments = $dentist->appointments()
            ->with(['treatments', 'service', 'patient.user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('service', function ($q) use ($search) {
                    $q->where('service_name', 'like', "%{$search}%");
                })
                    ->orWhereHas('patient.user', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            })
            ->get();

        // Return the treatment records view
        return view('dentist.treatment', ['appointments' => $appointments]);
    }

    public function viewPrescription()
    {
        $userID = Auth::id();

        // Find the dentist record
        $dentist = Dentist::where('user_id', $userID)->first();

        // Get appointments handled by this dentist with related patients and prescriptions
        $appointments = Appointment::where('dentist_id', $dentist->id)
            ->with(['patient.user', 'treatments.prescriptions'])->get();

        // Pass the data to the prescription view
        return view('dentist.prescription', ['appointments' => $appointments]);
    }
}
