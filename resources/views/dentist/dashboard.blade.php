@extends('layout.dentist_nav_layout')

@section('title', 'Dentist Dashboard')

@section('user_type', 'Hi, ' . $dentist->first_name . ' ' . $dentist->last_name)

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dashboard</span>
</div>

@endsection

@section('dentistContent')
<div class="row ps-3 py-2 mt-2">
   <h2>Dashboard Overview</h2>
</div>

<div class="row my-3">
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-info">
               <i class="bi bi-calendar-event fs-2 me-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Appointments Today</p>
               <p class="fs-3">{{$todayAppointmentsCount}}</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-success">
               <i class="bi bi-list-check fs-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Completed Appointments</p>
               <p class="fs-3">{{$completedAppointmentsCount}}</p>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-warning">
               <i class="bi bi-calendar-week fs-2 text-white"></i>
            </div>
            <div class="p-1">
               <p class="fs-5">Upcoming Appointments</p>
               <p class="fs-3">{{$upcomingAppointmentsCount}}</p>
            </div>
         </div>
      </div>
   </div>

   <div class="col">
      <div class="card m-2 shadow" style="overflow: hidden;">
         <div class="d-flex gap-2">
            <div class="d-flex justify-content-center align-items-center px-4 bg-primary">
               <i class="bi bi-person-lines-fill fs-2 text-white"></i>
            </div>

            <div class="p-1">
               <p class="fs-5">Total Patients</p>
               <p class="fs-3">{{$totalPatientsHandled}}</p>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="mt-4 mx-3">
   <h3 class="pb-2">Patients</h3>

   <div style="overflow: hidden" class="card">
      <div style="height: 200px !important; " class="card-body">
         <div class="row">
            <table>
               <thead class="">
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2">Name</th>
                     <th class="p-2 col-2">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($appointmentsAssigned->isEmpty())
         <p class="alert text-center text-secondary">No patient available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($appointmentsAssigned as $appointment)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2  ">{{$appointment->patient->user->first_name}}
                        {{$appointment->patient->user->last_name}}</td>
                     <td class="p-2 col-2">
                        <div class="d-flex justify-content-evenly">
                           <div>
                              <button class="btn admin-staff-btn w-100 px-2 py-1 text-white" data-bs-toggle="modal"
                                 data-bs-target="#viewModal{{$appointment->id}}">VIEW</button>

                              <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1"
                                 aria-labelledby="viewModalLabel{{ $appointment->id }}" aria-hidden="true">

                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header justify-content-between">
                                          <h4 class="modal-title">
                                             Patient Details
                                          </h4>
                                          <button class="btn-close" type="button" data-bs-dismiss="modal"
                                             aria-label="close">
                                          </button>
                                       </div>

                                       <div class="modal-body mt-3">
                                          <div class="row gap-2">
                                             <div class="col mb-3">
                                                <label class="form-label mb-1">First Name</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->user->first_name}}">
                                             </div>

                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Last Name</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->user->last_name}}">
                                             </div>
                                          </div>

                                          <div class="row gap-2">
                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Age</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->age}}">
                                             </div>

                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Gender</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->gender}}">
                                             </div>
                                          </div>

                                          <div class="row">
                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Contact Number</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->user->contact_number}}">
                                             </div>
                                          </div>

                                          <div class="row">
                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Address</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->user->address}}">
                                             </div>
                                          </div>

                                          <div class="row">
                                             <div class="col mb-3">
                                                <label class="form-label mb-1">Email</label>
                                                <input type="text" class="form-control p-2"
                                                   style="background-color: #d9d9d9" readonly
                                                   value="{{$appointment->patient->user->email}}">
                                             </div>
                                          </div>
                                       </div>

                                       <div class="modal-footer">
                                          <div class="row w-100 pt-2">
                                             <div class="col">
                                                <button type="button" class="btn admin-staff-btn w-100 p-1 text-white"
                                                   data-bs-dismiss="modal">Close</button>
                                             </div>
                                          </div>

                                       </div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @endif
      </div>
   </div>
</div>

@include('layout.modals.login_success')
@endsection