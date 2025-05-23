@extends('layout.dentist_nav_layout')

@section('title', 'Appointments')

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
            <div class="col">
               <h3>Appointment lists</h3>
            </div>

            <div class="col">
               <div>
                  <form action="{{ route('dentist.appointments') }}" method="GET" class="mb-3">
                     <div class="d-flex w-100 gap-2">
                        <input type="text" name="search" class="form-control p-1" placeholder="Search"
                           value="{{ request('search') }}">
                        <button type="submit" class="btn admin-staff-btn"><i
                              class="bi bi-search fs-5 p-2 text-white"></i></button>
                     </div>
                  </form>
               </div>
            </div>
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
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">#</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Service</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Patient</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Appointment Date</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Status</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($appointments as $appointment)
                  <tr>
                     <td class="p-2">{{ $appointment->id }}</td>
                     <td class="p-2">{{ $appointment->service->service_name ?? 'N/A' }}</td>
                     <td class="p-2">{{ $appointment->patient->user->first_name ?? 'N/A' }} {{
                        $appointment->patient->user->last_name ?? '' }}</td>
                     <td class="p-2">{{ $appointment->appointment_date }}</td>
                     <td class="p-2">
                        @if ($appointment->status === 'Approved')
                        <span style="padding-inline: 16px !important; padding-block: 3px !important;"
                           class="bg-info fw-semibold  rounded-pill">{{
                           ($appointment->status)
                           }}</span>
                        @elseif ($appointment->status === 'Completed')
                        <span style="padding-inline: 12px !important; padding-block: 3px !important;"
                           class="bg-success fw-semibold rounded-pill text-white">{{
                           ($appointment->status)
                           }}</span>
                        @elseif ($appointment->status === 'Ongoing')
                        <span style="padding-inline: 20px !important; padding-block: 3px !important;"
                           class="bg-primary fw-semibold rounded-pill text-white pb-1">{{
                           ($appointment->status)
                           }}</span>
                        @elseif ($appointment->status === 'Declined')
                        <span style="padding-inline: 20px !important; padding-block: 3px !important;"
                           class="bg-danger fw-semibold rounded-pill text-white">{{
                           ($appointment->status)
                           }}</span>
                        @else
                        <span style="padding-inline: 22px !important; padding-block: 3px !important;"
                           class="bg-warning fw-semibold rounded-pill">{{
                           ($appointment->status)
                           }}</span>
                        @endif
                     </td>
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