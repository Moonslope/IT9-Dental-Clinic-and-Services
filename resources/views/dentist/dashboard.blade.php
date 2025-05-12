@extends('layout.dentist_nav_layout')

@section('title', 'Dentist Dashboard')

@section('user_type', 'Hi, ' . $dentist->first_name . ' ' . $dentist->last_name)

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dashboard</span>
</div>

@endsection

@section('dentistContent')
<div class="row ps-3 py-2">
   <h2 class="">Dashboard Overview</h2>
</div>
<div class="row">
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-event fs-2 me-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Appointments Today</p>
               <p class="fs-3">0</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-event fs-2 me-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Total Patients</p>
               {{-- <p class="fs-3">{{$totalPatients}}</p> --}}
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-week fs-2 text-white"></i>
            </div>
            <div class="p-1">
               <p class="fs-5">Upcoming Appointments</p>
               <p class="fs-3">0</p>
            </div>
         </div>
      </div>
   </div>
</div>

@include('layout.modals.login_success')
@endsection