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
        <div class="row p-2">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="background-color:#00a1df !important;" class="p-2 text-white">Patient</th>
                        <th style="background-color:#00a1df !important;" class="p-2 text-white">Medication</th>
                        <th style="background-color:#00a1df !important;" class="p-2 text-white">Instructions</th>
                        <th style="background-color:#00a1df !important;" class="p-2 text-white">Appointment Date</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointments as $appointment)
                    @foreach ($appointment->treatments as $treatment)
                    @foreach ($treatment->prescriptions as $prescription)
                    <tr>
                        <td class="p-2">{{ $appointment->patient->user->first_name }} {{
                            $appointment->patient->user->last_name }}
                        </td>
                        <td class="p-2">{{ $prescription->medication }}</td>
                        <td class="p-2">{{ $prescription->instructions }}</td>
                        <td class="p-2">{{ $appointment->appointment_date }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection