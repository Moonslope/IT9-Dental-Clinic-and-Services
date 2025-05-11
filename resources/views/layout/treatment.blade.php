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
               <h3>Treatment Lists</h3>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row mx-2">
   <div style="overflow: hidden" class="card">
      <div style="height: 465px !important;" class="card-body">
         <div class="row">
            <table>
               <thead>
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Service</th>
                     <th class="p-2 col-2">Patient</th>
                     <th class="p-2 col-2">Dentist</th>
                     <th class="p-2 col-2">Date</th>
                     <th class="p-2 col-1">Status</th>
                     <th class="p-2 col-2">Total Cost</th>
                     <th class="p-2 col-1">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($treatments->isEmpty())
         <p class="alert text-center text-secondary">No treatment available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($treatments as $treatment)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="pt-3 col-2 text-center">{{$treatment->appointment->service->service_name}}</td>
                     <td class="pt-3 col-2 text-center">
                        {{$treatment->appointment->patient->user->first_name}}
                        {{$treatment->appointment->patient->user->last_name}}
                     </td>
                     <td class="pt-3 col-2 text-center">
                        {{$treatment->appointment->dentist->user->first_name}}
                        {{$treatment->appointment->dentist->user->last_name}}
                     </td>
                     <td class="pt-3 col-2 text-center">
                        {{ \Carbon\Carbon::parse($treatment->appointment->appointment_date)->format('F d, Y | h:i: A')
                        }}
                     </td>
                     <td class="pt-3 col-1 text-center">{{$treatment->status}}</td>
                     <td class="pt-3 col-2 text-center">₱{{ number_format($treatment->treatment_cost, 2) }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly gap-2">
                           @if($treatment->status === 'Paid')
                           <button class="btn admin-staff-btn px-2 py-1 text-white" data-bs-toggle="modal"
                              data-bs-target="#viewPaymentModal{{ $treatment->id }}">
                              View
                           </button>
                           @else
                           <button class="btn admin-staff-btn  px-2 py-1 text-white" data-bs-toggle="modal"
                              data-bs-target="#usedSupplyModal{{$treatment->id}}"><i
                                 class="bi bi-plus-circle-fill fs-5"></i></button>

                           <button class="btn admin-staff-btn px-2 py-1 text-white" data-bs-toggle="modal"
                              data-bs-target="#paymentModal{{ $treatment->id }}">
                              Payment
                           </button>
                           @endif
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

@foreach ($treatments as $treatment)

<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal{{ $treatment->id }}" tabindex="-1"
   aria-labelledby="viewPaymentLabel{{ $treatment->id }}" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header text-white d-flex justify-content-between">
            <h4 class="modal-title" id="viewPaymentLabel{{ $treatment->id }}">Payment Details</h4>
            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body pt-2">

            <div id="printArea{{ $treatment->id }}" class="p-4">

               <div class="text-center mb-4">
                  <img height="65" width="65" src="{{ asset('images/final_logo.svg') }}" alt="Clinic logo">
                  <h3>Dental Clinic and Services</h3>
                  <hr style="border-top:2px solid #000; margin-top:20px;">
               </div>

               @php
               $servicePrice = $treatment->appointment->service->service_price;
               $totalSupplies = 0;
               @endphp
               <div class="my-3">
                  <div class="d-flex justify-content-between w-100 mb-2">
                     <h5>Patient Name: {{$treatment->appointment->patient->user->first_name}}</h5>

                     @if ($treatment->payment)
                     <h5>Payment Date: {{ \Carbon\Carbon::parse($treatment->payment->payment_date)->format('F d, Y') }}
                     </h5>
                     @else
                     <h5>Payment Date: Not yet paid</h5>
                     @endif
                  </div>

                  <h5>Status: {{$treatment->status}}</h5>
               </div>
               @if($treatment->treatmentSupplies->isEmpty())
               <div class="alert alert-warning mb-2">No supplies recorded for this treatment.</div>
               @else



               <hr>

               <table style="border-collapse: separate; border-spacing: 0; border-radius: 10px; overflow: hidden;"
                  class="table table-bordered mb-2 pt-2">
                  <thead>
                     <tr style="font-size: 18px;" class=" text-center">
                        <th class="text-white p-1" style="background-color: #00a1df">Name</th>
                        <th class="text-white p-1" style="background-color:#00a1df !important;">Quantity</th>
                        <th class="text-white p-1" style="background-color:#00a1df !important;">Price per item</th>
                        <th class="text-white p-1" style="background-color:#00a1df !important;">Subtotal</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($treatment->treatmentSupplies as $ts)
                     @php
                     $subtotal = $ts->quantity_used * $ts->supply->supply_price;
                     $totalSupplies += $subtotal;
                     @endphp
                     <tr style="font-size: 18px !important;" class="text-center">
                        <td class="p-1">{{ $ts->supply->supply_name }}</td>
                        <td class="p-1">{{ $ts->quantity_used }}</td>
                        <td class="p-1">₱{{ number_format($ts->supply->supply_price, 2) }}</td>
                        <td class="p-1">₱{{ number_format($subtotal, 2) }}</td>
                     </tr>
                     @endforeach
                  </tbody>
                  <tfoot>
                     <tr style="font-size: 18px !important;" class="text-center ">
                        <th style="background-color:#00a1df !important;" colspan="3" class="text-end text-white pe-5 p-1">
                           Total
                           Used
                           Supplies
                        </th>
                        <th style="background-color:#00a1df !important;" class="text-white p-1">₱{{
                           number_format($totalSupplies, 2) }}</th>
                     </tr>
                  </tfoot>
               </table>
               @endif

               <hr>

               <p class="fs-5 py-2 mb-2">Service Price: <span class="float-end">₱{{ number_format($servicePrice, 2)
                  }}</span>
               </p>

               <hr>
               <h5 class="my-3">Grand Total: <span class="float-end text-primary fw-bold">₱{{ number_format($servicePrice +
                  $totalSupplies, 2) }}</span></h5>

            </div>
            <div class="row">
               <button class="btn btn-secondary w-100" type="button" onclick="printDiv('printArea{{ $treatment->id }}')">Print</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Used Supplies Modal -->
<div class="modal fade" id="usedSupplyModal{{ $treatment->id }}" tabindex="-1"
   aria-labelledby="modalLabel{{ $treatment->id }}" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <form method="POST" action="{{ route('treatment-supply.store') }}">
         @csrf
         <input type="hidden" name="treatment_id" value="{{ $treatment->id }}">
         <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
               <h5 class="modal-title">ADD USED SUPPLIES</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div style="height: 300px !important;" class="modal-body pt-3">
               @foreach($supplies as $supply)
               <div class="row mb-2 border-bottom pb-2 align-items-center">
                  <div class="col">
                     <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" type="checkbox" name="supplies[{{ $supply->id }}][selected]"
                           value="1" id="supply{{ $supply->id }}">
                        <label class="form-check-label" for="supply{{ $supply->id }}">
                           {{ $supply->supply_name }} (Available: {{ $supply->supply_quantity }})
                        </label>
                     </div>
                  </div>
                  <div class="col">
                     <input type="number" name="supplies[{{ $supply->id }}][quantity]" class="form-control p-2" min="1"
                        placeholder="Quantity">
                  </div>
               </div>
               @endforeach
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn admin-staff-btn text-white p-2">Add Selected Supplies</button>
            </div>
         </div>
      </form>
   </div>
</div>

<!-- Payment Modal -->
<div class="modal fade " id="paymentModal{{ $treatment->id }}" tabindex="-1"
   aria-labelledby="paymentModalLabel{{ $treatment->id }}" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header text-white d-flex justify-content-between">
            <h4 class="modal-title" id="paymentModalLabel{{ $treatment->id }}">Payment Summary</h4>
            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body pt-4">
            @php
            $servicePrice = $treatment->appointment->service->service_price;
            $totalSupplies = 0;
            @endphp

            @if($treatment->treatmentSupplies->isEmpty())
            <div class="alert alert-warning mb-2">No supplies recorded for this treatment.</div>
            @else
            <table style="border-collapse: separate; border-spacing: 0; border-radius: 10px; overflow: hidden;"
               class="table table-bordered mb-2">
               <thead>
                  <tr style="font-size: 18px;" class=" text-center">
                     <th class="text-white p-1" style="background-color: #00a1df">Name</th>
                     <th class="text-white p-1" style="background-color:#00a1df !important;">Quantity</th>
                     <th class="text-white p-1" style="background-color:#00a1df !important;">Price per item</th>
                     <th class="text-white p-1" style="background-color:#00a1df !important;">Subtotal</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($treatment->treatmentSupplies as $ts)
                  @php
                  $subtotal = $ts->quantity_used * $ts->supply->supply_price;
                  $totalSupplies += $subtotal;
                  @endphp
                  <tr style="font-size: 18px !important;" class="text-center">
                     <td class="p-1">{{ $ts->supply->supply_name }}</td>
                     <td class="p-1">{{ $ts->quantity_used }}</td>
                     <td class="p-1">₱{{ number_format($ts->supply->supply_price, 2) }}</td>
                     <td class="p-1">₱{{ number_format($subtotal, 2) }}</td>
                  </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr style="font-size: 18px !important;" class="text-center ">
                     <th style="background-color:#00a1df !important;" colspan="3" class="text-end text-white pe-5 p-1">
                        Total
                        Used
                        Supplies
                     </th>
                     <th style="background-color:#00a1df !important;" class="text-white p-1">₱{{
                        number_format($totalSupplies, 2) }}</th>
                  </tr>
               </tfoot>
            </table>
            @endif

            <hr>

            <p class="fs-5 py-2 mb-2">Service Price: <span class="float-end">₱{{ number_format($servicePrice, 2)
                  }}</span>
            </p>

            <hr>
            <h5 class="my-3">Grand Total: <span class="float-end text-primary fw-bold">₱{{ number_format($servicePrice +
                  $totalSupplies, 2) }}</span></h5>
         </div>


         <div class="modal-footer pt-3">
            <form action="{{ route('payment.store', ['treatment'=>$treatment]) }}" method="POST">
               @csrf
               <button type="submit" class="btn admin-staff-btn px-2 py-1 text-white">Confirm Payment</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach

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