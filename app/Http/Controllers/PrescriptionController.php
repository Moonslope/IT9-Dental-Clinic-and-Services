<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Dentist;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate the input data
        $validated = $request->validate([
            'treatment_id'  => 'required|exists:treatments,id',
            'patient_id'    => 'required|exists:patients,id',
            'medication'    => 'required|string|max:255',
            'instructions'  => 'required|string',
        ]);

        // Create the prescription using validated data
        Prescription::create($validated);

        return redirect()->back()->with('success', 'Prescription created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        // Update prescription using validated form data
        $prescription->update($request->validated());

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        //
    }
}
