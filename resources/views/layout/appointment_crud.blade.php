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
            <div class="col col-4">
               <h3>Appointment lists</h3>
            </div>

            <div class="col">
               <div class="d-flex w-75 gap-2">
                  <input type="text" id="search" class="form-control" placeholder=" Search">
                  <button class="btn admin-staff-btn"><i class="bi bi-search fs-5 p-2 text-white"></i></button>
               </div>
            </div>

            <div class="col col-1">
               <button class="btn admin-staff-btn w-100 p-1 text-white" data-bs-toggle="modal"
                  data-bs-target="#bookAppointmentModal">ADD <i class="ms-2 bi bi-plus-circle-fill"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div class="card" style="overflow:hidden">
      <div style="height: 465px !important; " class="card-body">
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
            </table>

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
                        <td class="p-2 col-2">{{ $appointment->patient->user->first_name ?? 'N/A' }} {{
                           $appointment->patient->user->last_name }}</td>
                        <td class="p-2 col-1">{{ $appointment->dentist->user->first_name ?? 'N/A' }}</td>
                        <td class="p-2 col-2">{{ $appointment->appointment_date }}</td>
                        <td class="p-2 col-2">{{ $appointment->created_at->format('F j, Y') }}</td>
                        <td class="p-2 col-1">
                           @if ($appointment->status === 'Approved')
                           <span style="padding-inline: 15px !important;" class="bg-info fw-semibold  rounded-pill">{{
                              ($appointment->status)
                              }}</span>
                           @elseif ($appointment->status === 'Completed')
                           <span style="padding-inline: 10px !important;"
                              class="bg-success fw-semibold rounded-pill text-white">{{
                              ($appointment->status)
                              }}</span>
                           @else
                           <span style="padding-inline: 20px !important;" class="bg-warning fw-semibold rounded-pill">{{
                              ($appointment->status)
                              }}</span>
                           @endif
                        </td>
                        <td class="p-2 col-2">
                           <div class="d-flex justify-content-evenly gap-2">
                              <div>
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#confirmAppointmentModal{{ $appointment->id }}">View</button>
                              </div>
                           </div>
                        </td>
                     </tr>

                     {{-- Modal for Approving an appointment --}}
                     <div class="modal fade" id="confirmAppointmentModal{{ $appointment->id }}" tabindex="-1"
                        aria-labelledby="confirmAppointmentModalLabel{{ $appointment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">

                           <div class="modal-content">
                              <div class="modal-header justify-content-end">
                                 <button class="btn-close" type="button" data-bs-dismiss="modal"
                                    aria-label="close"></button>
                              </div>
                              <h2>Schedule your visit with ease</h2>

                              <div class="modal-body mt-3">
                                 <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-2">
                                       <select name="dentist_id" id="dentist_id" class="form-select p-2"
                                          style="background-color: #d9d9d9">
                                          <option value="" disabled selected>Select a dentist</option>
                                          @foreach ($dentists as $dentist)
                                          <option value="{{ $dentist->id }}" {{ $appointment->dentist_id ==
                                             $dentist->id ? 'selected': '' }}>
                                             {{ $dentist->user->first_name }} {{ $dentist->user->last_name }}
                                          </option>
                                          @endforeach
                                       </select>
                                    </div>

                                    <div class="row gap-2 mb-2">
                                       <div class="col">
                                          <input style="background-color: #d9d9d9" type="text" name="service_name"
                                             id="service_name" class="form-control p-2" readonly
                                             value="{{ $appointment->service->service_name }}">
                                       </div>

                                       {{-- Appointment Date --}}
                                       <div class="col">
                                          <input type="text" id="appointment_date" name="appointment_date"
                                             class="form-control p-2" style="background-color: #d9d9d9"
                                             value="{{ $appointment->appointment_date }}" required>
                                       </div>
                                    </div>

                                    {{-- User Details --}}
                                    <div class="row mb-2">
                                       <input type="text" id="name" readonly name="name" placeholder="Name"
                                          class="form-control p-2" style="background-color: #d9d9d9"
                                          value="{{$appointment->patient->user->first_name}} {{$appointment->patient->user->last_name}}"
                                          required>
                                    </div>

                                    <div class="row mb-2">
                                       <input type="email" id="email" name="email" readonly placeholder="Email"
                                          class="form-control p-2" style="background-color: #d9d9d9"
                                          value="{{$appointment->patient->user->email}}" required>
                                    </div>

                                    <div class="row mb-2">
                                       <input readonly type="tel" id="phone" name="phone"
                                          placeholder="Phone number: +63 9XXXXXXXXX" class="form-control p-2"
                                          style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$"
                                          value="{{$appointment->patient->user->contact_number}}" required>
                                    </div>

                                    {{-- Optional Messege --}}
                                    <div class="row my-4 d-flex">
                                       <div class="col">
                                          <input type="checkbox" id="status" name="status" value="1" {{
                                             $appointment->status ===
                                          'Approved' ? 'checked' : ''}}>
                                          <label for="status">Approve Appointment</label>
                                       </div>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="row">
                                       <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                       <button class="btn w-100 fw-bold text-white p-1"
                                          style="background-color: #00a1df" type="submit">Proceed to
                                          treatment</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </tbody>
               </table>
            </div>
            @endif
            </table>
         </div>
      </div>
   </div>
</div>

{{-- Modal for booking an appointment --}}
{{-- <div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel"
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

               <div class="row mb-2">
                  <select name="patient_id" id="patient_id" class="form-select p-2" style="background-color: #d9d9d9">
                     <option value="" disabled selected>Select a dentist</option>
                     @foreach ($patients as $patient)
                     <option value="{{ $patient->id }}" {{ $appointment->patient_id ==
                        $patient->id ? 'selected': '' }}>
                        {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                     </option>
                     @endforeach
                  </select>
               </div>


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
</div> --}}