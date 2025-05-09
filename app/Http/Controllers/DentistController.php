<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dentist;
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
    public function admin_dentist()
    {
        $users = User::with('dentist')->where('role', 'dentist')->get();
        return view('admin.dentist', ['users' => $users]);
    }

    public function index()
    {
        $dentist = User::where('id', Auth::id())->first();
        return view('dentist.dashboard',  ['dentist' => $dentist]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dentist $dentist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dentist $dentist)
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

        if ($user->role === 'dentist') {
            $request->validate([
                'specialization' => 'required|string',
            ]);

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

    public function appointments()
    {
        $userID = Auth::id();

        $dentist = Dentist::where('user_id', $userID)->first();

        $appointments = Appointment::with(['service', 'patient'])->where('dentist_id', $dentist->id)->get();

        return view('dentist.appointments', [
            'appointments' => $appointments,
            'dentist' => $dentist
        ]);
    }

    public function treatmentRecords()
    {
        $dentist = Dentist::where('user_id', Auth::id())->with('appointments.treatments')->firstOrFail();

        $appointments = $dentist->appointments()->with(['treatments', 'service', 'patient.user'])->get();
        return view('dentist.treatment', ['appointments' => $appointments]);
    }
}
