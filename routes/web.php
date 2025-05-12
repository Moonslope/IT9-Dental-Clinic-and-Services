<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\TreatmentSupplyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrescriptionController;

Route::get('/', [PatientController::class, 'index']);

// LOGIN / REGISTER / LOGOUT
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PATIENT
Route::prefix('/')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::get('home', [PatientController::class, 'index'])->name('main');
    Route::get('home/profile', [PatientController::class, 'profile'])->name('profile');

    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

// ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/staff', [StaffController::class, 'admin_staff'])->name('staff');
    Route::get('/service', [ServiceController::class, 'admin_service'])->name('service');
    Route::get('/dentist', [DentistController::class, 'admin_dentist'])->name('dentist');
    Route::get('/patient', [PatientController::class, 'admin_patient'])->name('patient');
    Route::get('/supply', [SupplyController::class, 'admin_supply'])->name('supply');
    Route::get('/supplier', [SupplierController::class, 'admin_supplier'])->name('supplier');
    Route::get('/stock in history', [StockInController::class, 'admin_stock_in_history'])->name('stock_in_history');
    Route::get('/treatment', [TreatmentController::class, 'admin_treatment'])->name('treatment');
    Route::get('/appointment', [AppointmentController::class, 'admin_appointments'])->name('appointment');
    Route::get('/stock outs', [TreatmentSupplyController::class, 'admin_stock_out'])->name('stock_out');

    Route::delete('/staff/{user}/delete', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::put('/staff/{user}/update', [StaffController::class, 'update'])->name('staff.update');

    Route::delete('/dentist/{user}/delete', [DentistController::class, 'destroy'])->name('dentist.destroy');
    Route::put('/dentist/{user}/update', [DentistController::class, 'update'])->name('dentist.update');
});

// STAFF
Route::prefix('/staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');
    Route::get('/service', [ServiceController::class, 'staff_service'])->name('service');
    Route::get('/appointments', [AppointmentController::class, 'staff_appointments'])->name('appointment');
    Route::get('/supplier', [SupplierController::class, 'staff_supplier'])->name('supplier');
    Route::get('/supply', [SupplyController::class, 'staff_supply'])->name('supply');
    Route::get('/stock in history', [StockInController::class, 'staff_stock_in_history'])->name('stock_in_history');
    Route::get('/patient', [PatientController::class, 'staff_patient'])->name('patient');
    Route::get('/treatment', [TreatmentController::class, 'staff_treatment'])->name('treatment');
    Route::get('/stock outs', [TreatmentSupplyController::class, 'staff_stock_out'])->name('stock_out');
});

// DENTIST
Route::prefix('/dentist')->name('dentist.')->middleware(['auth', 'role:dentist'])->group(function () {
    Route::get('/dashboard', [DentistController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DentistController::class, 'appointments'])->name('appointments');
    Route::get('/treatmentRecords', [DentistController::class, 'treatmentRecords'])->name('treatmentRecords');
    Route::post('/treatment', [PrescriptionController::class, 'store'])->name('treatment.store');
    Route::get('/prescription', [DentistController::class, 'viewPrescription'])->name('prescription');
    Route::put('/prescription/{prescription}', [PrescriptionController::class, 'update'])->name('prescription.update');
    Route::get('/prescription', [DentistController::class, 'viewPrescription'])->name('prescription');
});

//service crud para sa admin ug staff
Route::prefix('service')->name('service.')->group(function () {
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::put('/{service}/update', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{service}/delete', [ServiceController::class, 'destroy'])->name('destroy');
});

//supplier crud para sa admin ug staff
Route::prefix('supplier')->name('supplier.')->group(function () {
    Route::post('/', [SupplierController::class, 'store'])->name('store');
    Route::put('/{supplier}/update', [SupplierController::class, 'update'])->name('update');
    Route::delete('/{supplier}/delete', [SupplierController::class, 'destroy'])->name('destroy');
});

//supply crud para sa admin ug staff
Route::prefix('supply')->name('supply.')->group(function () {
    Route::post('/', [SupplyController::class, 'store'])->name('store');
    Route::put('/{supply}/update', [SupplyController::class, 'update'])->name('update');
    Route::delete('/{supply}/delete', [SupplyController::class, 'destroy'])->name('destroy');
});

// para sa stock in
Route::post('/stock_in', [StockInController::class, 'store'])->name('supply.stock_in');
Route::put('/stock_in/{stock}', [StockInController::class, 'update'])->name('stock_in.update');
Route::delete('/stock_in/{stock}', [StockInController::class, 'destroy'])->name('stock_in.destroy');

// para sa patient
Route::post('/patient', [PatientController::class, 'store'])->name('patient.store');
Route::put('/patient/{user}', [PatientController::class, 'update'])->name('patient.update');
Route::delete('/patient/{user}', [PatientController::class, 'destroy'])->name('patient.destroy');

// appointments
Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::put('/appointments/update/{appointment}', [AppointmentController::class, 'patient_update'])->name('appointments.patient_update');

Route::post('/add/appointments', [AppointmentController::class, 'store_admin_staff'])->name('appointments.store');

Route::post('/treatment-supply', [TreatmentSupplyController::class, 'store'])->name('treatment-supply.store');

Route::post('/payment/{treatment}', [PaymentController::class, 'store'])->name('payment.store');

Route::post('/treatments/{appointment}', [TreatmentController::class, 'store'])->name('treatments.store');

