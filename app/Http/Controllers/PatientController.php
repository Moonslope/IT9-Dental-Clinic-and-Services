<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        $appointments = $patient ? $patient->appointments()->with('service')->get() : collect();
        $services = Service::all();

        return view('patient.profile', [
            'patient' => $patient,
            'appointments' => $appointments,
            'services' => $services
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
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
