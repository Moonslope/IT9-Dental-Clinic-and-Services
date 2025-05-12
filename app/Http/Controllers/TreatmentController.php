<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Supply;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function admin_treatment(Request $request)
    {
        $search = $request->input('search');
        $supplies = Supply::all();
        $treatments = Treatment::with(['appointment.service', 'appointment.patient.user', 'appointment.dentist.user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('appointment.service', function ($q) use ($search) {
                    $q->where('service_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.patient.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.dentist.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.treatment', ['treatments' => $treatments, 'supplies' => $supplies]);
    }

    public function staff_treatment(Request $request)
    {
        $search = $request->input('search');
        $supplies = Supply::all();
        $treatments = Treatment::with(['appointment.service', 'appointment.patient.user', 'appointment.dentist.user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('appointment.service', function ($q) use ($search) {
                    $q->where('service_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.patient.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.dentist.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('staff.treatment', ['treatments' => $treatments, 'supplies' => $supplies]);
    }

    public function dentist_treatment(Request $request)
    {
        $search = $request->input('search');
        $supplies = Supply::all();
        $treatments = Treatment::with(['appointment.service', 'appointment.patient.user', 'appointment.dentist.user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('appointment.service', function ($q) use ($search) {
                    $q->where('service_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.patient.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orWhereHas('appointment.dentist.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('dentist.treatment', ['treatments' => $treatments, 'supplies' => $supplies]);
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
    public function store(Request $request, Appointment $appointment)
    {
        $treatment = Treatment::create([
            'appointment_id' => $appointment->id,
            'treatment_cost' => $appointment->service->base_price ?? 0.00,
            'status' => 'Unpaid',
        ]);

        $appointment->status = 'Ongoing';
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment has been proceeded to treatment.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}
