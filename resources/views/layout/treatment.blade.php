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
      <div style="height: 425px !important;" class="card-body">
         <div class="row">
            <table>
               <thead>
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Service</th>
                     <th class="p-2 col-2">Patient Name</th>
                     <th class="p-2 col-2">Dentist Assigned</th>
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
                     <td class="pt-3 col-2 text-center">{{$treatment->appointment->appointment_date}}</td>
                     <td class="pt-3 col-2 text-center">₱{{ number_format($treatment->treatment_cost, 2) }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly gap-2">
                           <button class="btn admin-staff-btn  px-2 py-1 text-white" data-bs-toggle="modal"
                              data-bs-target="#usedSupplyModal{{$treatment->id}}"><i
                                 class="bi bi-plus-circle-fill fs-5"></i></button>

                           <button class="btn admin-staff-btn  px-2 py-1 text-white" data-bs-toggle="modal"
                              data-bs-target="#paymentModal{{$treatment->id}}">Payment</button>
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

@foreach ($treatments as $treatment)
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
<div class="modal fade" id="paymentModal{{ $treatment->id }}" tabindex="-1"
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
            <table class="table table-bordered">
               <thead>
                  <tr class="fs-5 text-center">
                     <th class="text-white" style="background-color:#00a1df !important;">Name</th>
                     <th class="text-white" style="background-color:#00a1df !important;">Quantity</th>
                     <th class="text-white" style="background-color:#00a1df !important;">Price per item</th>
                     <th class="text-white" style="background-color:#00a1df !important;">Subtotal</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($treatment->treatmentSupplies as $ts)
                  @php
                  $subtotal = $ts->quantity_used * $ts->supply->supply_price;
                  $totalSupplies += $subtotal;
                  @endphp
                  <tr style="font-size: 18px !important;" class="text-center">
                     <td>{{ $ts->supply->supply_name }}</td>
                     <td>{{ $ts->quantity_used }}</td>
                     <td>₱{{ number_format($ts->supply->supply_price, 2) }}</td>
                     <td>₱{{ number_format($subtotal, 2) }}</td>
                  </tr>
                  @endforeach
               </tbody>
               <tfoot>
                  <tr style="font-size: 18px !important;" class="text-center">
                     <th colspan="3" class="text-end">Total Used Supplies</th>
                     <th>₱{{ number_format($totalSupplies, 2) }}</th>
                  </tr>
               </tfoot>
            </table>
            @endif

            <hr>

            <p class="fs-5 py-2">Service Price: <span class="float-end">₱{{ number_format($servicePrice, 2) }}</span>
            </p>
            <h5 class="mt-3">Grand Total: <span class="float-end text-primary fw-bold">₱{{ number_format($servicePrice +
                  $totalSupplies, 2) }}</span></h5>
         </div>


         <div class="modal-footer pt-3">
            <form action="" method="POST">
               @csrf
               <button type="submit" class="btn admin-staff-btn px-2 py-1 text-white">Confirm Payment</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach