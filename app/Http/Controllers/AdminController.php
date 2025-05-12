<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Treatment;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Dentist;
use App\Models\Prescription;
use App\Models\Service;
use App\Models\User;
use App\Models\Supply;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {
        $totalDentists = Dentist::count();
        $totalPatients = Patient::count();
        $totalServices = Service::count();
        $totalSupplies = Supply::count();
        $totalSuppliers = Supplier::count();
        $totalStaffs = User::where('role', 'staff')->count();
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $upcomingAppointments = Appointment::whereDate('appointment_date', '>', Carbon::today())->where('status', 'approved')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();

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

        return view('admin.dashboard', [
            'totalDentists' => $totalDentists,
            'totalPatients' => $totalPatients,
            'totalStaffs' => $totalStaffs,
            'totalServices' => $totalServices,
            'totalSupplies' => $totalSupplies,
            'totalSuppliers' => $totalSuppliers,
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'pendingAppointments' => $pendingAppointments,
            'completedAppointments' => $completedAppointments,
            'todayRevenue' => $todayRevenue,
            'weekRevenue' => $weekRevenue,
            'monthRevenue' => $monthRevenue,
            'yearRevenue' => $yearRevenue,
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function prescriptions()
    {
        $prescriptions = Prescription::with([
            'patient.user',
            'appointment.service',
            'appointment.dentist.user',
        ])->latest()->get();

        return view('admin.prescription', ['prescriptions' => $prescriptions]);
    }
}
