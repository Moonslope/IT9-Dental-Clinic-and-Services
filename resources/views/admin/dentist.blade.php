@extends('layout.admin_nav_layout')

@section('title', 'Dentist Lists')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dentists</span>
</div>

@endsection

@section('adminContent')

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
            <div class="col col-3">
               <h3>Dentist Lists</h3>
            </div>

            <div class="col">
               <div class="d-flex w-75 gap-2">
                  <input type="text" id="search" class="form-control" placeholder=" Search">
                  <button class="btn admin-staff-btn"><i class="bi bi-search fs-5 p-2 text-white"></i></button>
               </div>
            </div>

            <div class="col col-1">
               <button class="btn admin-staff-btn text-white w-100 p-1" data-bs-toggle="modal"
                  data-bs-target="#addDentistModal">ADD <i class="ms-2 bi bi-plus-circle-fill"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div style="overflow: hidden;" class="card">
      <div style="height: 465px !important;" class="card-body">

         <div class="row">
            <table>
               <thead class="">
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Name</th>
                     <th class="p-2 col-2">Email</th>
                     <th class="p-2 col-2 text-center">Specialization</th>
                     <th class="p-2 col-2 text-center">Contact Number</th>
                     <th class="p-2 col-3 text-center">Address</th>
                     <th class="p-2 col-1">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($users->isEmpty())
         <p class="alert text-center text-secondary">No Dentist available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($users as $user)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2 col-2 ">{{ $user->first_name }} {{ $user->last_name }}</td>
                     <td class="p-2 col-2">{{ $user->email }}</td>
                     <td class="p-2 col-2">{{ $user->dentist->specialization}}</td>
                     <td class="p-2 col-2">{{ $user->contact_number }}</td>
                     <td class="p-2 col-3">{{ $user->address }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly gap-2">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editDentistModal{{$user->id}}"><i
                                    class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <form action="{{route('admin.dentist.destroy', ['user' => $user])}}" method="POST">
                                 @csrf
                                 @method('delete')
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1"><i
                                       class="bi bi-trash-fill"></i></button>
                              </form>
                           </div>
                        </div>
                     </td>
                  </tr>

                  {{-- Modal to Edit Dentist --}}
                  <div class="modal fade" id="editDentistModal{{$user->id}}" tabindex="-1"
                     aria-labelledby="editDentistModalLabel{{$user->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="editDentistModalLabel{{$user->id}}">EDIT DENTIST</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">
                              <form action="{{route('admin.dentist.update', ['user' => $user->id])}}" method="POST">
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
                                       <input style="background-color: #d9d9d9" type="text" id="specialization"
                                          name="specialization" placeholder="Specialization" class="form-control p-2 "
                                          value="{{ $user->dentist->specialization }}">
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
            @endif

         </div>
      </div>
   </div>


   {{-- Modal to Add Dentist --}}
   <div class="modal fade" id="addDentistModal" tabindex="-1" aria-labelledby="addDentistModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">

         <div class="modal-content">
            <div class="modal-header fw-semibold d-flex justify-content-between">
               <h5 class="modal-title" id="addDentistModalLabel">ADD DENTIST</h5>
               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mt-3">
               <form action="{{route('register')}}" method="POST">
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
                        <input style="background-color: #d9d9d9" type="text" id="specialization" name="specialization"
                           placeholder="Specialization" class="form-control p-2">
                     </div>
                  </div>

                  <div class="row mb-3 gap-2">

                     <div class="col">
                        <input style="background-color: #d9d9d9" type="email" id="email" name="email"
                           placeholder="Email" class="form-control p-2">
                     </div>
                  </div>

                  <div class="row mb-3 gap-2">
                     <div class="col">
                        <input style="background-color: #d9d9d9" type="password" id="password" name="password"
                           placeholder="Password" class="form-control p-2">
                     </div>
                  </div>

                  <input type="text" hidden name="role" value="dentist">

                  <div class="modal-footer row mt-3 gap-2 pt-3">
                     <div class="col">
                        <button class="btn admin-staff-cancel-btn  fw-bold w-100 p-1" type="button"
                           data-bs-dismiss="modal">Cancel</button>
                     </div>
                     <div class="col">
                        <button class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                           style="background-color: #00a1df" type="submit">Add</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   @include('layout.modals.crud_success')
   @endsection