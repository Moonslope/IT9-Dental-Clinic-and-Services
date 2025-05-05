<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
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
    public function store(Request $request)
    {
        //
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
