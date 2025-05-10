<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Dentist;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalDentists = Dentist::count();
        $totalStaffs = User::where('role', 'staff')->count();
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $upcomingAppointments = Appointment::whereDate('appointment_date', '>', Carbon::today())->where('status', 'approved')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return view('admin.dashboard',
        ['totalDentists'=>$totalDentists,
        'totalStaffs'=>$totalStaffs,
        'todayAppointments'=>$todayAppointments,
        'upcomingAppointments'=>$upcomingAppointments,
        'pendingAppointments'=>$pendingAppointments]);
    }
}
