<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('patient.main');
});

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
});

// ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/staff', [StaffController::class, 'admin_staff'])->name('staff');
    Route::get('/service', [ServiceController::class, 'admin_service'])->name('service');

    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::delete('/staff/{user}/delete', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::put('/staff/{user}/update', [StaffController::class, 'update'])->name('staff.update');
});

// STAFF
Route::prefix('/staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');
    Route::get('/service', [ServiceController::class, 'staff_service'])->name('service');
});

// DENTIST
Route::prefix('/dentist')->name('dentist.')->middleware(['auth', 'role:dentist'])->group(function () {
    Route::get('/dashboard', [DentistController::class, 'index'])->name('dashboard');
});


//service crud para sa admin ug staff
Route::prefix('service')->name('service.')->group(function () {
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::put('/{service}/update', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{service}/delete', [ServiceController::class, 'destroy'])->name('destroy');
});
