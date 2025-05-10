@extends('layout.dentist_nav_layout')

@section('title', 'Dentist-treatement-lists')
    
@section('user_type', 'Hi, ')
    
@section('breadcrumb')
<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
    <span><a href="" class="text-decoration-none text-dark">Home</a></span>
    <span class="mx-2">></span>
    <span class="text-muted">Appointments</span>
</div>
@endsection

@section('dentistContent')

<div class="row m-2">
    <div class="card shadow">
       <div class="card-body d-flex justify-content-between">
          <div class="row w-100 p-3 gap-3">
             <h3>Prescriptions</h3>
          </div>
       </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Patient</th>
                  <th>Medication</th>
                  <th>Instructions</th>
                  <th>Appointment Date</th>
               </tr>
            </thead>
            <tbody>

                @foreach ($appointments as $appointment)
                    @foreach ($appointment->treatments as $treatment) 
                            @foreach ($treatment->prescriptions as $prescription)
                                <tr>
                                    <td>{{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</td>
                                    <td>{{ $prescription->medication }}</td>
                                    <td>{{ $prescription->instructions }}</td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                </tr>
                            @endforeach
                    @endforeach
                @endforeach

            </tbody>
        </table>
    </div>
</div>
   
    
@endsection
