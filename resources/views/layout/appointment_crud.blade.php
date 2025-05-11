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
                  @php
                  $user = Auth::user();
                  $searchRoute = route('staff.appointment');
                  if ($user && $user->role === 'admin') {
                  $searchRoute = route('admin.appointment');
                  }
                  @endphp

                  <form action="{{ $searchRoute }}" method="GET" class="mb-3">
                     <input type="text" name="search" class="form-control"
                        placeholder="Search" value="{{ request('search') }}">
                     <button type="submit" class="btn btn-primary mt-2">Search</button>
                  </form>
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
                     <th class="p-2 col-2">Service</th>
                     <th class="p-2 col-2">Patient Name</th>
                     <th class="p-2 col-2">Dentist Assigned</th>
                     <th class="p-2 col-3">Appointment date</th>
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
                        <td class="p-2 col-2">{{ $appointment->service->service_name ?? 'N/A' }}</td>

                        <td class="p-2 col-2">{{ $appointment->patient->user->first_name ?? 'N/A' }} {{
                           $appointment->patient->user->last_name }}</td>

                        <td class="p-2 col-2">{{ $appointment->dentist->user->first_name ?? 'N/A' }} {{
                           $appointment->dentist->user->last_name ?? ''}}</td>

                        <td class="p-2 col-3">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format
                           ('F d, Y | h:i: A')}}
                        </td>

                        <td class="p-2 col-1">
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

                        <td class="p-2 col-2">
                           <div class="d-flex justify-content-evenly gap-2">

                              {{-- APPROVED --}}
                              @if ($appointment->status === 'Approved')
                              <div class="w-50">
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#approvedAppointmentModal{{ $appointment->id }}">
                                    <i class="bi bi-arrow-right"></i></button>
                              </div>

                              <!-- Proceed to Treatment Confirmation Modal -->
                              <div class="modal fade" id="approvedAppointmentModal{{$appointment->id}}" tabindex="-1"
                                 aria-labelledby="approvedAppointmentModalLabel{{$appointment->id}}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between p-2">
                                          <h5 class="modal-title">Proceed to Treatment Confirmation</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                       </div>

                                       <div class="modal-body">
                                          <p class="my-4 fs-5 text-center">Are you sure you want to proceed with this
                                             appointment to treatment?</p>
                                       </div>

                                       <div class="modal-footer row mt-3 gap-2 pt-3">
                                          <div class="col">
                                             <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                                data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                          <div class="col">
                                             <form
                                                action="{{ route('treatments.store', ['appointment'=>$appointment]) }}"
                                                method="POST" class="d-inline">
                                                @csrf

                                                <button type="submit"
                                                   class="btn admin-staff-btn w-100 text-white p-1">Proceed</button>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              {{-- ONGOING --}}
                              @elseif($appointment->status === 'Ongoing')

                              {{-- DECLINED --}}
                              @elseif($appointment->status === 'Declined')
                              <button type="submit" class="btn admin-staff-btn text-white w-50 px-2 py-1"
                                 data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$appointment->id}}">
                                 <i class="bi bi-trash-fill"></i>
                              </button>

                              <!-- Delete Confirmation Modal -->
                              <div class="modal fade" id="confirmDeleteModal{{$appointment->id}}" tabindex="-1"
                                 aria-labelledby="confirmDeleteModalLabel{{$appointment->id}}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between p-2">
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

                              @elseif ($appointment->status === 'Completed')
                              <div class="w-50">
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                    data-bs-target="#completedAppointmentModal{{ $appointment->id }}">View</button>
                              </div>

                              <div class="modal fade" id="completedAppointmentModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="completedAppointmentModalLabel{{ $appointment->id }}"
                                 aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">

                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between p-2">
                                          <h3>Appointment Details</h3>
                                          <button class="btn-close" type="button" data-bs-dismiss="modal"
                                             aria-label="close"></button>
                                       </div>

                                       <div class="modal-body mt-3 ">
                                          <div class="row mb-2 gap-2">
                                             <div class="col">
                                                <label for="dentist">Dentist Assigned</label>
                                                <input style="background-color: #d9d9d9" type="text"
                                                   class="form-control p-2" readonly
                                                   value="{{$appointment->dentist->user->first_name}} {{$appointment->dentist->user->last_name}}">
                                             </div>

                                             <div class="col">
                                                <label for="dentist">Status</label>
                                                <input style="background-color: #d9d9d9" type="text"
                                                   class="form-control p-2 " readonly value="{{$appointment->status}}">
                                             </div>

                                          </div>

                                          <div class="row gap-2 mb-2">
                                             <div class="col">

                                                <label for="service">Service</label>
                                                <input style="background-color: #d9d9d9" type="text" name="service_name"
                                                   id="service_name" class="form-control p-2" readonly
                                                   value="{{ $appointment->service->service_name }}">
                                             </div>

                                             {{-- Appointment Date --}}
                                             <div class="col">
                                                <label for="appointment_date">Appointment Date</label>
                                                <input type="text" id="appointment_date" name="appointment_date"
                                                   class="form-control p-2" style="background-color: #d9d9d9"
                                                   value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y | h:i: A')}}"
                                                   required>
                                             </div>
                                          </div>
                                          <hr>

                                          <p class="fs-5 fw-semibold mb-3">PATIENT INFORMATION</p>


                                          {{-- User Details --}}
                                          <div class="row mb-2">
                                             <label for="name">Name</label>
                                             <input type="text" id="name" readonly name="name" placeholder="Name"
                                                class="form-control p-2" style="background-color: #d9d9d9"
                                                value="{{$appointment->patient->user->first_name}} {{$appointment->patient->user->last_name}}"
                                                required>
                                          </div>

                                          <div class="row mb-2">
                                             <label for="email">Email</label>
                                             <input type="email" id="email" name="email" readonly placeholder="Email"
                                                class="form-control p-2" style="background-color: #d9d9d9"
                                                value="{{$appointment->patient->user->email}}" required>
                                          </div>

                                          <div class="row mb-2">
                                             <label for="phone">Contact Number</label>
                                             <input readonly type="tel" id="phone" name="phone"
                                                placeholder="Phone number: +63 9XXXXXXXXX" class="form-control p-2"
                                                style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$"
                                                value="{{$appointment->patient->user->contact_number}}" required>
                                          </div>

                                          <div class="row mt-3">
                                             <button class="btn admin-staff-btn w-100 fw-bold text-white p-1"
                                                data-bs-dismiss="modal" type="button">Close</button>
                                          </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              @else
                              <div class="d-flex w-50 gap-2">
                                 <div class="w-50">
                                    <button class="btn admin-staff-btn text-white w-100 px-2 py-1"
                                       data-bs-toggle="modal"
                                       data-bs-target="#confirmAppointmentModal{{ $appointment->id }}"><i
                                          class="bi bi-check-circle-fill"></i></button>
                                 </div>

                                 <div class="w-50">
                                    <button class="btn btn-danger text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                       data-bs-target="#declineAppointmentModal{{ $appointment->id }}"><i
                                          class="bi bi-x-circle-fill"></i></button>
                                 </div>
                              </div>

                              <!-- Decline Confirmation Modal -->
                              <div class="modal fade" id="declineAppointmentModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="declineModalLabel{{ $appointment->id }}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <form method="POST"
                                          action="{{ route('appointments.update', $appointment->id) }}">
                                          @csrf
                                          @method('PUT')
                                          <input type="hidden" value="Declined" name="status">
                                          <div class="modal-header d-flex justify-content-between p-2">
                                             <h5 class="modal-title" id="declineModalLabel{{ $appointment->id }}">
                                                Decline Confirmation</h5>
                                             <button type="button" class="btn-close btn-close-dark"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>

                                          <div class="modal-body">
                                             <p class="py-4 fs-5 text-center"> Are you sure you want to
                                                <strong> decline</strong> this
                                                appointment?
                                             </p>
                                          </div>

                                          <div class="modal-footer">
                                             <div class="d-flex w-100 gap-2 pt-3">
                                                <button type="button" class="btn admin-staff-cancel-btn w-50 p-1"
                                                   data-bs-dismiss="modal">Cancel</button>

                                                <button type="submit" class="btn btn-danger w-50 p-1">Decline</button>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>

                              {{-- Modal for Approving an appointment --}}
                              <div class="modal fade" id="confirmAppointmentModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="confirmAppointmentModalLabel{{ $appointment->id }}"
                                 aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">

                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between p-2">
                                          <h3>Approve and Assign a Dentist</h3>
                                          <button class="btn-close" type="button" data-bs-dismiss="modal"
                                             aria-label="close"></button>
                                       </div>

                                       <div class="modal-body mt-3">
                                          <form action="{{ route('appointments.update', $appointment->id) }}"
                                             method="POST">

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
                                                   <input style="background-color: #d9d9d9" type="text"
                                                      name="service_name" id="service_name" class="form-control p-2"
                                                      readonly value="{{ $appointment->service->service_name }}">
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

                                             <div class="row my-4 d-flex">
                                                <div class="col">
                                                   <input type="checkbox" id="status" name="status" value="Approved">
                                                   <label for="status">Approve Appointment</label>
                                                </div>
                                             </div>

                                             {{-- Submit Button --}}
                                             <div class="row">
                                                <button class="btn w-100 fw-bold text-white p-1"
                                                   style="background-color: #00a1df" type="submit">Confirm</button>
                                             </div>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                        </td>
                     </tr>


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