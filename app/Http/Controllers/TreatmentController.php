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

    public function staff_treatment()
    {
        $supplies = Supply::all();
        $treatments = Treatment::latest()->get();
        return view('staff.treatment', ['treatments'=>$treatments, 'supplies'=>$supplies]);
    }

    public function admin_treatment()
    {
        $supplies = Supply::all();
        $treatments = Treatment::latest()->get();
        return view('admin.treatment', ['treatments'=>$treatments, 'supplies'=>$supplies]);
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
            'treatment_cost' => $appointment->service->service_price ?? 0.00,
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
