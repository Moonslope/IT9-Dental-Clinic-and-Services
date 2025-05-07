<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Dentist;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Nullable;

class AppointmentController extends Controller
{
    public function staff_appointments()
    {
        $appointments = Appointment::with(['service', 'patient.user', 'dentist.user'])->get();
        $dentists = Dentist::all();
        // dd($appointments);
        return view('staff.appointment', ['appointments' => $appointments, 'dentists' => $dentists]);
    }

    public function admin_appointments()
    {
        $appointments = Appointment::with(['service', 'patient.user', 'dentist.user'])->get();
        $dentists = Dentist::all();
        $patients = Patient::latest()->get();
        $services = Service::all();
        // dd($appointments);
        return view('admin.appointment', 
        ['appointments' => $appointments, 
         'dentists' => $dentists, 
         'services'=>$services,
         'patients'=>$patients
    ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after:today',
            'message' => 'nullable|string|max:255',
        ]);

        $patient = Patient::where('user_id', Auth::id())->first();
        if (!$patient) {
            return redirect()->back()->withErrors(['error' => 'Patient record not found.']);
        }

        Appointment::create([
            'service_id' => $request->service_id,
            'patient_id' => $patient->id,
            'dentist_id' => $request->dentist_id ?? null,
            'appointment_date' => $request->appointment_date,
            'status' => 'Pending',
            // 'message' => $request->message,
        ]);

        return redirect()->back()->with('appointment_success', 'Your appointment has been sent successfully! Please wait for approval.');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'dentist_id' => 'required|exists:dentists,id',
            'appointment_date' => 'required|date|after:today',
        ]);

        $appointment->dentist_id = $request->input('dentist_id');
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->status = 'Approved';
        $appointment->save();

        // Check if a treatment already exists for this appointment
        if (!$appointment->treatment) {
            $servicePrice = $appointment->service->service_price ?? 0.00;

            Treatment::create([
                'appointment_id' => $appointment->id,
                'treatment_cost' => $servicePrice,
            ]);
        }

        return redirect($request->input('redirect_to', route('staff.appointment')));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
