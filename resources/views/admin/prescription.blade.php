@extends('layout.admin_nav_layout')

@section('title', 'Dentist Prescriptions')

@section('breadcrumb')
<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Prescriptions</span>
</div>
@endsection

@section('adminContent')


<div class="row m-2">
    <div class="card shadow">
        <div class="card-body d-flex justify-content-between">
            <div class="row w-100 p-3 gap-3">
                <h3>Prescriptions</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mx-2">
    <div class="card" style="overflow: hidden">
        <div class="card-body" style="height: 465px !important;">
            <div class="row">
                <table>
                    <th>
                        <tr class="text-white" style="font-size: 16px; background-color:#00a1df !important;">
                            <th class="p-2 col-2">Dentist</th>
                            <th class="p-2 col-2">Patient</th>
                            <th class="p-2 col-2">Service</th>
                            <th class="p-2 col-2">Medication</th>
                            <th class="p-2 col-2">Instructions</th>
                            <th class="p-2 col-2">Action</th>
                        </tr>
                    </th>
                </table>
            </div>

            @if ($prescriptions->isEmpty())
                <p class="alert text-center text-secondary">No prescriptions made.</p>
            @else
                <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
                    <table class="table table-bordered">
                        <tbody>
                            @foreach ($prescriptions as $prescription)
                                <tr>
                                    <td class="p-2 col-2">{{ $prescription->treatment->appointment->dentist->user->first_name }} 
                                        {{ $prescription->treatment->appointment->dentist->user->last_name }}</td>
                                    <td class="p-2 col-2">{{ $prescription->patient?->user?->first_name ?? 'N/A' }}
                                        {{ $prescription->patient?->user?->last_name ?? '' }}</td>
                                    <td class="p-2 col-2">{{ $prescription->treatment->appointment->service?->service_name ?? 'N/A' }}</td>
                                    <td class="p-2 col-2">{{ $prescription->medication }}</td>
                                    <td class="p-2 col-2">{{ $prescription->instructions }}</td>
                                    <td class="p-2 col-2">
                                        <button class="btn btn-sm admin-staff-btn p-1 w-100 text-white" data-bs-toggle="modal"
                                        data-bs-target="#printmodal{{ $prescription->id }}">
                                        View
                                </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="printmodal{{ $prescription->id }}" tabindex="-1"
                                    aria-labelledby="printModalLabel{{ $prescription->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header justify-content-between">
                                                <h5 class="modal-title" id="printModalLabel{{ $prescription->id }}">
                                                    Prescription
                                                    Details</h5>
                                                <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>

                                            
                                            <div class="modal-body">
                                                <div id="printArea{{ $prescription->id }}" class="p-4"
                                                    style="font-family:Arial, Helvetica, sans-serif">

                                                    <div class="text-center mb-4">
                                                        <img height="65" width="65"
                                                            src="{{ asset('images/final_logo.svg') }}" alt="Clinic logo">
                                                        <h3>Dental Clinic and Services</h3>
                                                        <hr style="border-top:2px solid #000; margin-top:20px;">
                                                    </div>

                                                    <div class="mb-3">
                                                        <p><strong>Date Issued:</strong> {{
                                                            $prescription->created_at->format('F j,
                                                            Y') }}</p>
                                                        <p><strong>Dentist:</strong> {{ $prescription->treatment->appointment->dentist->user->first_name }} 
                                                            {{ $prescription->treatment->appointment->dentist->user->last_name }}</p>
                                                        <p><strong>Name:</strong> {{ $prescription->patient?->user?->first_name ?? 'N/A' }}
                                                            {{ $prescription->patient?->user?->last_name ?? '' }}</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <p><strong>Service:</strong> {{ $prescription->treatment->appointment->service?->service_name ?? 'N/A' }}</p>
                                                        <p><strong>Medication:</strong> {{ $prescription->medication }}</p>
                                                        <p><strong>Instructions:</strong> {{ $prescription->instructions }}
                                                        </p>
                                                    </div>

                                                    <div class="row text-end mt-5">
                                                        <p>__________________________</p>
                                                        <div class="pe-5">
                                                            <p>Dr. {{ $prescription->treatment->appointment->dentist->user->first_name }} 
                                                            {{ $prescription->treatment->appointment->dentist->user->last_name }}</p>
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
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="container mt-4">
    <h4 class="mb-3">All Prescriptions by Dentists</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Dentist</th>
                    <th>Patient</th>
                    <th>Date Issued</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->id }}</td>
                        <td>{{ $prescription->treatment->appointment->dentist->user->first_name ?? 'N/A' }}</td>
                        <td>{{ $prescription->patient->user->first_name }} {{ $prescription->patient->user->last_name }}</td>
                        <td>{{ $prescription->created_at->format('F j, Y') }}</td>
                        <td>
                            <button class="btn btn-sm admin-staff-btn p-1 w-100 text-white" data-bs-toggle="modal"
                                data-bs-target="#printmodal{{ $prescription->id }}">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No prescriptions available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



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