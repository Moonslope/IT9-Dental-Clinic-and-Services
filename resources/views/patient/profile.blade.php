   @extends('layout.layout')
   @section('title', 'Profile')

   @section('content')
   @include('layout.custom_scrollbar')
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

         <div class="row  pt-3">
            <div class="d-flex justify-content-center">
               <img class="border rounded-pill border-2" src="{{ asset('images/user.png') }}" alt="" width="150"
                  height="150">
            </div>
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

            <div class="d-flex justify content-center-start mx-3">
               <a href="#" onclick="showsection('appointment')" class="btn text-white fw-semibold mt-3 bg-none">Appointments</a>
            </div>

            <div class="d-flex justify content-center-start mx-3">
               <a href="#" onclick="showsection('prescription')" class="btn text-white fw-semibold mt-3 bg-none"><i
                  class="bi bi-envelope me-2 fs-5"></i>Prescriptions</a>
            </div>

            <div class="d-flex justify-content-start mx-3">
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

            {{-- prescription section --}}
            <div id="prescriptionSection" style="display: none;">
               <div class="row mx-4 pt-3">
                  <p class="fw-semibold mb-2">Prescriptions</p>
                  <div style="overflow: hidden;" class="card shadow">
                     <div class="card-body" style="max-height: 230px; overflow-y: auto;">
                        <table class="table">
                           <thead>
                              <tr class="fs-5">
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Dentist</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Service</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Medication</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Instructions</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Date</th>
                                 <th style="background-color:#00a1df !important;" class="text-white p-1">Action</th>
                              </tr>
                           </thead>

                           <tbody>
                              @if ($prescriptions->isEmpty())
                                 <tr>
                                    <td colspan="3" class="text-center text-secondary p-2">You have no prescriptions.
                                    </td>
                                 </tr>
                              @else
                                 @foreach ($prescriptions as $prescription)
                                    <tr>
                                       <td class="p-2">{{ $prescription->treatment->appointment->dentist->user->first_name }} {{ $prescription->treatment->appointment->dentist->user->last_name }}</td>
                                       <td class="p-2">{{ $prescription->treatment->appointment->service->service_name }}</td>
                                       <td class="p-2">{{ $prescription->medication }}</td>
                                       <td class="p-2">{{ $prescription->instructions }}</td>
                                       <td class="p-2">{{ $prescription->created_at->format('F j, Y') }}</td>
                                       <td class="p-2">
                                          <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                             data-bs-target="#printmodal{{ $prescription->id }}">
                                             View
                                          </button>
                                       </td>
                                    </tr>

                                    {{-- print and update modal --}}
                                    <div class="modal fade" id="printmodal{{ $prescription->id }}" tabindex="-1"
                                       aria-labelledby="printModalLabel{{ $prescription->id }}" aria-hidden="true">
                                       <div class="modal-dialog modal-dialog-centered modal-lg">
                                          <div class="modal-content"> 

                                                <div class="modal-header justify-content-between">
                                                   <h5 class="modal-title" id="printModalLabel{{ $prescription->id }}">Prescription
                                                      Details</h5>
                                                   <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                      aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                   <div id="printArea{{ $prescription->id }}" class="p-4"
                                                      style="font-family:Arial, Helvetica, sans-serif">

                                                      <div class="text-center mb-4">
                                                         <img height="65" width="65" src="{{ asset('images/final_logo.svg') }}"
                                                            alt="Clinic logo">
                                                         <h3>Dental Clinic and Services</h3>
                                                         <hr style="border-top:2px solid #000; margin-top:20px;">
                                                      </div>

                                                      <div class="mb-3">
                                                         <p><strong>Date Issued:</strong> {{ $prescription->created_at->format('F j,
                                                            Y') }}</p>
                                                         <p><strong>Dentist:</strong> {{ $prescription->treatment->appointment->dentist->user->first_name }} {{ $prescription->treatment->appointment->dentist->user->last_name }}</p>
                                                         <p><strong>Name:</strong> {{ $prescription->treatment->appointment->patient->user->first_name }} {{
                                                            $prescription->treatment->appointment->patient->user->last_name }}</p>
                                                      </div>

                                                      <div class="mb-3">
                                                         <p><strong>Service:</strong> {{ $prescription->treatment->appointment->service->service_name }}</p>
                                                         <p><strong>Medication:</strong> {{ $prescription->medication }}</p>
                                                         <p><strong>Instructions:</strong> {{ $prescription->instructions }}</p>
                                                         <p><strong>Appointment Date:</strong> {{ $prescription->treatment->appointment->created_at->format('F
                                                            j, Y') }}</p>
                                                      </div>

                                                      <div class="row text-end mt-5">
                                                         <p>__________________________</p>
                                                            <div class="pe-5">
                                                               <p>Dr. {{ $prescription->treatment->appointment->dentist->user->first_name }} {{ $prescription->treatment->appointment->dentist->user->last_name }}</p>
                                                            </div>
                                                      </div>
                                                   </div>
                                                   
                                                </div>

                                                <div class="modal-footer justify-content-between gap-2">
                                                   <div class="col">
                                                      <button class="btn btn-secondary w-100" type="button"
                                                         onclick="printDiv('printArea{{ $prescription->id }}')">Print</button>
                                                   </div>
                                                </div>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 @endforeach
                              @endif
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>

            {{-- appointment section --}}
            <div id="appointmentSection">
               <div class="row mx-4 pt-3">
                  <p class="fw-semibold mb-2">Appointment</p>
                  <div style="overflow: hidden;" class="card shadow">
                     <div class="card-body" style="max-height: 230px; overflow-y: auto;">
                        <table class="table">
                           <thead>
                              <tr class="fs-5">
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Service</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Date</th>
                                 <th style="background-color:#00a1df !important;" class="p-1 text-white">Status</th>
                                 <th style="background-color:#00a1df !important;" class="text-white p-1">Action</th>
                              </tr>
                           </thead>

                           <tbody>
                              @if ($appointments->isEmpty())
                              <tr>
                                 <td colspan="3" class="text-center text-secondary p-2">You have no appointments scheduled.
                                 </td>
                              </tr>
                              @else

                              @foreach ($appointments as $appointment)
                              <tr>
                                 <td class="p-2">{{ $appointment->service->service_name }}</td>
                                 <td class="p-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d,
                                    Y h:i A') }}
                                 </td>
                                 <td class="p-2">
                                    @if ($appointment->status === 'Approved')
                                    <span style="padding-inline: 15px !important;"
                                       class="bg-info fw-semibold  rounded-pill text-white py-1">{{
                                       ($appointment->status)
                                       }}</span>
                                    @elseif ($appointment->status === 'Completed')
                                    <span style="padding-inline: 10px !important;"
                                       class="bg-success fw-semibold rounded-pill text-white py-1">{{
                                       ($appointment->status)
                                       }}</span>
                                    @else
                                    <span style="padding-inline: 20px !important;"
                                       class="bg-warning fw-semibold rounded-pill text-white py-1">{{
                                       ($appointment->status)
                                       }}</span>
                                    @endif
                                 </td>

                                 <td class="col-2">
                                    @if($appointment->status === 'Pending')
                                    <div class="d-flex align-items-center gap-2">
                                       <button style="padding-inline: 23px !important;"
                                          class="btn admin-staff-btn text-white mt-2 rounded-pill" data-bs-toggle="modal"
                                          data-bs-target="#editAppointmentModal-{{ $appointment->id }}">
                                          EDIT
                                       </button>

                                       <div class="modal fade" id="editAppointmentModal-{{ $appointment->id }}" tabindex="-1"
                                          aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">
                                             <div class="modal-content">
                                                <div class="modal-header d-flex justify-content-between align-items-center">
                                                   <h3 class="pb-2">Edit Appointment</h3>
                                                   <button class="btn-close pb-2" type="button" data-bs-dismiss="modal"
                                                      aria-label="close"></button>
                                                </div>

                                                {{-- edit appointment --}}
                                                <div class="modal-body mt-4">
                                                   <form action="{{ route('appointments.patient_update', $appointment->id) }}"
                                                      method="POST">
                                                      @csrf
                                                      @method('PUT')

                                                      <div class="row gap-2 mb-2">
                                                         <div class="col">
                                                            <label for="services" class="mb-1 fw-semibold">Services</label>
                                                            <select style="background-color: #d9d9d9" name="service_id"
                                                               id="services" class="form-select p-2" required>
                                                               @if ($services->isEmpty())
                                                               <option value="" disabled>No services available</option>
                                                               @else
                                                               <option value="" disabled>Select a service</option>
                                                               @foreach ($services as $service)
                                                               <option value="{{ $service->id }}" {{ $appointment->service_id
                                                                  == $service->id ? 'selected' : '' }}>
                                                                  {{ $service->service_name }}
                                                               </option>
                                                               @endforeach
                                                               @endif
                                                            </select>
                                                         </div>

                                                         <div class="col">
                                                            <label class="mb-1 fw-semibold">Appointment Date</label>
                                                            <input type="datetime-local" name="appointment_date"
                                                               class="form-control p-2"
                                                               value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                                                               style="background-color: #d9d9d9" required>
                                                         </div>
                                                      </div>

                                                      <div class="row mt-3">
                                                         <button class="btn w-100 admin-staff-btn fw-bold text-white p-1"
                                                            type="submit">Update
                                                            Appointment</button>
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                       </div>


                                       <button type="submit" class="btn admin-staff-btn text-white mt-2 rounded-pill me-1"
                                          data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$appointment->id}}">
                                          <i class="bi bi-trash-fill px-4"></i>
                                       </button>

                                       <!-- Confirmation Modal -->
                                       <div class="modal fade" id="confirmDeleteModal{{$appointment->id}}" tabindex="-1"
                                          aria-labelledby="confirmDeleteModalLabel{{$appointment->id}}" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                             <div class="modal-content">
                                                <div class="modal-header d-flex justify-content-between">
                                                   <h4 class="modal-title">Confirm Deletion</h4>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                      aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                   <p class="my-4 fs-5 text-center">Are you sure you want to delete this
                                                      appointment?</p>
                                                </div>

                                          <div class="modal-footer row mt-3 gap-2 pt-3">
                                             <div class="col">
                                                <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                                   data-bs-dismiss="modal">Cancel</button>
                                             </div>
                                             <div class="col">
                                                <form action="{{ route('appointments.destroy', $appointment->id) }}"
                                                   method="POST" class="d-inline">
                                                   @csrf
                                                   @method('DELETE')
                                                   <button type="submit"
                                                      class="btn btn-danger w-100 text-white p-1">Delete</button>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                                    @elseif($appointment->status === 'Approved')
                                    <button style="padding-inline: 20px !important;"
                                       class="btn admin-staff-btn text-white mt-2 rounded-pill" data-bs-toggle="modal"
                                       data-bs-target="#viewModal{{ $appointment->id }}">
                                       VIEW
                                    </button>

                                    {{-- approved view modal --}}
                                    <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1"
                                       aria-labelledby="viewModalLabel{{ $appointment->id }}" aria-hidden="true">
                                       <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                             <div class="modal-header d-flex justify-content-between">
                                                <h5 class="modal-title" id="viewModalLabel">Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                   aria-label="Close"></button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="row gap-2 mt-3">
                                                   <div class="col">
                                                      <label for="service" class="mb-2">Service</label>
                                                      <input type="text" readonly id="service"
                                                         value="{{$appointment->service->service_name}}"
                                                         class="form-control p-2">
                                                   </div>

                                                   <div class="col">
                                                      <label for="date" class="mb-2">Appointment Date</label>
                                                      <input type="text" readonly id="date"
                                                         value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y h:i A') }}"
                                                         class="form-control p-2">
                                                   </div>
                                                </div>

                                                <div class="row mt-3 mb-2">
                                                   <div class="col">
                                                      <label for="dentist" class="mb-2">Dentist Assigned</label>
                                                      <input type="text" readonly id="dentist"
                                                         value="{{$appointment->dentist->user->first_name}} {{$appointment->dentist->user->last_name}}"
                                                         class="form-control p-2">
                                                   </div>
                                                </div>

                                             </div>
                                             <div class="modal-footer p-1">
                                                <button type="button" class="btn admin-staff-btn p-1 text-white w-100"
                                                   data-bs-dismiss="modal">Close</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>


                                    @elseif($appointment->status === 'Completed')
                                    <button style="padding-inline: 20px !important;"
                                       class="btn admin-staff-btn text-white mt-2 rounded-pill" data-bs-toggle="modal"
                                       data-bs-target="#viewModal{{ $appointment->id }}">
                                       VIEW
                                    </button>

                                    {{-- completed view modal --}}
                                    <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1"
                                       aria-labelledby="viewModalLabel{{ $appointment->id }}" aria-hidden="true">
                                       <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                             <div class="modal-header d-flex justify-content-between">
                                                <h5 class="modal-title" id="viewModalLabel">Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                   aria-label="Close"></button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="row gap-2 mt-3">
                                                   <div class="col">
                                                      <label for="service" class="mb-2">Service</label>
                                                      <input type="text" readonly id="service"
                                                         value="{{ $appointment->service->service_name }}"
                                                         class="form-control p-2">
                                                   </div>

                                                   <div class="col">
                                                      <label for="date" class="mb-2">Appointment Date</label>
                                                      <input type="text" readonly id="date"
                                                         value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y h:i A') }}"
                                                         class="form-control p-2">
                                                   </div>
                                                </div>

                                                <div class="row gap-2 mt-3">
                                                   <div class="col">
                                                      <label for="amount_paid" class="mb-2">Amount Paid</label>
                                                      <input type="text" readonly id="amount_paid"
                                                         value="₱ {{ $appointment->treatments->first()->treatment_cost ?? 'N/A' }}"
                                                         class="form-control p-2">
                                                   </div>

                                                   <div class="col">
                                                      <label for="status" class="mb-2">Status</label>
                                                      <input type="text" readonly id="status"
                                                         value="{{ $appointment->status }}" class="form-control p-2">
                                                   </div>
                                                </div>

                                                <div class="row mt-3 mb-2">
                                                   <div class="col">
                                                      <label for="dentist" class="mb-2">Dentist Assigned</label>
                                                      <input type="text" readonly id="dentist"
                                                         value="{{ $appointment->dentist->user->first_name }} {{ $appointment->dentist->user->last_name }}"
                                                         class="form-control p-2">
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="modal-footer p-1">
                                                <button type="button" class="btn admin-staff-btn p-1 text-white w-100"
                                                   data-bs-dismiss="modal">Close</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    @endif
                                 </td>
                              </tr>
                              @endforeach
                              @endif
                           </tbody>
                        </table>
                     </div>
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
               <form action="{{ route('patient.appointments.store') }}" method="POST">
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
                        style="background-color: #d9d9d9" readonly>
                  </div>

                  <div class="col">
                     <label for="last_name" class="mb-1  fw-semibold">Last Name</label>
                     <input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control p-2"
                        value="{{ Auth::check() ? Auth::user()->last_name : '' }}" style="background-color: #d9d9d9"
                        readonly>
                  </div>
               </div>

               <div class="row mb-2 gap-2">
                  <div class="col">
                     <label for="email" class="mb-1  fw-semibold">Email</label>
                     <input type="email" id="email" name="email" placeholder="Email" class="form-control p-2"
                        value="{{ Auth::check() ? Auth::user()->email : '' }}" style="background-color: #d9d9d9"
                        readonly>
                  </div>

                  <div class="col">
                     <label for="contact_number" class="mb-1  fw-semibold">Contact Number</label>
                     <input type="tel" id="contact_number" name="contact_number"
                        placeholder="Phone number: +63 9XXXXXXXXX" class="form-control p-2"
                        style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$" readonly
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

   @include('layout.modals.appointment_success')

   <script>
      function showsection(section) {

         localStorage.setItem('activeSection', section)
         // Hide all sections
         document.getElementById('appointmentSection').style.display = 'none';
         document.getElementById('prescriptionSection').style.display = 'none';
         
         // Show the selected section
         if (section === 'appointment') {
            document.getElementById('appointmentSection').style.display = 'block';
         } else if (section === 'prescription') {
            document.getElementById('prescriptionSection').style.display = 'block';
         }
      }

      document.addEventListener('DOMContentLoaded', function(){
         const lastSection = localStorage.getItem('activeSection') || 'appointment';
         showsection(lastSection);
      })

      function printDiv(divId) {
         const printContents = document.getElementById(divId).innerHTML;
         const originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;
         window.print();
         document.body.innerHTML = originalContents;
         location.reload();
      }
   </script>
   @include('layout.modals.crud_success')
@endsection