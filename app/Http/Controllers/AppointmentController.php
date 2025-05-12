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
    public function staff_appointments(Request $request)
    {
        $search = $request->input('search');

        $appointments = Appointment::with(['service', 'patient.user', 'dentist.user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('patient.user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dentist.user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('service', function ($q2) use ($search) {
                        $q2->where('service_name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%"); // <-- search by status
                });
            })
            ->get();

        $dentists = Dentist::all();
        $patients = Patient::latest()->get();
        $services = Service::all();

        return view('staff.appointment', [
            'appointments' => $appointments,
            'dentists' => $dentists,
            'services' => $services,
            'patients' => $patients
        ]);
    }

    public function admin_appointments(Request $request)
    {
        $search = $request->input('search');

        $appointments = Appointment::with(['service', 'patient.user', 'dentist.user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('patient.user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dentist.user', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('service', function ($q2) use ($search) {
                        $q2->where('service_name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%"); // <-- search by status
                });
            })
            ->get();

        $dentists = Dentist::all();
        $patients = Patient::latest()->get();
        $services = Service::all();

        return view('admin.appointment', [
            'appointments' => $appointments,
            'dentists' => $dentists,
            'services' => $services,
            'patients' => $patients
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
    
    public function store_admin_staff(Request $request){
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after:today',
        ]);

        Appointment::create([
        'service_id' => $request->service_id,
        'patient_id' => $request->patient_id,
        'dentist_id' => null,
        'appointment_date' => $request->appointment_date,
        'status' => 'Pending',
        ]);

        return redirect()->back()->with('appointment_success', 'Appointment successfully added.');;
    }

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

        return redirect()->back()->with('appointment_success', 'Your appointment has been sent successfully! Please wait for approval.');
    }

  
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:Approved,Declined',
            'dentist_id' => 'required_if:status,Approved|exists:dentists,id',
            'appointment_date' => 'required_if:status,Approved|date|after:today',
        ]);

        if ($request->status === 'Approved') {
        $appointment->dentist_id = $request->input('dentist_id');
        $appointment->appointment_date = $request->input('appointment_date');

        } else {
            $appointment->dentist_id = null;
        }

        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('updated_success', 'Appointment has been '. $request->status);
    }

    public function patient_update(Request $request, Appointment $appointment)
    {
        // Validate
        $request->validate([
            'service_id' => 'required|exists:services,id',  // Ensure the service ID exists
            'appointment_date' => 'required|date|after:today',  // Ensure the date is valid and in the future
        ]);

        // Update appointment details
        $appointment->service_id = $request->input('service_id');
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->save(); 

        return redirect()->back()->with('updated_success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->back()->with('deleted_success','Appointment successfully deleted!');
    }
}
