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

<div class="container mt-4">
   <h3>Appointments</h3>
   <table class="table table-bordered">
      <thead>
         <tr>
            <th>#</th>
            <th>Service</th>
            <th>Patient</th>
            <th>Dentist</th>
            <th>Appointment Date</th>
            <th>Submitted Date</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($appointments as $appointment)
         <tr>
            <td>{{ $appointment->id }}</td>
            <td>{{ $appointment->service->service_name ?? 'N/A' }}</td>
            <td>{{ $appointment->patient->user->first_name ?? 'N/A' }} {{ $appointment->patient->user->last_name }}</td>
            <td>{{ $appointment->dentist->user->first_name ?? 'N/A' }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <td>{{ $appointment->created_at->format('F j, Y') }}</td>
            <td>{{ $appointment->status }}</td>
            <td>
               <button class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" data-bs-toggle="modal"
                  data-bs-target="#confirmAppointmentModal">Edit</button>
               <a href="#" class="btn btn-danger btn-sm">Cancel</a>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>

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