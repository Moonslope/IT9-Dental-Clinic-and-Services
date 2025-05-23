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
            <div class="col col-3">
               <h3>Supplier Lists</h3>
            </div>

            <div class="col">
               @php
               $user = Auth::user();
               $searchRoute = route('staff.supplier');
               if ($user && $user->role === 'admin') {
               $searchRoute = route('admin.supplier');
               }
               @endphp

               <form action="{{ $searchRoute }}" method="GET" class="d-flex w-75 gap-2">
                  <input type="text" id="search" name="search" class="form-control p-1" placeholder="Search"
                     value="{{ request('search') }}">
                  <button type="submit" class="btn admin-staff-btn">
                     <i class="bi bi-search fs-5 p-2 text-white"></i>
                  </button>
               </form>
            </div>

            <div class="col col-1">
               <button class="btn admin-staff-btn text-white w-100 p-1" data-bs-toggle="modal"
                  data-bs-target="#addSupplierModal">ADD <i class="ms-2 bi bi-plus-circle-fill"></i></button>
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
                     <th class="p-2 col-2">Contact Number</th>
                     <th class="p-2 col-5">Address</th>
                     <th class="p-2 col-1">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($suppliers->isEmpty())
         <p class="alert text-center text-secondary">No supplies available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($suppliers as $supplier)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2 col-2 ">{{ $supplier->supplier_name }}</td>
                     <td class="p-2 col-2">{{ $supplier->contact_number }}</td>
                     <td class="p-2 col-5">{{ $supplier->address }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly gap-2">
                           <div>
                              <button class="btn admin-staff-btn text-white w-100 px-2 py-1" data-bs-toggle="modal"
                                 data-bs-target="#editSupplierModal{{$supplier->id}}"><i
                                    class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <button type="button" class="btn admin-staff-btn text-white w-100 px-2 py-1"
                                 data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$supplier->id}}">
                                 <i class="bi bi-trash-fill"></i>
                              </button>

                              <!-- Confirmation Modal -->
                              <div class="modal fade" id="confirmDeleteModal{{$supplier->id}}" tabindex="-1"
                                 aria-labelledby="confirmDeleteModalLabel{{$supplier->id}}" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                       <div class="modal-header d-flex justify-content-between">
                                          <h4 class="modal-title">Confirm Deletion</h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                          <p class="my-4 fs-5 text-center">Are you sure you want to delete
                                             <strong>{{$supplier->supplier_name}}</strong> ?
                                          </p>
                                       </div>

                                       <div class="modal-footer row mt-3 gap-2 pt-3">
                                          <div class="col">
                                             <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                                data-bs-dismiss="modal">Cancel</button>
                                          </div>
                                          <div class="col">
                                             <form action="{{route('supplier.destroy', ['supplier' => $supplier])}}"
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

                  {{-- Modal to Edit supplier --}}
                  <div class="modal fade" id="editSupplierModal{{$supplier->id}}" tabindex="-1"
                     aria-labelledby="editSupplierModalLabel{{$supplier->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="editSupplierModalLabel{{$supplier->id}}">EDIT SUPPLIER</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">
                              <form action="{{route('supplier.update', ['supplier' => $supplier->id])}}" method="POST">
                                 @csrf
                                 @method('PUT')

                                 <input type="hidden" name="from_modal" value="editSupplierModal{{ $supplier->id }}">
                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="supplier_name"
                                          name="supplier_name" class="form-control p-2 @error('supplier_name') is-invalid @enderror"
                                          value="{{ $supplier->supplier_name }}">

                                          @error('supplier_name')
                                             <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                                          class="form-control p-2 @error('address') is-invalid @enderror" value="{{ $supplier->address }}">
                                          
                                          @error('address')
                                             <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                    </div>
                                 </div>

                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="contact_number"
                                          name="contact_number" class="form-control p-2 @error('contact_number') is-invalid @enderror"
                                          value="{{ $supplier->contact_number }}">

                                          @error('contact_number')
                                             <div class="text-danger small">{{ $message }}</div>
                                          @enderror
                                    </div>
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1"
                                          type="button" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col">

                                       <button class="btn w-100 admin-staff-btn fw-bold text-white p-1"
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
            @endif
         </div>
      </div>
   </div>

   {{-- Modal to Add supplier --}}
   <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel"
      aria-hidden="true">
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

                  <input type="hidden" name="from_modal" value="addSupplierModal">
                  <div class="row mb-3 gap-2">
                     <div class="col">
                        <input style="background-color: #d9d9d9" type="text" id="supplier_name" name="supplier_name"
                           placeholder="Name" class="form-control p-2 @error('supplier_name') is-invalid @enderror" value="{{ old('supplier_name') }}">

                           @error('supplier_name')
                              <div class="text-danger small">{{ $message }}</div>
                           @enderror
                     </div>

                  </div>

                  <div class="row mb-3 gap-2">
                     <div class="col">
                        <input style="background-color: #d9d9d9" type="text" id="contact_number" name="contact_number"
                           placeholder="Contact Number" class="form-control p-2 @error('contact_number') is-invalid @enderror" value="{{old('contact_number')}}">

                           @error('contact_number')
                              <div class="text-danger small">{{ $message }}</div>
                           @enderror
                     </div>
                  </div>

                  <div class="row mb-3 gap-2">
                     <div class="col">
                        <input style="background-color: #d9d9d9" type="text" id="address" name="address"
                           placeholder="Address" class="form-control p-2 @error('address') is-invalid @enderror" value="{{ old('address') }}">

                           @error('contact_number')
                              <div class="text-danger small">{{ $message }}</div>
                           @enderror
                     </div>
                  </div>

                  <div class="modal-footer row mt-3 gap-2 pt-3">
                     <div class="col">
                        <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1" type="button"
                           data-bs-dismiss="modal">Cancel</button>
                     </div>
                     <div class="col">

                        <button class="btn w-100 fw-bold admin-staff-btn text-white p-1" type="submit">Add</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


<script>
   @if ($errors->any())
      document.addEventListener('DOMContentLoaded', function(){
         const modalId = "{{ old('from_modal') }}";
         if(modalId){
            const modalElement = document.getElementById(modalId);
            if(modalElement){
               const myModal = new bootstrap.Modal(modalElement);
               myModal.show();
            }
         }
      });
   @endif
</script>