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

<div class="row">
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-warning">
               <i class="bi bi-file-earmark-medical fs-2"></i>
            </div>
            <div class="p-1">
               <p class="fs-5">Treatments Completed</p>
               <p class="fs-3">15</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-success">
               <i class="bi bi-cash fs-2 text-white"></i>
            </div>
            <div class="p-1">
               <p class="fs-5">Revenue Today</p>
               <p class="fs-3">$200</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-plus fs-2 text-white"></i>
            </div>
            <div class="p-1">
               <p class="fs-5">Upcoming Appointments</p>
               <p class="fs-3">5</p>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="row">
   <!-- Other dashboard cards -->
   <div class="col-md-4">
      <div class="card m-2 shadow">
         <div class="card-header">
            <p class="fs-5 mb-0">Services Distribution</p>
         </div>
         <div class="card-body" style="height: 300px;">
            <canvas id="servicesPieChart"></canvas>
         </div>
      </div>
   </div>
</div>


@include('layout.modals.login_success')
<script>
   const pieCtx = document.getElementById('servicesPieChart').getContext('2d');

   const servicesPieChart = new Chart(pieCtx, {
      type: 'pie',
      data: {
         labels: ['Cleaning', 'Tooth Extraction', 'Braces', 'Filling', 'Whitening'], // Services
         datasets: [{
            label: 'Service Count',
            data: [40, 25, 15, 10, 10], // Replace with real data
            backgroundColor: [
               'rgba(255, 99, 132, 0.7)',
               'rgba(54, 162, 235, 0.7)',
               'rgba(255, 206, 86, 0.7)',
               'rgba(75, 192, 192, 0.7)',
               'rgba(153, 102, 255, 0.7)'
            ],
            borderColor: '#fff',
            borderWidth: 1
         }]
      },
      options: {
         responsive: true,
         plugins: {
            legend: {
               position: 'right'
            }
         }
      }
   });
</script>

@endsection