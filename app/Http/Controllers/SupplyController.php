<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\StockIn;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplyRequest;
use Illuminate\Support\Facades\Auth;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_supply(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        $suppliers = Supplier::all();

        $search = $request->input('search');
        $supplies = Supply::when($search, function ($query, $search) {
            return $query->where('supply_name', 'like', "%{$search}%");
        })->latest()->get();

        return view('admin.supply', [
            'supplies' => $supplies,
            'suppliers' => $suppliers,
            'user' => $user
        ]);
    }

    public function staff_supply(Request $request)
    {
        // Get the currently authenticated user
        $user = User::where('id', Auth::id())->first();

        // Retrieve all suppliers
        $suppliers = Supplier::all();

        // Get search keyword from request
        $search = $request->input('search');
        $supplies = Supply::when($search, function ($query, $search) {
            return $query->where('supply_name', 'like', "%{$search}%");
        })->latest()->get();

        // Return the staff supply view with the supplies, suppliers, and user info
        return view('staff.supply', [
            'supplies'  => $supplies,
            'suppliers' => $suppliers,
            'user'      => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplyRequest $request)
    {
        // Create a new supply entry
        $newSupply = $request->validated();

        // Redirect with success message
        Supply::create($newSupply);

        return redirect()->back()->with('added_success', 'Successfully added');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplyRequest $request, Supply $supply)
    {
        // Validate and retrieve updated supply data
        $newSupply = $request->validated();

        // Update the supply record
        $supply->update($newSupply);

        return redirect()->back()->with('updated_success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Supply $supply)
    {
        $supply->delete();
        return redirect()->back()->with('deleted_success', 'Successfully deleted!');
    }
}
