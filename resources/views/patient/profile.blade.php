@extends('layout.layout')
@section('title', 'Profile')

@section('content')
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
   <div class="row h-100">
      <div style="background-color: #1e466b !important" class="col col-3 h-100">
         <div class="row border border-start-0 border-top-0 border-end-0 mx-3 py-3">
            <a style="text-decoration: none;" href="{{route('patient.main')}}"
               class="text-white text-start fw-semibold"><i class="bi bi-arrow-return-left me-2"></i> Back</a>
         </div>

         <div class="row d-flex justify-content-center pt-3">
            <p style="height: 150px; width: 150px;" class="text-center rounded-pill border border-2 text-white">
               pic
               dire
            </p>
         </div>

         <div class="row border border-start-0 border-top-0 border-end-0 mx-3 py-3">
            <p class="fs-5 text-white text-center pt-3 fw-semibold">{{ $patient->user->first_name }} {{
               $patient->user->last_name }}</p>
         </div>

         <div class="d-flex justify-content-start mx-3">
            <button type="button" class="btn text-white fw-semibold mt-3" data-bs-toggle="modal"
               data-bs-target="#appointmentModal"><i class="bi bi-calendar-event me-2 fs-5"></i>Book an
               appointment</button>
         </div>

         <div class="d-flex justify-content-start mx-3">
            {{-- <a style="text-decoration: none;" href="" class="text-white fw-semibold mt-3"><i
                  class="bi bi-box-arrow-left me-2 fs-5"></i>Logout</a> --}}

            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="btn text-white fw-semibold mt-3 bg-none"><i
                     class="bi bi-box-arrow-left me-2 fs-5"></i>Logout</button>
            </form>
         </div>
      </div>

      <div class="col">
         <div class="border border-2 border-start-0 border-top-0 border-end-0 mx-4 py-3">
            <p class="fw-semibold">Information</p>
         </div>

         <div class="row mx-4 pt-5 mb-2">
            <div class="col">
               <p class="fw-semibold">Email</p>
               <p class="text-secondary">{{$patient->user->email}}</p>
            </div>

            <div class="col">
               <p class="fw-semibold">Contact Number</p>
               <p class="text-secondary">{{$patient->user->contact_number}}</p>
            </div>

            <div class="col">
               <p class="fw-semibold">Address</p>
               <p class="text-secondary">{{$patient->user->address}}</p>
            </div>
         </div>

         <div class="row mx-4 pt-5 border border-2 border-start-0 border-top-0 border-end-0 pb-3">
            <div class="col">
               <p class="fw-semibold">Age</p>
               <p class="text-secondary">21</p>
            </div>

            <div class="col pb-4">
               <p class="fw-semibold">Gender</p>
               <p class="text-secondary">Male</p>
            </div>
         </div>

         <div class="row mx-4 pt-3">
            <p class="fw-semibold">Appointment</p>

            {{-- appointment sa patient --}}
            @if ($appointments->isEmpty())
                <p class="text-secondary">You have no appointments scheduled.</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                  @foreach ($appointments as $appointment)
                      <div class="col">
                        <div class="card shadow-sm">
                           <div class="card-body">
                              <h5 class="card-title"> {{ $appointment->service->service_name }}</h5>
                              <p class="card-text"><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                              <p class="card-text"><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                           </div>
                        </div>
                      </div>
                  @endforeach
                </div>
            @endif
         </div>
      </div>
   </div>
</div>



<!-- Modal for appointment -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header d-flex justify-content-between">
            <h1 class="modal-title fs-5" id="appointmentModalLabel">Appointment Form</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form action="">

            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary w-100">Submit Appointment</button>
         </div>
      </div>
   </div>
</div>
@endsection