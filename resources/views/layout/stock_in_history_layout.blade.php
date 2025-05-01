<div class="row m-2">
   <div class="card shadow">
      <div class="card-body d-flex justify-content-between">

         <div class="row w-100 p-3">
            <div class="col">
               <h3>Stock In History</h3>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row px-2">
   <div style="height: 420px !important; overflow:hidden;" class="card">
      <div class="card-body">
         <div class="row">
            <table class="table">
               <tr style="font-size: 16px;" class="">
                  <th style="background-color: #00a1df !important;" class="p-2  text-white col-2">Name</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Quantity</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Date Received</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Supplier</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Staff</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Action</th>
               </tr>
            </table>
         </div>

         <div class="row" style="max-height: 380px; overflow-y: auto;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($stock_ins as $stock)
                  <tr style="font-size: 16px;" class="">
                     <td class="p-2 col-2">{{ $stock->supply->supply_name }}</td>
                     <td class="p-2 col-2">{{ $stock->quantity_received }}</td>
                     <td class="p-2 col-2">{{ $stock->date_received }}</td>
                     <td class="p-2 col-2">{{ $stock->supplier->supplier_name }}</td>
                     <td class="p-2 col-2">{{ $stock->user->first_name }} {{ $stock->user->last_name }}</td>
                     <td class="p-2 col-2">
                        <div class="d-flex justify-content-evenly">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editServiceModal"><i class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <form action="" method="POST">
                                 <input type="hidden" name="redirect_to">
                                 @csrf
                                 @method('delete')
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1"><i
                                       class="bi bi-trash-fill"></i></button>
                              </form>
                           </div>
                        </div>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>