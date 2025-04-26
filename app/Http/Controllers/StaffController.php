<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_staff()
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.staff', ['users' => $users]);
    }

    public function index()
    {
        $staff = User::where('id', Auth::id())->first();
        return view('staff.dashboard',  ['staff'=>$staff]);
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'password' => 'nullable|min:8'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect(route('admin.staff'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect(route('admin.staff'));
    }
}
