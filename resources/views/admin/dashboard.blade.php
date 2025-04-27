@extends('layout.admin_nav_layout')

@section('title', 'Admin Dashboard')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dashboard</span>
</div>

@endsection

@section('adminContent')

<div class="row">
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-week fs-2 me-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Appointments Today</p>
               <p class="fs-3">2</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-success">
               <i class="bi bi-people-fill fs-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Dentist</p>
               <p class="fs-3">12</p>
            </div>
         </div>
      </div>
   </div>
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-warning">
               <i class="bi bi-person-gear fs-2"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Staff</p>
               <p class="fs-3">4</p>
            </div>
         </div>
      </div>
   </div>
</div>




@endsection