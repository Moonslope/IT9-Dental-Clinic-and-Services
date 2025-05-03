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
         <div class="row w-100 p-3">
            <div class="col">
               <h3>Patient Lists</h3>
            </div>

            <div class="col col-2">
               <button class="btn admin-staff-btn w-100 p-1 text-white" data-bs-toggle="modal"
                  data-bs-target="#addPatientModal">ADD <i class="ms-2 bi bi-plus-circle-fill"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row mx-2">
   <div style="overflow: hidden" class="card">
      <div style="height: 425px !important; " class="card-body">
         <div class="row">
            <table>
               <thead class="">
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Name</th>
                     <th class="p-2 col-2">Email</th>
                     <th class="p-2 col-1">Age</th>
                     <th class="p-2 col-1">Gender</th>
                     <th class="p-2 col-2">Contact Number</th>
                     <th class="p-2 col-2">Address</th>
                     <th class="p-2 col-1">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($users->isEmpty())
         <p class="alert text-center text-secondary">No Patients available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($users as $user)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2 col-2 ">{{ $user->first_name }} {{ $user->last_name }}</td>
                     <td class="p-2 col-2">{{ $user->email }}</td>
                     <td class="p-2 col-1">{{ $user->patient->age }}</td>
                     <td class="p-2 col-1">{{ $user->patient->gender }}</td>
                     <td class="p-2 col-2">{{ $user->contact_number }}</td>
                     <td class="p-2 col-2">{{ $user->address }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly gap-2">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editPatientModal{{$user->id}}"><i
                                    class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <form action="{{route('patient.destroy', ['user' => $user])}}" method="POST">
                                 <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                 @csrf
                                 @method('delete')
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1"><i
                                       class="bi bi-trash-fill"></i></button>
                              </form>
                           </div>
                        </div>
                     </td>
                  </tr>

                  {{-- edit --}}
                  <div class="modal fade" id="editPatientModal{{$user->id}}" tabindex="-1"
                     aria-labelledby="editPatientModalLabel{{$user->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="editPatientModalLabel{{$user->id}}">EDIT Patient</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">

                              <form action="{{route('patient.update', ['user' => $user])}}" method="POST">
                                 @csrf
                                 @method('PUT')
                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="first_name"
                                          name="first_name" class="form-control p-2" value="{{ $user->first_name }}">
                                    </div>

                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="last_name"
                                          name="last_name" class="form-control p-2" value="{{ $user->last_name }}">
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="numeric" id="age" name="age"
                                          class="form-control p-2" value="{{$user->patient->age}}" placeholder="Age">
                                    </div>

                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="gender" name="gender"
                                          class="form-control p-2" value="{{$user->patient->gender}}"
                                          placeholder="Gender">
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
                                       <input style="background-color: #d9d9d9" type="text" id="contact_number"
                                          name="contact_number" class="form-control p-2"
                                          value="{{ $user->contact_number }}">
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="password" id="password"
                                          name="password" class="form-control p-2"
                                          placeholder="Enter new password (optional)">
                                    </div>
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1"
                                          type="button" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col">
                                       <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                       <button class="btn admin-staff-btn  w-100 fw-bold text-white p-1"
                                          type="submit">Update</button>
                                    </div>
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
      </div>
   </div>
</div>
</div>

{{-- Modal to Add supplies --}}
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">

      <div class="modal-content">
         <div class="modal-header fw-semibold d-flex justify-content-between">
            <h5 class="modal-title" id="addPatientModalLabel">ADD PATIENT</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">
            <form action="{{route('patient.store')}}" method="POST">
               @csrf
               @method('POST')
               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="first_name" name="first_name"
                        placeholder="First Name" class="form-control p-2">
                  </div>

                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="last_name" name="last_name"
                        placeholder="Last Name" class="form-control p-2">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="numeric" id="age" name="age"
                        class="form-control p-2" placeholder="Age">
                  </div>

                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="gender" name="gender"
                        class="form-control p-2" placeholder="Gender">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="contact_number" name="contact_number"
                        placeholder="Contact Number" class="form-control p-2">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                        placeholder="Address" class="form-control p-2">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="email" id="email" name="email" placeholder="Email"
                        class="form-control p-2">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="password" id="password" name="password"
                        placeholder="Password" class="form-control p-2">
                  </div>
               </div>

               <input type="text" hidden name="role" value="patient">

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn admin-staff-cancel-btn  fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>
                  <div class="col">
                     <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                     <button class="btn w-100 fw-bold admin-staff-btn text-white p-1" style="background-color: #00a1df"
                        type="submit">Add</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>