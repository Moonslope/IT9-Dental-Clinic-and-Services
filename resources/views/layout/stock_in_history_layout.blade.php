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
               <h3>Stock In History</h3>
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
                  <th style="background-color: #00a1df !important;" class="p-2  text-white col-2">Name</th>
                  <th style="background-color: #00a1df !important;" class="p-1 text-white col-1">Quantity Received</th>
                  <th style="background-color: #00a1df !important;" class="p-1 text-white col-1">Total Quantity</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Date Received</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Supplier</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Staff</th>
                  <th style="background-color: #00a1df !important;" class="p-2 text-white col-2">Action</th>
               </tr>
            </table>
         </div>

         @if($stock_ins->isEmpty())
         <p class="alert text-center text-secondary">No stock in available.</p>
         @else

         <div class="row" style="max-height: 380px; overflow-y: auto;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($stock_ins as $stock)
                  <tr style="font-size: 16px;" class="">
                     <td class="p-2 col-2">{{ $stock->supply->supply_name }}</td>
                     <td class="p-2 col-1">{{ $stock->quantity_received }}</td>
                     <td class="p-2 col-1">{{ $stock->total_quantity }}</td>
                     <td class="p-2 col-2">{{ $stock->date_received }}</td>
                     <td class="p-2 col-2">{{ $stock->supplier->supplier_name }}</td>
                     <td class="p-2 col-2">{{ $stock->user->first_name }} {{ $stock->user->last_name }}</td>
                     <td class="p-2 col-2">
                        <div class="d-flex justify-content-evenly">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editStockModal{{ $stock->id }}"><i
                                    class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <button type="button" class="btn admin-staff-btn text-white w-100 px-2 py-1"
                                 data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$stock->id}}">
                                 <i class="bi bi-trash-fill"></i>
                              </button>

                              <!-- Confirmation Modal -->
                              <div class="modal fade" id="confirmDeleteModal{{$stock->id}}" tabindex="-1"
                                 aria-labelledby="confirmDeleteModalLabel{{$stock->id}}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between">
                                          <h4 class="modal-title">Confirm Deletion</h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="my-4 fs-5 text-center">Are you sure you want to delete this stock
                                             in?</p>
                                       </div>

                                       <div class="modal-footer row mt-3 gap-2 pt-3">
                                          <div class="col">
                                             <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                                data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                          <div class="col">
                                             <form action="{{route('stock_in.destroy', ['stock' =>$stock])}}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                   class="btn btn-danger w-100 text-white p-1">Delete</button>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <div class="modal fade" id="editStockModal{{ $stock->id }}" tabindex="-1">
                     <div class="modal-dialog">
                        <div class="modal-content">

                           <form action="{{ route('stock_in.update', ['stock' =>$stock]) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-header d-flex justify-content-between">
                                 <h5 class="modal-title">Edit Stock In</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>

                              <div class="modal-body mt-3">
                                 <div class="mb-3">
                                    <label for="quantity " class="form-label fs-5 mb-2">Quantity</label>
                                    <input style="background-color: #d9d9d9" type="number" class="form-control p-2"
                                       name="quantity_received" value="{{ $stock->quantity_received }}" required>
                                 </div>
                                 <div class="mb-3">
                                    <label for="date_received" class="form-label fs-5 mb-2">Date Received</label>
                                    <input style="background-color: #d9d9d9" type="date" class="form-control p-2"
                                       name="date_received" value="{{ $stock->date_received }}" required>
                                 </div>

                              </div>
                              <div class="modal-footer d-flex gap-2 mt-3">
                                 <div class="col">
                                    <button class="btn admin-staff-cancel-btn  fw-bold w-100 p-1" type="button"
                                       data-bs-dismiss="modal">Cancel</button>
                                 </div>
                                 <div class="col">
                                    <button class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                                       type="submit">Update</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>