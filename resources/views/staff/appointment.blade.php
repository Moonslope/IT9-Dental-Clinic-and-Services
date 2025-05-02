@extends('layout.staff_nav_layout')

@section('title', 'Appointment Lists')
@section('user_type', 'Hi, Staff')
@section('breadcrumb')
<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Appointments</span>
</div>
@endsection

@section('staffContent')


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
            <table>
               <thead>
                  <tr style="background-color: #00a1df; color: white; font-size: 16px;" class="custom-header">
                     <th class="p-2 col-1">#</th>
                     <th class="p-2 col-1">Service</th>
                     <th class="p-2 col-2">Patient</th>
                     <th class="p-2 col-1">Dentist</th>
                     <th class="p-2 col-2">Appointment date</th>
                     <th class="p-2 col-2">Submitted date</th>
                     <th class="p-2 col-1">Status</th>
                     <th class="p-2 col-2">Actions</th>
                  </tr>
               </thead>

               @if ($appointments->isEmpty())
                   <p class="alert text-center text-secondary">No more appointments</p>
               @else
               <div style="max-height: 380px; overflow-y:auto; overflow-x:hidden">
                  <table class="table table-bordered">
                     <tbody>
                        @foreach ($appointments as $appointment)
                           <tr style="font-size: 16px;" class="bg-secondary">
                              <td class="p-2 col-1">{{ $appointment->id }}</td>
                              <td class="p-2 col-1">{{ $appointment->service->service_name ?? 'N/A' }}</td>
                              <td class="p-2 col-2">{{ $appointment->patient->user->first_name ?? 'N/A' }} {{ $appointment->patient->user->last_name }}</td>
                              <td class="p-2 col-1">{{ $appointment->dentist->user->first_name ?? 'N/A' }}</td>
                              <td class="p-2 col-2">{{ $appointment->appointment_date }}</td>
                              <td class="p-2 col-2">{{ $appointment->created_at->format('F j, Y') }}</td>
                              <td class="p-2 col-1">{{ $appointment->status }}</td>
                              <td class="p-2 col-2">
                                 <div class="d-flex justify-content-evenly gap-2">
                                    <div>
                                       <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmAppointmentModal{{ $appointment->id }}">Edit</button>
                                    </div>
                                    
                                    <div>
                                       <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal" data-bs-target="#confirmAppointmentModal">Proceed to treatment</button>
                                    </div>
                                 </div>
                              </td>
                           </tr>

{{-- Modal for Approving an appointment --}}
<div class="modal fade" id="confirmAppointmentModal" tabindex="-1" aria-labelledby="confirmAppointmentModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">

      <div class="modal-content">
         <div class="modal-header justify-content-end">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
         </div>
         <h2>Schedule your visit with ease</h2>

         <div class="modal-body mt-3">
            <form action="{{ route('staff.appointments.update', $appointment->id) }}" method="POST">
               @csrf
               @method('PUT')

               <div class="row mb-2">
                  <select name="dentist_id" id="dentist_id" class="form-select" style="background-color: #d9d9d9">
                     <option value="" disabled selected>Select a dentist</option>
                     @foreach ($dentists as $dentist)
                     <option class="text-dark" value="{{ $dentist->id }}" {{ $appointment->dentist_id == $dentist->id ?
                        'selected': '' }}>
                        {{ $dentist->user->first_name }} {{ $dentist->user->last_name }}
                     </option>
                     @endforeach
                  </select>
               </div>

               <div class="row gap-2 mb-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" name="service_name" id="service_name"
                        class="form-control" readonly value="{{ $appointment->service->service_name }}">
                  </div>

                  {{-- Appointment Date --}}
                  <div class="col">
                     <input type="text" id="appointment_date" name="appointment_date" class="form-control"
                        style="background-color: #d9d9d9" value="{{ $appointment->appointment_date }}" required>
                  </div>
               </div>

               {{-- User Details --}}
               <div class="row mb-2">
                  <input type="text" id="name" name="name" placeholder="Name" class="form-control"
                     style="background-color: #d9d9d9"
                     value="{{ Auth::user()->first_name ?? ''}} {{ Auth::user()->last_name ?? '' }}" required>
               </div>

               <div class="row mb-2">
                  <input type="email" id="email" name="email" placeholder="Email" class="form-control"
                     style="background-color: #d9d9d9" value="{{ Auth::user()->email ?? '' }}" required>
               </div>

               <div class="row mb-2">
                  <input type="tel" id="phone" name="phone" placeholder="Phone number: +63 9XXXXXXXXX"
                     class="form-control" style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$"
                     value="{{ Auth::user()->contact_number ?? '' }}" required>
               </div>

               {{-- Optional Messege --}}
               <div class="row mb-3">
                  <input type="checkbox" name="status" value="1" {{ $appointment->status === 'Approved' ? 'checked' :
                  ''}}>
                  <label for="status">Approve Appointment</label>
               </div>

               {{-- Submit Button --}}
               <div class="row">
                  <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                     type="submit">Approve Appointment</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection