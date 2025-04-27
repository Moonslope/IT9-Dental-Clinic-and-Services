<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;

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
});

// ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/staff', [StaffController::class, 'admin_staff'])->name('staff');
    Route::get('/service', [ServiceController::class, 'admin_service'])->name('service');
    Route::get('/dentist', [DentistController::class, 'admin_dentist'])->name('dentist');
    Route::get('/supply', [SupplyController::class, 'admin_supply'])->name('supply');
    Route::get('/supplier', [SupplierController::class, 'admin_supplier'])->name('supplier');
    

    Route::delete('/staff/{user}/delete', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::put('/staff/{user}/update', [StaffController::class, 'update'])->name('staff.update');

    Route::delete('/dentist/{user}/delete', [DentistController::class, 'destroy'])->name('dentist.destroy');
    Route::put('/dentist/{user}/update', [DentistController::class, 'update'])->name('dentist.update');
}); 

// STAFF
Route::prefix('/staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('dashboard');
    Route::get('/service', [ServiceController::class, 'staff_service'])->name('service'); 
    Route::get('/supplier', [SupplierController::class, 'staff_supplier'])->name('supplier');
    Route::get('/supply', [SupplyController::class, 'staff_supply'])->name('supply'); 
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
Route::post('/', [StockInController::class, 'store'])->name('supply.stockin');