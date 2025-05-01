<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Supply;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\SupplyController;

class StockInController extends Controller
{
    public function admin_stock_in_history(){
        $stock_ins = StockIn::latest()->get();
        return view('admin.stock_in_history', ['stock_ins'=>$stock_ins]);
    }

    public function staff_stock_in_history(){
        $stock_ins = StockIn::latest()->get();
        return view('staff.stock_in_history', ['stock_ins'=>$stock_ins]);
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'supply_id' => 'required|exists:supplies,id',
                'quantity_received' => 'required|integer|min:1',
                'supplier_id' => 'required|exists:suppliers,id',
                'user_id' => 'required|exists:users,id',
            ]);
    
            StockIn::create([
                'supply_id' => $validated['supply_id'],
                'quantity_received' => $validated['quantity_received'],
                'date_received' => Carbon::now()->format('Y-m-d'),
                'user_id' => $validated['user_id'],
                'supplier_id' => $validated['supplier_id'],
            ]);
          
            $supply = Supply::findOrFail($validated['supply_id']);
            $supply->supply_quantity += $validated['quantity_received'];
            $supply->save();
    
            return redirect()->back();
        
    }

   
}
