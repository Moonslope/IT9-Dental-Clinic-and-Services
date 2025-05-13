<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Supply;
use Illuminate\Http\Request;
use App\Http\Controllers\SupplyController;

class StockInController extends Controller
{
    public function admin_stock_in_history()
    {
        $stock_ins = StockIn::latest()->get();
        return view('admin.stock_in_history', ['stock_ins' => $stock_ins]);
    }

    public function staff_stock_in_history()
    {
        // Get all stock-in records in descending order (latest first)
        $stock_ins = StockIn::latest()->get();
        return view('staff.stock_in_history', ['stock_ins' => $stock_ins]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'supply_id'         => 'required|exists:supplies,id',
            'quantity_received' => 'required|integer|min:1',
            'date_received'     => 'required|date',
            'supplier_id'       => 'required|exists:suppliers,id',
            'user_id'           => 'required|exists:users,id',
        ]);

        // Get the current supply
        $supply = Supply::findOrFail($validated['supply_id']);

        // Add received quantity to current supply quantity
        $supply->supply_quantity += $validated['quantity_received'];
        $supply->save();

        // Create a new stock-in record
        StockIn::create([
            'supply_id'         => $validated['supply_id'],
            'quantity_received' => $validated['quantity_received'],
            'total_quantity'    => $supply->supply_quantity,
            'date_received'     => $validated['date_received'],
            'user_id'           => $validated['user_id'],
            'supplier_id'       => $validated['supplier_id'],
        ]);

        return redirect()->back()->with('added_success', 'Successfully added!');
    }



    public function update(Request $request, StockIn $stock)
    {
        $request->validate([
            'quantity_received' => 'required|integer|min:1',
            'date_received' => 'required|date',
        ]);

        $old_quantity = $stock->quantity_received;

        // Adjust supply quantity
        $supply = Supply::findOrFail($stock->supply_id);
        $quantity_difference = $request->quantity_received - $old_quantity;
        $supply->supply_quantity += $quantity_difference;

        if ($supply->supply_quantity < 0) {
            $supply->supply_quantity = 0; // Prevent negative
        }

        $supply->save();

        // Update stock-in record
        $stock->quantity_received = $request->quantity_received;
        $stock->total_quantity = $supply->supply_quantity;
        $stock->date_received = $request->date_received;
        $stock->save();

        return redirect()->back()->with('updated_success', 'Successfully updated!');
    }

    public function destroy(Request $request, StockIn $stock)
    {
        $supply = Supply::findOrFail($stock->supply_id);
        $supply->supply_quantity -= $stock->quantity_received;

        if ($supply->supply_quantity < 0) {
            $supply->supply_quantity = 0; // prevent negative stock
        }
        $supply->save();

        $stock->delete();

        return redirect()->back()->with('deleted_success', 'Successfully deleted!');
    }
}
