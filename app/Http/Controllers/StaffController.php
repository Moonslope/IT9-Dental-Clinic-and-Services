<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Supply;
use App\Models\Supplier;
use App\Models\Dentist;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $totalSupplies = Supply::count();
        $totalSuppliers = Supplier::count();
        $totalPatients = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $upcomingAppointments = Appointment::whereDate('appointment_date', '>', Carbon::today())->where('status', 'approved')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $staff = User::where('id', Auth::id())->first();

        // Revenue for today
        $todayRevenue = Payment::whereDate('created_at', Carbon::today())->sum('total_amount');

        // Revenue for this week 
        $weekRevenue = Payment::whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->sum('total_amount');
            
        // Revenue for this month 
        $monthRevenue = Payment::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        // Revenue for this year 
        $yearRevenue = Payment::whereYear('created_at', Carbon::now()->year)->sum('total_amount');

        $services = Service::withCount('appointments')->get();

        $labels = $services->pluck('service_name');
        $data = $services->pluck('appointments_count');

        return view('staff.dashboard',  
        [
        'staff' => $staff,
        'totalSupplies' => $totalSupplies,
        'totalSuppliers' => $totalSuppliers,
        'totalPatients' => $totalPatients,
        'todayAppointments' => $todayAppointments,
        'upcomingAppointments' => $upcomingAppointments,
        'pendingAppointments' => $pendingAppointments,
        'todayRevenue' => $todayRevenue,
        'weekRevenue' => $weekRevenue,
        'monthRevenue' => $monthRevenue,
        'yearRevenue' => $yearRevenue,
        'labels' => $labels,
        'data' => $data
        ]);
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
