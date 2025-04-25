<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DentistController;

Route::get('/', function () {
    return view('patient.main');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('/')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::get('home', [PatientController::class, 'index'])->name('main');
  
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/staff', [StaffController::class, 'admin_staff'])->name('staff');

    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::delete('/staff/{user}/destroy', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::put('/staff/{user}/update', [StaffController::class, 'update'])->name('staff.update');
  
});

Route::prefix('/staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');
  
});

Route::prefix('/dentist')->name('dentist.')->middleware(['auth', 'role:dentist'])->group(function () {
    Route::get('/dashboard', [DentistController::class, 'index'])->name('dashboard');
  
});

