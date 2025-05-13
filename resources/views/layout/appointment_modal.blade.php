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

                  {{-- Appointment Date --}}
                  <div class="col">
                     <label for="appointmentDate" class="mb-1  fw-semibold">Date and Time</label>
                     <input type="datetime-local" id="appointmentDate" name="appointment_date"
                        class="form-control p-2 @error('appointment_date') is-invalid @enderror"
                        style="background-color: #d9d9d9" required>

                     @error('appointment_date')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
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

               {{-- Submit Button --}}
               <div class="row mt-4">
                  <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                     type="submit">Submit Appointment</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>