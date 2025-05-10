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
               <h3>Stock Out History</h3>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row px-2">
   <div style="height: 465px !important; overflow:hidden;" class="card">
      <div class="card-body">
         <div class="row">
            <table class="table">
               <tr style="font-size: 16px;" class="">
                  <th style="background-color: #00a1df !important;" class="p-2  text-white col-2">Treatments ID</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Name</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Quantity Used</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Total Quantity</th>
               </tr>
            </table>
         </div>

         @if($stock_outs->isEmpty())
         <p class="alert text-center text-secondary">No stock out available.</p>
         @else

         <div class="row" style="max-height: 380px; overflow-y: auto;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($stock_outs as $stock)
                  <tr style="font-size: 16px;" class="">
                     <td class="p-2 col-2">{{ $stock->treatment_id }}</td>
                     <td class="p-2 col-2">{{ $stock->supply->supply_name }}</td>
                     <td class="p-2 col-2">{{ $stock->quantity_used }}</td>
                     <td class="p-2 col-2">{{ $stock->total_quantity }}</td>
                  </tr>

                  @endforeach
                  @endif
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>