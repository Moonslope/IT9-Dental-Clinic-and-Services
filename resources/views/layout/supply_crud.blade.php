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
               <h3>Supply Lists</h3>
            </div>

            <div class="col col-2">
               <button class="btn btn-dark w-100 p-1" data-bs-toggle="modal" data-bs-target="#addSupplyModal">
                  ADD <i class="ms-2 bi bi-plus-circle-fill"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div class="card">
      <div class="card-body p-1">
         @if($supplies->isEmpty())
         <p class="alert text-center text-secondary">No supplies available.</p>
         @else
         <div style="max-height: 420px !important; overflow-y: auto;">
            @foreach ($supplies as $supply)
            <div class="">
               <ul class="list-group mb-1">
                  <li class="list-group-item d-flex align-items-center justify-content-between border border-2">
                     <div class="d-flex justify-content-between align-items-center w-100 px-2">
                        <div>
                           <span><strong>Name: </strong>{{$supply->supply_name}}</span><br>
                           <span><strong>Quantity: </strong>{{$supply->supply_quantity}}</span><br>
                           <span><strong>Description: </strong>{{$supply->supply_description}}</span>
                        </div>

                        <div class="d-flex gap-3">
                           <div>
                              <button class="btn btn-dark w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#stockInSupplyModal{{$supply->id}}">
                                 Stock In</i>
                              </button>
                           </div>

                           <div>
                              <button class="btn btn-dark w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editSupplyModal{{$supply->id}}">
                                 <i class="bi bi-pencil-square"></i>
                              </button>
                           </div>

                           <div>
                              <form action="{{ route('supply.destroy', ['supply' => $supply]) }}" method="POST">
                                 <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                 @csrf
                                 @method('delete')
                                 <button class="btn btn-dark w-100 px-2 py-1">
                                    <i class="bi bi-trash-fill"></i>
                                 </button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>

            {{-- Stock in modal --}}
            <div class="modal fade" id="stockInSupplyModal{{$supply->id}}" tabindex="-1"
               aria-labelledby="stockInSupplyModalLabel{{$supply->id}}" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                  <div class="modal-content">
                     <div class="modal-header fw-semibold d-flex justify-content-between">
                        <h5 class="modal-title" id="stockInSupplyModalLabel{{$supply->id}}">Stock In</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>

                     <div class="modal-body mt-3">
                        <form action="{{ route('supply.stockin') }}" method="POST">
                           @csrf

                           <input type="text" name="supply_id" value="{{$supply->id}}" hidden>
                           <input type="text" name="user_id" value="{{$user->id}}" hidden>

                           <div class="row mb-3 gap-2">
                              <div class="col">
                                 <input style="background-color: #d9d9d9" type="text" name="supply_name"
                                    class="form-control p-2" value="{{$supply->supply_name}}">
                              </div>
                           </div>

                           <div class="row mb-3">
                              <div class="col">
                                 <select name="supplier_id" class="form-select p-2" style="background-color: #d9d9d9"
                                    required>
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
                                 <input style="background-color: #d9d9d9" type="number" name="quantity_received" min="1"
                                    class="form-control p-2" placeholder="Quantity Received">
                              </div>

                           </div>



                           <div class="modal-footer row mt-3 gap-2 pt-3">
                              <div class="col">
                                 <button class="btn btn-outline-info text-black fw-bold w-100 p-1" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                              </div>
                              <div class="col">

                                 <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
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
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                 <input style="background-color: #d9d9d9" type="number" name="supply_quantity" min="1"
                                    class="form-control p-2" value="{{$supply->supply_quantity}}">
                              </div>
                           </div>

                           <div class="row mb-3">
                              <textarea style="background-color: #d9d9d9" name="supply_description"
                                 class="form-control pb-5">{{$supply->supply_description}}</textarea>
                           </div>

                           <div class="modal-footer row mt-3 gap-2 pt-3">
                              <div class="col">
                                 <button class="btn btn-outline-info text-black fw-bold w-100 p-1" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                              </div>
                              <div class="col">
                                 <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                                 <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                                    type="submit">Update</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
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
                     <input style="background-color: #d9d9d9" type="number" disabled name="supply_quantity"
                        placeholder="Quantity" class="form-control p-2">
                  </div>
               </div>

               <div class="row">
                  <textarea style="background-color: #d9d9d9" name="supply_description" class="form-control pb-5"
                     placeholder="Description"></textarea>
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn btn-outline-info text-black fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>
                  <div class="col">

                     <input type="hidden" name="redirect_to" value=" {{ $redirect_route }}">
                     <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                        type="submit">Add</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>