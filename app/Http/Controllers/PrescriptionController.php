<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
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

        $validated = $request->validate([
            'treatment_id' => 'required|exists:treatments,id',
            'patient_id' => 'required|exists:patients,id',
            'medication' => 'required|string|max:255',
            'instructions' => 'required|string',
        ]);

        Prescription::create($validated);

        return redirect()->back()->with('success', 'Prescription created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prescription $prescription)
    {
        //
    }
}
