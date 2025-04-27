<?php

namespace App\Http\Controllers;

use App\Models\Supply;
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
    public function admin_supply()
    {
        $user = User::where('id', Auth::id())->first();
        $suppliers = Supplier::all();
        $supplies = Supply::all();
        return view('admin.supply', ['supplies'=>$supplies, 'suppliers'=>$suppliers, 'user'=>$user]);
    }

    public function staff_supply()
    {
        $user = User::where('id', Auth::id())->first();
        $suppliers = Supplier::all();
        $supplies = Supply::all();
        return view('staff.supply', ['supplies'=>$supplies, 'suppliers'=>$suppliers, 'user'=>$user]);
 
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
    public function store(SupplyRequest $request)
    {
        $newSupply = $request->validated();
        Supply::create($newSupply);

        return redirect($request->input('redirect_to', route('staff.supply')));
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplyRequest $request, Supply $supply)
    {
        $newSupply = $request->validated();
        $supply->update($newSupply);

        return redirect($request->input('redirect_to', route('staff.supply')));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Supply $supply)
    {
        $supply->delete();
        return redirect($request->input('redirect_to', route('staff.supply')));
    }
}
