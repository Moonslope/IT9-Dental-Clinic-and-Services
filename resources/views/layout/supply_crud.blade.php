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
         <div class="row w-100 p-3 gap-3">
            <div class="col">
               <h3>Supply Lists</h3>
            </div>

            <div class="col col-2">
               <button class="btn admin-staff-btn text-white w-100 p-1" data-bs-toggle="modal"
                  data-bs-target="#addSupplyModal">
                  ADD <i class="ms-2 bi bi-plus-circle-fill"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div style="overflow: hidden;" class="card">
      <div class="card-body">
         <div class="row">
            <table>
               <thead class="">
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Name</th>
                     <th class="p-2 col-1">Price</th>
                     <th class="p-2 col-1">Quantity</th>
                     <th class="p-2 col-5">Description</th>
                     <th class="p-2 col-2">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($supplies->isEmpty())
         <p class="alert text-center text-secondary">No supplies available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($supplies as $supply)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2 col-2 ">{{ $supply->supply_name }}</td>
                     <td class="p-2 col-1 ">{{ $supply->supply_price }}</td>
                     <td class="p-2 col-1">{{ $supply->supply_quantity }}</td>
                     <td class="p-2 col-5">{{ $supply->supply_description }}</td>
                     <td class="p-2 col-2">
                        <div class="d-flex justify-content-evenly gap-2">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#stockInSupplyModal{{$supply->id}}">
                                 Stock In</i>
                              </button>
                           </div>
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editSupplyModal{{$supply->id}}">
                                 <i class="bi bi-pencil-square"></i>
                              </button>
                           </div>

                           <div>
                              <form action="{{ route('supply.destroy', ['supply' => $supply]) }}" method="POST">
                                 <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                 @csrf
                                 @method('delete')
                                 <button class="btn admin-staff-btn text-white w-100 px-2 py-1">
                                    <i class="bi bi-trash-fill"></i>
                                 </button>
                              </form>
                           </div>
                        </div>
                     </td>
                  </tr>

                  {{-- Stock in modal --}}
                  <div class="modal fade" id="stockInSupplyModal{{$supply->id}}" tabindex="-1"
                     aria-labelledby="stockInSupplyModalLabel{{$supply->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="stockInSupplyModalLabel{{$supply->id}}">Stock In</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">
                              <form action="{{ route('supply.stock_in') }}" method="POST">
                                 @csrf

                                 <input type="text" name="supply_id" value="{{$supply->id}}" hidden>
                                 <input type="text" name="user_id" value="{{$user->id}}" hidden>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" name="supply_name"
                                          class="form-control p-2" disabled value="{{$supply->supply_name}}">
                                    </div>
                                 </div>

                                 <div class="row mb-3">
                                    <div class="col">
                                       <select required name="supplier_id" class="form-select p-2"
                                          style="background-color: #d9d9d9" required>
                                          <option value="" disabled selected>Select Supplier</option>
                                          @foreach($suppliers as $supplier)
                                          <option value="{{$supplier->id}}" name="supplier_id">
                                             {{$supplier->supplier_name}}
                                          </option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" required type="number"
                                          name="quantity_received" min="1" class="form-control p-2"
                                          placeholder="Quantity Received">
                                    </div>

                                    <div class="col">
                                       <input style="background-color: #d9d9d9" required type="date"
                                          name="date_received" min="1" class="form-control p-2"
                                          placeholder="Date Received">
                                    </div>
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1"
                                          type="button" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col">

                                       <button class="btn w-100 admin-staff-btn fw-bold text-white p-1"
                                          type="submit">ADD</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- Edit Modal --}}
                  <div class="modal fade" id="editSupplyModal{{$supply->id}}" tabindex="-1"
                     aria-labelledby="editSupplyModalLabel{{$supply->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="editSupplyModalLabel{{$supply->id}}">EDIT Supply</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">
                              <form action="{{ route('supply.update', ['supply' => $supply]) }}" method="POST">
                                 @csrf
                                 @method('put')
                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" name="supply_name"
                                          class="form-control p-2" value="{{$supply->supply_name}}">
                                    </div>
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="number" name="supply_quantity"
                                          min="1" class="form-control p-2" value="{{$supply->supply_quantity}}">
                                    </div>
                                 </div>

                                 <div class="row mb-3">
                                    <textarea style="background-color: #d9d9d9" name="supply_description"
                                       class="form-control pb-5">{{$supply->supply_description}}</textarea>
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn fw-bold w-100 p-1" type="button"
                                          data-bs-dismiss="modal">Cancel</button>
                                    </div>

                                    <div class="col">
                                       <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                       <button class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                                          type="submit">Update</button>
                                    </div>
                                 </div>
                              </form>
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

{{-- Modal to Add Supply --}}
<div class="modal fade" id="addSupplyModal" tabindex="-1" aria-labelledby="addSupplyModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
      <div class="modal-content">
         <div class="modal-header fw-semibold d-flex justify-content-between">
            <h5 class="modal-title" id="addSupplyModalLabel">ADD SUPPLY</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">

            <form action="{{ route('supply.store') }}" method="POST">
               @csrf
               @method('POST')
               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" name="supply_name" placeholder="Supply Name"
                        class="form-control p-2">
                  </div>
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="numeric" name="supply_price" placeholder="Price"
                        class="form-control p-2">
                  </div>
               </div>

               <div class="row">
                  <textarea style="background-color: #d9d9d9" name="supply_description" class="form-control pb-5"
                     placeholder="Description"></textarea>
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>

                  <div class="col">
                     <input type="hidden" name="redirect_to" value=" {{ $redirect_route }}">
                     <button class="btn admin-staff-btn w-100 fw-bold text-white p-1" type="submit">Add</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>