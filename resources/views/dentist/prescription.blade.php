@extends('layout.dentist_nav_layout')

@section('title', 'Dentist-treatment-lists')

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
                    <th>Action</th>
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
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#printmodal{{ $prescription->id }}">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="printmodal{{ $prescription->id }}" tabindex="-1" aria-labelledby="printModalLabel{{ $prescription->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('dentist.prescription.update', $prescription->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-header justify-content-between">
                                                <h5 class="modal-title" id="printModalLabel{{ $prescription->id }}">Prescription Details</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div id="printArea{{ $prescription->id }}" class="p-4" style="font-family:Arial, Helvetica, sans-serif">

                                                    <div class="text-center mb-4">
                                                        <img height="65" width="65" src="{{ asset('images/final_logo.svg') }}" alt="Clinic logo">
                                                        <h3>Dental Clinic and Services</h3>
                                                        <hr style="border-top:2px solid #000; margin-top:20px;">
                                                    </div>

                                                    <div class="mb-3">
                                                        <p><strong>Date Issued:</strong> {{ $prescription->created_at->format('F j, Y') }}</p>
                                                        <p><strong>Dentist:</strong> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                                        <p><strong></strong> {{ $appointment->patient->user->first_name }} {{ $appointment->patient->user->last_name }}</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <p><strong>Medication:</strong> {{ $prescription->medication }}</p>
                                                        <p><strong>Instructions:</strong> {{ $prescription->instructions }}</p>
                                                        <p><strong>Appointment Date:</strong> {{ $appointment->created_at->format('F j, Y') }}</p>
                                                    </div>

                                                    <div class="row text-end mt-5">
                                                        <p>__________________________</p>
                                                        <div class="pe-5">
                                                            <p>Dr. {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Medication</label>
                                                    <input type="text" name="medication" class="form-control" value="{{ $prescription->medication }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Instructions</label>
                                                    <input type="text" name="instructions" class="form-control" value="{{ $prescription->instructions }}" required>
                                                </div>
                                            </div>

                                            <div class="modal-footer justify-content-between gap-2">
                                                <div class="col">
                                                    <button class="btn btn-success w-100" type="submit">Update</button>
                                                </div>
                                                <div class="col">
                                                    <button class="btn btn-secondary w-100" type="button" onclick="printDiv('printArea{{ $prescription->id }}')">Print</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function printDiv(divId) {
        const printContents = document.getElementById(divId).innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

@endsection
