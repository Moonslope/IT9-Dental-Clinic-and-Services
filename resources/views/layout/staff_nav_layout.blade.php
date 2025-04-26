@extends('layout.layout')
@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid vh-100">
   <div class="row border border-start-0 border-end-0 border-top-0 border-2 ">
      <div class="col col-2  d-flex justify-content-center">
         <img class="me-3" height="65" width="65" src="{{ asset('images/final_logo.svg') }}" alt="Clinic Logo">
      </div>

      <div class="col d-flex align-items-center">

         @yield('breadcrumb')

      </div>

      <div class="col d-flex justify-content-end align-items-center pe-3">
         <div>
            <p>@yield('user_type')</p>
         </div>
      </div>
   </div>

   <div style="min-height: 525px !important;" class="row">
      <div style="background-color: #1e466b !important;" class="col-2">
         <div class="pb-2 pt-2 px-2 ">
            <a class="admin-btn" href="{{route('staff.dashboard')}}"><i
                  class="bi bi-house-door fs-5 me-2"></i>Dashboard</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href=""><i class="bi bi-box-seam fs-5 me-2"></i>Supplies</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('staff.supplier')}}"><i
                  class="bi bi-people-fill me-2 fs-5"></i>Suppliers</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('staff.service')}}"><i class="bi bi-card-list fs-5 me-2"></i>Services</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href=""><i class="bi bi-person-lines-fill fs-5 me-2"></i>Patients</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href=""><i class="bi bi-calendar-week fs-5 me-2"></i>Appointments</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href=""><i class="bi bi-clock-history fs-5 me-2"></i>Treatment Records</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <form action="{{ route('logout') }}" method="POST">
               @csrf

               <button type="submit" class="admin-btn btn text-white"><i
                     class="bi bi-arrow-return-left fs-5 me-2"></i>Logout</button>
            </form>
         </div>
      </div>

      <div class="col border">
         @yield('staffContent')
      </div>

   </div>

</div>
@endsection