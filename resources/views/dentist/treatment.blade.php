@extends('layout.dentist_nav_layout')
@section('title', 'Dentist-treatment-lists')

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
    .modal-backdrop.show {
        opacity: 0.5;
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
                     <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Patient</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($appointments as $appointment)
                        @foreach ($appointment->treatments as $treatment)
                           <tr>
                              <td>{{ $appointment->id }}</td>
                              <td>{{ $appointment->service->service_name ?? 'N/A' }}</td>
                              <td>{{ $appointment->patient->user->first_name ?? 'N/A' }} {{ $appointment->patient->user->last_name ?? '' }}</td>
                              <td>{{ $appointment->appointment_date }}</td>
                              <td>{{ $appointment->status }}</td>
                              <td>
                                 <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#prescriptionModal{{ $treatment->id }}">
                                    Create Prescription
                                 </button>
                              </td>
                           </tr>

                           <div class="modal fade" id="prescriptionModal{{ $treatment->id }}" tabindex="-1" aria-labelledby="prescriptionModalLabel{{ $treatment->id }}" aria-hidden="true">

                              <div class="modal-dialog modal-dialog-centered">
                                 <div class="modal-content">

                                    <form action="{{ route('dentist.treatment.store') }}" method="POST">
                                       @csrf

                                          <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
                                          <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">

                                          <div class="modal-header justify-content-between">
                                             <h5 class="modal-title" id="modalLabel{{ $treatment->id }}">
                                                Create Prescription for {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }} ({{ $appointment->service->service_name ?? 'N/A' }})
                                             </h5>
                                             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close">
                                             </button>
                                          </div>

                                          <div class="modal-body mt-3">
                                             <div class="mb-3">
                                                <label class="form-label">Medication</label>
                                                <input type="text" name="medication" class="form-control" style="background-color: #d9d9d9" required>
                                             </div>
                                          </div>

                                          <div class="mb-3">
                                             <label class="form-label">Instructions</label>
                                             <textarea name="instructions" class="form-control" rows="4" style="background-color: #d9d9d9" required></textarea>
                                          </div>

                                       <div class="modal-footer">
                                          <button type="submit" class="btn btn-success">Save Prescription</button>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     @endforeach
                  </tbody>
               </table>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection
