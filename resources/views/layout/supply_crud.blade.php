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
            <div class="col col-3">
               <h3>Supply Lists</h3>
            </div>

            <div class="col">
               @php
               $user = Auth::user();
               $searchRoute = route('staff.supply');
               if ($user && $user->role === 'admin') {
               $searchRoute = route('admin.supply');
               }
               @endphp

               <form action="{{ $searchRoute }}" method="GET" class="d-flex w-75 gap-2">
                  <input type="text" id="search" class="form-control" placeholder=" Search" name="search"
                     value="{{ request('search') }}">
                  <button class="btn admin-staff-btn"><i class="bi bi-search fs-5 p-2 text-white"></i></button>
               </form>
            </div>

            <div class="col col-1">
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
      <div style="height: 465px !important;" class="card-body">
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
                              <button type="button" class="btn admin-staff-btn text-white w-100 px-2 py-1"
                                 data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$supply->id}}">
                                 <i class="bi bi-trash-fill"></i>
                              </button>

                              <!-- Confirmation Modal -->
                              <div class="modal fade" id="confirmDeleteModal{{$supply->id}}" tabindex="-1"
                                 aria-labelledby="confirmDeleteModalLabel{{$supply->id}}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between">
                                          <h4 class="modal-title">Confirm Deletion</h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="my-4 fs-5 text-center">Are you sure you want to delete <strong>{{
                                                $supply->supply_name
                                                }}</strong>?</p>
                                       </div>

                                       <div class="modal-footer row mt-3 gap-2 pt-3">
                                          <div class="col">
                                             <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                                data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                          <div class="col">
                                             <form action="{{ route('supply.destroy', ['supply' => $supply]) }}"
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
                                       <select required name="supplier_id" class="form-select p-2 @error('supplier_id') is-invalid @enderror"
                                          style="background-color: #d9d9d9" required>
                                          <option value="" disabled selected>Select Supplier</option>
                                          @foreach($suppliers as $supplier)
                                          <option value="{{$supplier->id}}" name="supplier_id">
                                             {{$supplier->supplier_name}}
                                          </option>
                                          @endforeach

                                          @error('supplier_id')
                                              <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                       </select>
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" required type="number"
                                          name="quantity_received" min="1" class="form-control p-2 @error('quantity_received') is-invalid @enderror"
                                          placeholder="Quantity Received">

                                          @error('quantity_received')
                                              <div class="text-danger small">{{ $message }}</div>
                                          @enderror
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

                                 <input type="hidden" name="from_modal" value="editSupplyModal{{ $supply->id }}">
                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" name="supply_name"
                                          class="form-control p-2 @error('supply_name') is-invalid @enderror" value="{{$supply->supply_name}}">

                                          @error('supply_name')
                                             <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                    </div>
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="number" name="supply_quantity"
                                          min="1" class="form-control p-2 @error('supply_quantity') is-invalid @enderror" value="{{$supply->supply_quantity}}">

                                          @error('supply_quantity')
                                             <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                    </div>
                                 </div>

                                 <div class="row mb-3">
                                    <textarea style="background-color: #d9d9d9" name="supply_description"
                                       class="form-control pb-5 @error('supply_description') is-invalid @enderror">{{$supply->supply_description}}</textarea>

                                       @error('supply_description')
                                          <div class="text-danger small">{{ $message }}</div>
                                       @enderror
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn fw-bold w-100 p-1" type="button"
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

               <input type="hidden" name="from_modal" value="addSupplyModal">

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" name="supply_name" placeholder="Supply Name"
                        class="form-control p-2 @error('supply_name') is-invalid @enderror" value="{{ old('supply_name') }}">
                        
                        @error('supply_name')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                  </div>
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="numeric" name="supply_price" placeholder="Price"
                        class="form-control p-2 @error('supply_price') is-invalid @enderror" value="{{ old('supply_price') }}">

                        @error('supply_price')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                  </div>
               </div>

               <div class="row">
                  <textarea style="background-color: #d9d9d9" name="supply_description" class="form-control pb-5 @error('supply_description') is-invalid @enderror"
                     placeholder="Description"></textarea>

                     @error('supply_description')
                        <div class="text-danger small">{{ $message }}</div>
                     @enderror
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>

                  <div class="col">
                     <button class="btn admin-staff-btn w-100 fw-bold text-white p-1" type="submit">Add</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   @if ($errors->any()) 
      document.addEventListener('DOMContentLoaded', function() {
         const modalId = "{{ old('from_modal') }}";
         if (modalId) {
            const modalElement = document.getElementById(modalId);
            if (modalElement) {
               const myModal = new bootstrap.Modal(modalElement);
               myModal.show();
            }
         }
      });
   @endif
</script>