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
<div class="mb-4">
   <h1 class="h3">Welcome, Admin!</h1>
   <p class="text-muted">Here's what's happening at your dental clinic today:</p>
   <div class="row">
      <div class="col-md-4">
         <div class="card p-3">
            <h5>Appointments Today</h5>
            <p class="display-6">12</p>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card p-3">
            <h5>New Patients</h5>
            <p class="display-6">3</p>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card p-3">
            <h5>Services Booked</h5>
            <p class="display-6">8</p>
         </div>
      </div>
   </div>
</div>




@endsection