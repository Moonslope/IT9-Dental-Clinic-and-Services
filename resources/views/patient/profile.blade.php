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
               data-bs-target="#bookAppointmentModal"><i class="bi bi-calendar-event me-2 fs-5"></i>Book an
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
         <div class="border border-2 border-start-0 border-top-0 border-end-0 mx-4 py-3 d-flex justify-content-between">
            <p class="fw-semibold">Information</p>

            <button class="btn admin-staff-btn text-white px-2 py-1" data-bs-toggle="modal"
               data-bs-target="#editPatientModal{{$user->id}}"><i class="bi bi-pencil-square"></i></button>

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
               <p class="text-secondary">{{$user->patient->age}}</p>
            </div>

            <div class="col pb-4">
               <p class="fw-semibold">Gender</p>
               <p class="text-secondary">{{$user->patient->gender}}</p>
            </div>
         </div>

         <div class="row mx-4 pt-3">
            <p class="fw-semibold mb-2">Appointment</p>
            <div style="overflow: hidden;" class="card shadow">
               <div style="height: 230px !important;" class="card-body">
                  <table class="table">
                     <thead>
                        <tr class="fs-5">
                           <th style="background-color:#00a1df !important;" class="p-1 text-white">Service</th>
                           <th style="background-color:#00a1df !important;" class="p-1 text-white">Date</th>
                           <th style="background-color:#00a1df !important;" class="p-1 text-white">Status</th>
                        </tr>
                     </thead>

                     <tbody>
                        @if ($appointments->isEmpty())
                        <p class="text-secondary">You have no appointments scheduled.</p>
                        @else
                        @foreach ($appointments as $appointment)
                        <tr>
                           <td class="p-1">{{ $appointment->service->service_name }}</td>
                           <td class="p-1">{{ $appointment->appointment_date }}</td>
                           <td class="p-1">{{ ucfirst($appointment->status) }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



{{-- Modal for booking an appointment --}}
<div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">
      <div class="modal-content">
         <div class="modal-header d-flex justify-content-between align-items-center">
            <h3 class="pb-2">Appointment Form</h3>
            <button class="btn-close pb-2" type="button" data-bs-dismiss="modal" aria-label="close"></button>
         </div>

         <div class="modal-body mt-4">
            <form action="{{ route('appointments.store') }}" method="POST">
               @csrf

               <div class="row gap-2 mb-2">
                  <div class="col">
                     <label for="services" class="mb-1  fw-semibold">Services</label>
                     <select style="background-color: #d9d9d9" name="service_id" id="services" class="form-select p-2"
                        required>
                        @if ($services->isEmpty())
                        <option value="" disabled>No services available</option>
                        @else
                        <option value="" disabled selected>Select a service</option>
                        @foreach ($services as $service)
                        <option name="service_id" value="{{ $service->id }}">{{ $service->service_name }}</option>
                        @endforeach
                        @endif
                     </select>
                  </div>
                  <div class="col">
                     <label for="appointmentDate" class="mb-1  fw-semibold">Date and Time</label>
                     <input type="datetime-local" id="appointmentDate" name="appointment_date" class="form-control p-2"
                        style="background-color: #d9d9d9" required>
                  </div>
               </div>

               <div class="row mb-2 gap-2">
                  <div class="col">
                     <label for="first_name" class="mb-1  fw-semibold">First Name</label>
                     <input type="text" id="first_name" name="first_name" placeholder="First Name"
                        class="form-control p-2" value="{{ Auth::check() ? Auth::user()->first_name : '' }}"
                        style="background-color: #d9d9d9" required>
                  </div>

                  <div class="col">
                     <label for="last_name" class="mb-1  fw-semibold">Last Name</label>
                     <input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control p-2"
                        value="{{ Auth::check() ? Auth::user()->last_name : '' }}" style="background-color: #d9d9d9"
                        required>
                  </div>
               </div>

               <div class="row mb-2 gap-2">
                  <div class="col">
                     <label for="email" class="mb-1  fw-semibold">Email</label>
                     <input type="email" id="email" name="email" placeholder="Email" class="form-control p-2"
                        value="{{ Auth::check() ? Auth::user()->email : '' }}" style="background-color: #d9d9d9"
                        required>
                  </div>

                  <div class="col">
                     <label for="contact_number" class="mb-1  fw-semibold">Contact Number</label>
                     <input type="tel" id="contact_number" name="contact_number"
                        placeholder="Phone number: +63 9XXXXXXXXX" class="form-control p-2"
                        style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$" required
                        value="{{ Auth::check() ? Auth::user()->contact_number : '' }}">
                  </div>
               </div>

               <div class="row mb-3">
                  <label for="message" class="mb-1  fw-semibold">Message</label>
                  <textarea name="message" id="message" class="form-control" cols="30" rows="4" placeholder="(Optional)"
                     style="background-color: #d9d9d9"></textarea>

               </div>

               <div class="row">
                  <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                     type="submit">Submit Appointment</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


{{-- edit --}}
<div class="modal fade" id="editPatientModal{{$user->id}}" tabindex="-1"
   aria-labelledby="editPatientModalLabel{{$user->id}}" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content">
         <div class="modal-header fw-semibold d-flex justify-content-between">
            <h5 class="modal-title" id="editPatientModalLabel{{$user->id}}">Update Information Details</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">

            <form action="{{route('patient.update', ['user' => $user])}}" method="POST">
               @csrf
               @method('PUT')
               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="first_name" name="first_name"
                        class="form-control p-2" value="{{ $user->first_name }}">
                  </div>

                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="last_name" name="last_name"
                        class="form-control p-2" value="{{ $user->last_name }}">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="numeric" id="age" name="age"
                        class="form-control p-2" value="{{$user->patient->age}}" placeholder="Age">
                  </div>

                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="gender" name="gender"
                        class="form-control p-2" value="{{$user->patient->gender}}" placeholder="Gender">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="email" id="email" name="email"
                        class="form-control p-2" value="{{ $user->email }}">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                        class="form-control p-2" value="{{ $user->address }}">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="contact_number" name="contact_number"
                        class="form-control p-2" value="{{ $user->contact_number }}">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="password" id="password" name="password"
                        class="form-control p-2" placeholder="Enter new password (optional)">
                  </div>
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>
                  <div class="col">
                     {{-- <input type="hidden" name="redirect_to" value="{{ $redirect_route }}"> --}}
                     <button class="btn admin-staff-btn  w-100 fw-bold text-white p-1" type="submit">Save
                        changes</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection