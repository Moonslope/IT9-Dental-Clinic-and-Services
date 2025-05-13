<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
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
    public function store(Request $request, Treatment $treatment)
    {

        // Get the total amount from the treatment's cost
        $totalAmount = $treatment->treatment_cost;

        // Create the payment record
        $payment = Payment::create([
            'treatment_id' => $treatment->id,
            'total_amount' => $totalAmount,
            'payment_date' => Carbon::now()->toDateString(),
        ]);

        // Update the treatment status
        $treatment->status = 'Paid';
        $treatment->appointment->status = 'Completed';
        $treatment->save();
        $treatment->appointment->save();

        return redirect()->back()->with('success', 'Payment successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
