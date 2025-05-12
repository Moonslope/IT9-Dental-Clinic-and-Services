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
<div style="max-height: 550px !important; overflow-y: auto;">
   <div class="row ps-3 py-3">
      <h2 class="">Dashboard Overview</h2>
   </div>

   <div class="row mb-3">
      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-info">
                  <i class="bi bi-calendar-event fs-2 me-2 text-white"></i>
               </div>

               <div class="p-1">
                  <p class="fs-5">Appointments Today</p>
                  <p class="fs-3">{{$todayAppointments}}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-warning">
                  <i class="bi bi-hourglass-split fs-2"></i>
               </div>
               <div class="p-1">
                  <p class="fs-5">Pending Appointments</p>
                  <p class="fs-3">{{$pendingAppointments}}</p>
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
                  <p class="fs-3">{{$upcomingAppointments}}</p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row mb-3">
      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-primary">
                  <i class="bi bi-person-lines-fill fs-2 text-white"></i>
               </div>
               <div class="p-1">
                  <p class="fs-5">Patients</p>
                  <p class="fs-3">{{$totalPatients}}</p>
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
                  <p class="fs-5">Staffs</p>
                  <p class="fs-3">{{$totalStaffs}}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-primary">
                  <i class="bi bi-people-fill fs-2 text-white"></i>
               </div>

               <div class="p-1">
                  <p class="fs-5">Dentists</p>
                  <p class="fs-3">{{$totalDentists}}</p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row mb-3">
      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-success">
                  <i class="bi bi-list-check fs-2 text-white"></i>

               </div>
               <div class="p-1">
                  <p class="fs-5">Completed Appointments</p>
                  <p class="fs-3">{{$completedAppointments}}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-primary">
                  <i class="bi bi-person-lines-fill fs-2 text-white"></i>
               </div>
               <div class="p-1">
                  <p class="fs-5">Total Services</p>
                  <p class="fs-3">{{$totalServices}}</p>
               </div>
            </div>
         </div>
      </div>

   </div>

   <div class="row">
      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-success">
                  <i class="bi bi-box-fill fs-2 text-white"></i>
               </div>

               <div class="p-1">
                  <p class="fs-5">Supplies</p>
                  <p class="fs-3">{{$totalSupplies}}</p>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div class="d-flex gap-2">
               <div class="d-flex justify-content-center align-items-center px-4 bg-primary">
                  <i class="bi bi-people-fill fs-2 text-white"></i>
               </div>

               <div class="p-1">
                  <p class="fs-5">Supplier</p>
                  <p class="fs-3">{{$totalSuppliers}}</p>
               </div>
            </div>
         </div>
      </div>

   </div>

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <div class="row mt-4">
      <hr>
      <div class="col">
         <div class="row ps-3 py-2">
            <h3 class=" p-2">Revenue Trends</h3>
         </div>
         <div class="card m-2 shadow" style="overflow: hidden;">
            <div style="height: 310px !important;" class="card-body p-1">
               <canvas id="revenueChart" style="max-height: 350px;"></canvas>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="row ps-3 py-2">
            <h3 class=" p-2">Services Distribution</h3>
         </div>
         <div class="card m-2 shadow p-0">
            <div class="card-body p-1">
               <canvas id="servicesPieChart" style="max-height: 300px;"></canvas>
            </div>
         </div>
      </div>
   </div>

   @include('layout.modals.login_success')
   @include('layout.revenue')

</div>
@endsection