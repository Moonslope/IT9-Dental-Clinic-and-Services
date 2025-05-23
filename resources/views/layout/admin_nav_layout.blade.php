@extends('layout.layout')
@section('title', 'Admin Dashboard')

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
   <div class="row border border-start-0 border-end-0 border-top-0 border-2 sticky">
      <div class="col col-2  d-flex justify-content-center">
         <img class="me-3" height="65" width="65" src="{{ asset('images/final_logo.svg') }}" alt="Clinic Logo">
      </div>

      <div class="col d-flex align-items-center">

         @yield('breadcrumb')

      </div>

      <div class="col d-flex justify-content-end align-items-center pe-3">
         <div>
            <p>Hi, Admin</p>
         </div>

      </div>
   </div>

   <div class="row">
      <div id="sidebar" style="background-color: #1e466b !important; max-height: 559px; overflow-y: auto; width: 250px;"
         class="col-2">
         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.dashboard')}}"><i
                  class="bi bi-house-door fs-5 me-2"></i>Dashboard</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.service')}}"><i class="bi bi-card-list fs-5 me-2"></i>Services</a>
         </div>

         <div class="w-100 mt-3 border border-start-0 border-bottom-0 border-end-0 border-secondary pt-2">
            <p class="text-start ps-1 text-white fw-semibold">PERSONNEL MANAGEMENT</p>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.dentist')}}"><i
                  class="bi bi-people-fill fs-5 me-2 ms-3"></i>Dentists</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.staff')}}"> <i
                  class="bi bi-person-gear fs-5 me-2 ms-3"></i>Staffs</a>
         </div>

         <div class="w-100 mt-3 border border-start-0 border-bottom-0 border-end-0 border-secondary pt-2">
            <p class="text-start ps-1 text-white fw-semibold">PATIENT MANAGEMENT</p>
         </div>

         <div class="pb-2 pt-2 px-2 ">
            <a class="admin-btn" href="{{route('admin.patient')}}"><i
                  class="bi bi-person-lines-fill fs-5 me-2 ms-3"></i>Patients</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{ route('admin.appointment') }}"><i
                  class="bi bi-calendar-week fs-5 me-2 ms-3"></i>Appointments</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{ route('admin.prescriptions') }}"><i class="bi bi-journal-text fs-5 me-2 ms-3"></i></i>Prescriptions</a>
         </div>
         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.treatment')}}"><i
                  class="bi bi-clock-history fs-5 me-2 ms-3"></i>Treatments</a>
         </div>

         <div class="w-100 mt-3 border border-start-0 border-bottom-0 border-end-0 border-secondary pt-2">
            <p class="text-start ps-1 text-white fw-semibold">INVENTORY MANAGEMENT</p>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.supply')}}"><i
                  class="bi bi-box-seam fs-5 me-2 ms-3"></i>Supplies</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.stock_in_history')}}"><i
                  class="bi bi-clock-history fs-5 me-2 ms-3"></i>Stock In History</a>
         </div>

         <div class="pb-2 pt-2 px-2">
            <a class="admin-btn" href="{{route('admin.stock_out')}}"><i
                  class="bi bi-clock-history fs-5 me-2 ms-3"></i>Stock Out History</a>
         </div>

         <div class="pb-2 pt-2 px-2 border border-start-0 border-top-0 border-end-0 pb-2 border-secondary">
            <a class="admin-btn" href="{{route('admin.supplier')}}"><i
                  class="bi bi-people-fill me-2 fs-5 ms-3"></i>Suppliers</a>
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
         @yield('adminContent')
      </div>

   </div>

</div>

<script>
   window.addEventListener('DOMContentLoaded', function () {
      const sidebar = document.getElementById('sidebar');

      if (!sidebar) return;

      // Restore scroll position
      const savedScroll = sessionStorage.getItem('sidebarScroll');
      if (savedScroll !== null) {
         sidebar.scrollTop = parseInt(savedScroll, 10);
      }

      // Save scroll position on page unload
      window.addEventListener('beforeunload', function () {
         sessionStorage.setItem('sidebarScroll', sidebar.scrollTop);
      });
   });
</script>


@endsection