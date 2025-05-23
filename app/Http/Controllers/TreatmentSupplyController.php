<?php

namespace App\Http\Controllers;

use App\Models\TreatmentSupply;
use App\Models\Supply;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentSupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_stock_out()
    {
        $stock_outs = TreatmentSupply::all();
        return view('admin.stock_out_history', ['stock_outs' => $stock_outs]);
    }

    public function staff_stock_out()
    {
        // Get all stock-out records (from treatment-supply junction table)
        $stock_outs = TreatmentSupply::all();
        return view('staff.stock_out_history', ['stock_outs' => $stock_outs]);
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
        // Validate incoming request

        $request->validate([
            'treatment_id'  => 'required|exists:treatments,id',
            'supplies'      => 'required|array',
        ]);

        // Retrieve the treatment
        $treatment = Treatment::findOrFail($request->treatment_id);
        $totalCost = 0;

        // Loop through each selected supply
        foreach ($request->supplies as $supplyId => $data) {
            if (isset($data['selected']) && $data['selected']) {
                $quantity   = intval($data['quantity'] ?? 0);
                $supply     = Supply::findOrFail($supplyId);

                // Ensure there's enough stock for the supply
                if ($quantity < 1 || $supply->supply_quantity < $quantity) {
                    return back()->with('error', 'Invalid quantity or not enough stock for ' . $supply->supply_name);
                }

                // Deduct the stock
                $supply->supply_quantity -= $quantity;
                $supply->save();

                // Calculate the total cost (supply price * quantity used)
                $totalCost += $supply->supply_price * $quantity;

                // Add to the treatment-supply junction table
                TreatmentSupply::create([
                    'treatment_id'      => $request->treatment_id,
                    'supply_id'         => $supplyId,
                    'quantity_used'     => $quantity,
                    'total_quantity'    => $supply->supply_quantity,
                ]);
            }
        }

        // Update the treatment's total cost
        $treatment->treatment_cost += $totalCost;
        $treatment->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentSupply $treatmentSupply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatmentSupply $treatmentSupply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TreatmentSupply $treatmentSupply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentSupply $treatmentSupply)
    {
        //
    }
}
