@extends('layout.dentist_nav_layout')
@section('title', 'Dentist-treatement-lists')

@section('user_type', 'Hi, ')

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
            <h3>Treatment Records</h3>
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
                  <tr class="p-2">
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">#</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Service</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Patient</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Appointment Date</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Status</th>
                     <th style="background-color:#00a1df !important;" class="p-2 text-white">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($appointments as $appointment)
                  @foreach ($appointment->treatments as $treatment)
                  <tr>
                     <td class="p-2">{{ $appointment->id }}</td>
                     <td class="p-2">{{ $appointment->service->service_name ?? 'N/A' }}</td>
                     <td class="p-2">{{ $appointment->patient->user->first_name ?? 'N/A' }}
                        {{ $appointment->patient->user->last_name ?? '' }}</td>
                     <td class="p-2">{{ $appointment->appointment_date }}</td>
                     <td class="p-2">{{ $appointment->status }}</td>
                     <td class="p-2">
                        <button class="btn btn-sm admin-staff-btn p-1 text-white" data-bs-toggle="modal"
                           data-bs-target="#prescriptionModal{{ $treatment->id }}">
                           Create Prescription
                        </button>
                     </td>
                  </tr>
                  @endforeach
                  @endforeach
               </tbody>
            </table>
            @endif
         </div>
      </div>
   </div>
</div>

{{-- Modal for Prescription --}}
<div class="modal fade" id="prescriptionModal{{ $treatment->id }}" tabindex="-1"
   aria-labelledby="modalLabel{{ $treatment->id }}" aria-hidden="true">
   <div class="modal-dialog">
      <form method="POST" action="{{ route('dentist.prescription.store') }}" class="modal-content">
         @csrf
         <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
         <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">

         <div class="modal-header d-flex justify-content-between">
            <h5 class="modal-title" id="modalLabel{{ $treatment->id }}">
               Create Prescription for {{ $appointment->patient->user->first_name }} {{
               $appointment->patient->user->last_name }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">
            <div class="mb-3">
               <label>Medication</label>
               <input type="text" name="medication" class="form-control" required>
            </div>

            <div class="mb-3">
               <label>Instructions</label>
               <textarea name="instructions" class="form-control" required></textarea>
            </div>
         </div>

         <div class="modal-footer p-2">
            <button type="submit" class="btn admin-staff-btn text-white p-1">Save Prescription</button>
         </div>
      </form>
   </div>
</div>

@endsection