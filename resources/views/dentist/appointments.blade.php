@extends('layout.dentist_nav_layout')

@section('title', 'Dentist Dashboard')

@section('user_type', 'Hi, ' . $dentist->first_name . ' ' . $dentist->last_name)

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Appointments</span>
</div>

@endsection

@section('dentistContent')

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

<div class="row m-2">
   <div class="card shadow">
      <div class="card-body d-flex justify-content-between">
         <div class="row w-100 p-3 gap-3">
            <h3>Appointment lists</h3>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div class="card" style="overflow:hidden">
      <div class="card-body">
         <div class="row">
            @if ($appointments->isEmpty())
            <p class="alert text-center text-secondary">No appointments assigned to you.</p>
            @else
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Service</th>
                     <th>Patient</th>
                     <th>Appointment Date</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($appointments as $appointment)
                  <tr>
                     <td>{{ $appointment->id }}</td>
                     <td>{{ $appointment->service->service_name ?? 'N/A' }}</td>
                     <td>{{ $appointment->patient->user->first_name ?? 'N/A' }} {{
                        $appointment->patient->user->last_name ?? '' }}</td>
                     <td>{{ $appointment->appointment_date }}</td>
                     <td>{{ $appointment->status }}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection