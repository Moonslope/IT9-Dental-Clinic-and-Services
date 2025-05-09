@extends('layout.layout')
@section('title', 'Dentist Dashboard')

@section('content')
@include('layout.custom_scrollbar')
<style>
   .modal-dialog {
      margin: auto !important;
   }

   .modal,
   .modal-dialog,
   .modal-content {
      padding: 15px !important;
   }
</style>
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

   <div style="height: 559px !important;" class="row">
      <div style="background-color: #1e466b !important;" class="col-2">
         <div class="pb-2 pt-2 px-2 ">
            <a class="admin-btn" href="{{route('dentist.dashboard')}}"><i
                  class="bi bi-house-door fs-5 me-2"></i>Dashboard</a>
         </div>

         <div class="w-100 mt-3 border border-start-0 border-bottom-0 border-end-0 border-secondary pt-2">
            <p class="text-start ps-1 text-white fw-semibold">PATIENT MANAGEMENT</p>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{ route('dentist.appointments') }}"><i
                  class="bi bi-calendar-week fs-5 me-2 ms-3"></i>Appointments</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{ route('dentist.prescription') }}"><i class="bi bi-journal-text fs-5 me-2 ms-3"></i></i>Prescriptions</a>
         </div>
         <div class="pb-2 pt-2 px-2 border border-start-0 border-top-0 border-end-0 border-secondary">
            <a class="admin-btn" href="{{ route('dentist.treatmentRecords') }}"><i class="bi bi-clock-history fs-5 me-2 ms-3"></i>Treatment Records</a>
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
         @yield('dentistContent')
      </div>

   </div>

</div>
@endsection