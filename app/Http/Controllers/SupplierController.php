<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_supplier(Request $request)
    {
        $search = $request->input('search');
        $suppliers = Supplier::when($search, function ($query, $search) {
            $query->where('supplier_name', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        })->latest()->get();

        return view('admin.supplier', ['suppliers' => $suppliers]);
    }

    public function staff_supplier(Request $request)
    {
        $search = $request->input('search');

        // Filter suppliers based on search input (name, contact, or address)
        $suppliers = Supplier::when($search, function ($query, $search) {
            $query->where('supplier_name', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        })->latest()->get();

        // Return the view with filtered or full supplier list
        return view('staff.supplier', ['suppliers' => $suppliers]);
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
    public function store(SupplierRequest $request)
    {
        $newSupplier = $request->validated();

        // Create a new supplier record
        Supplier::create($newSupplier);

        return redirect()->back()->with('added_success', 'Successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $newSupplier = $request->validated();

        // Apply the validated updates to the supplier
        $supplier->update($newSupplier);

        return redirect()->back()->with('updated_success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->back()->with('deleted_success', 'Successfully deleted!');
    }
}
