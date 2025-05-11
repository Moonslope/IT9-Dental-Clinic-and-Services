<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin_staff(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('role', 'staff')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('contact_number', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('admin.staff', ['users' => $users]);
    }

    public function index()
    {
        $staff = User::where('id', Auth::id())->first();
        return view('staff.dashboard',  ['staff' => $staff]);
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
        return redirect()->back()->with('updated_success','Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return redirect()->back()->with('deleted_success','Successfully deleted!');
    }

    
}
