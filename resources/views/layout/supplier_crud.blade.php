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
               <h3>Supplier Lists</h3>
            </div>

            <div class="col col-2">
               <button class="btn btn-dark w-100 p-1" data-bs-toggle="modal" data-bs-target="#addSupplierModal">ADD <i
                     class="ms-2 bi bi-plus-circle-fill"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row m-2">
   <div class="card">
      <div class="card-body p-1">

         @if($suppliers->isEmpty())
         <p class="alert text-center text-secondary">No Suppliers available.</p>
         @else
         @foreach ($suppliers as $supplier)
         <div class="">
            <ul class="list-group mb-1 ">
               <li class="list-group-item d-flex align-items-center justify-content-between border border-2">
                  <div class="d-flex justify-content-between align-items-center w-100 px-2">
                     <div class="">
                        <span><strong>Name: </strong>{{$supplier->supplier_name}}</span><br>
                        <span><strong>Address: </strong>{{$supplier->address}}</span><br>
                        <span><strong>Contact Number: </strong>{{$supplier->contact_number}}</span>
                     </div>

                     <div class="d-flex gap-3">
                        <div>
                           <button class="btn btn-dark w-100 px-2 py-1" data-bs-toggle="modal"
                              data-bs-target="#editSupplierModal{{$supplier->id}}"><i
                                 class="bi bi-pencil-square"></i></button>
                        </div>

                        <div>
                           <form action="{{route('supplier.destroy', ['supplier' => $supplier])}}" method="POST">
                              @csrf
                              @method('delete')

                              <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                              <button class="btn btn-dark w-100 px-2 py-1"><i class="bi bi-trash-fill"></i></button>
                           </form>
                        </div>
                     </div>
                  </div>
               </li>
            </ul>
         </div>

         {{-- Modal to Edit supplier --}}
         <div class="modal fade" id="editSupplierModal{{$supplier->id}}" tabindex="-1"
            aria-labelledby="editSupplierModalLabel{{$supplier->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
               <div class="modal-content">
                  <div class="modal-header fw-semibold d-flex justify-content-between">
                     <h5 class="modal-title" id="editSupplierModalLabel{{$supplier->id}}">EDIT SUPPLIER</h5>
                     <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body mt-3">
                     <form action="{{route('supplier.update', ['supplier' => $supplier->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3 gap-2">
                           <div class="col">
                              <input style="background-color: #d9d9d9" type="text" id="supplier_name"
                                 name="supplier_name" class="form-control p-2" value="{{ $supplier->supplier_name }}">
                           </div>


                        </div>

                        <div class="row mb-3 gap-2">
                           <div class="col">
                              <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                                 class="form-control p-2" value="{{ $supplier->address }}">
                           </div>
                        </div>

                        <div class="row mb-3 gap-2">
                           <div class="col">
                              <input style="background-color: #d9d9d9" type="text" id="contact_number"
                                 name="contact_number" class="form-control p-2" value="{{ $supplier->contact_number }}">
                           </div>
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
         @endif

      </div>
   </div>
</div>

{{-- Modal to Add supplier --}}
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">

      <div class="modal-content">
         <div class="modal-header fw-semibold d-flex justify-content-between">
            <h5 class="modal-title" id="addSupplierModalLabel">ADD SUPPLIER</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">
            <form action="{{route('supplier.store')}}" method="POST">
               @csrf
               @method('POST')
               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="supplier_name" name="supplier_name"
                        placeholder="Name" class="form-control p-2">
                  </div>

               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="contact_number" name="contact_number"
                        placeholder="Contact Number" class="form-control p-2">
                  </div>
               </div>

               <div class="row mb-3 gap-2">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                        placeholder="Address" class="form-control p-2">
                  </div>
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn btn-outline-info text-black fw-bold w-100 p-1" type="button"
                        data-bs-dismiss="modal">Cancel</button>
                  </div>
                  <div class="col">
                     <input type="hidden" name="redirect_to" value="{{ $redirect_route }}">
                     <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                        type="submit">Add</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>