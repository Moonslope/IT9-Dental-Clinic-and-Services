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

@php
$user = Auth::user();
$searchRoute = route('staff.service');
if ($user && $user->role === 'admin') {
$searchRoute = route('admin.service');
}
@endphp

<div class="row m-2">
   <div class="card shadow">
      <div class="card-body d-flex justify-content-between">
         <div class="row w-100 p-3">
            <div class="col col-3">
               <h3>Services Lists</h3>
            </div>
            <div class="col">
               <form action="{{ $searchRoute }}" method="GET" class="d-flex w-75 gap-2">
                  <input type="text" name="search" class="form-control p-1" placeholder="Search"
                     value="{{ request('search') }}">
                  <button type="submit" class="btn admin-staff-btn">
                     <i class="bi bi-search fs-5 p-2 text-white"></i>
                  </button>
               </form>
            </div>
            <div class="col col-1">
               <button class="btn admin-staff-btn w-100 p-1 text-white" data-bs-toggle="modal"
                  data-bs-target="#addServiceModal">ADD <i class="ms-2 bi bi-plus-circle-fill"></i></button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row mx-2">
   <div style="overflow: hidden" class="card">
      <div style="height: 465px !important; " class="card-body">
         <div class="row">
            <table>
               <thead class="">
                  <tr style="font-size: 16px; background-color:#00a1df !important;" class="text-white">
                     <th class="p-2 col-2">Name</th>
                     <th class="p-2 col-1">Base Price</th>
                     <th class="p-2 col-2">Estimated Max Price</th>
                     <th class="p-2 col-4">Description</th>
                     <th class="p-2 col-1">Action</th>
                  </tr>
               </thead>
            </table>
         </div>

         @if($services->isEmpty())
         <p class="alert text-center text-secondary">No services available.</p>
         @else
         <div style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">
            <table class="table table-bordered">
               <tbody>
                  @foreach ($services as $service)
                  <tr style="font-size: 16px;" class="bg-secondary">
                     <td class="p-2 col-2 ">{{ $service->service_name }}</td>
                     <td class="p-2 col-1">{{ $service->base_price }}</td>
                     <td class="p-2 col-2">{{ $service->estimated_max_price }}</td>
                     <td class="p-2 col-4">{{ $service->service_description }}</td>
                     <td class="p-2 col-1">
                        <div class="d-flex justify-content-evenly">
                           <div>
                              <button class="btn admin-staff-btn w-100 px-2 py-1 text-white" data-bs-toggle="modal"
                                 data-bs-target="#editServiceModal{{$service->id}}"><i
                                    class="bi bi-pencil-square"></i></button>
                           </div>

                           <div>
                              <button type="button" class="btn admin-staff-btn text-white w-100 px-2 py-1"
                                 data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{$service->id}}">
                                 <i class="bi bi-trash-fill"></i>
                              </button>
                           </div>
                        </div>
                     </td>
                  </tr>

                  <!-- Confirmation Modal -->
                  <div class="modal fade" id="confirmDeleteModal{{$service->id}}" tabindex="-1"
                     aria-labelledby="confirmDeleteModalLabel{{$service->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                           <div class="modal-header d-flex justify-content-between">
                              <h4 class="modal-title">Confirm Deletion</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                              <p class="my-4 fs-5 text-center">Are you sure you want to delete <strong>{{
                                    $service->service_name
                                    }}</strong>?</p>
                           </div>

                           <div class="modal-footer row mt-3 gap-2 pt-3">
                              <div class="col">
                                 <button type="button" class="btn admin-staff-cancel-btn w-100 p-1"
                                    data-bs-dismiss="modal">Cancel</button>
                              </div>
                              <div class="col">
                                 <form action="{{ route('service.destroy', ['service' => $service]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger w-100 text-white p-1">Delete</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  {{-- edit modal --}}
                  <div class="modal fade" id="editServiceModal{{$service->id}}" tabindex="-1"
                     aria-labelledby="editServiceModalLabel{{$service->id}}" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
                        <div class="modal-content">
                           <div class="modal-header fw-semibold d-flex justify-content-between">
                              <h5 class="modal-title" id="editServiceModalLabel{{$service->id}}">EDIT Service</h5>
                              <button class="btn-close" type="button" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                           </div>

                           <div class="modal-body mt-3">
                              <form action="{{route('service.update', ['service' => $service])}}" method="POST">
                                 @csrf
                                 @method('put')
                                 <div class="row mb-3 gap-2">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="text" id="ServiceName"
                                          name="service_name" class="form-control p-2"
                                          value="{{$service->service_name}}">
                                    </div>
                                 </div>

                                 <div class="row gap-2 mb-3">
                                    <div class="col">
                                       <input style="background-color: #d9d9d9" type="number" id="ServicePrice"
                                          name="base_price" placeholder="Base price" class="form-control p-2"
                                          value="{{$service->base_price}}">
                                    </div>

                                    <div class=" col">
                                       <input style="background-color: #d9d9d9" type="number" id="ServicePrice"
                                          name="estimated_max_price" placeholder="Estimated max price"
                                          class="form-control p-2" value="{{$service->estimated_max_price}}">
                                    </div>
                                 </div>

                                 <div class=" row mb-3">
                                    <textarea style="background-color: #d9d9d9" name="service_description"
                                       id="ServiceDescription"
                                       class="form-control pb-5">{{$service->service_description}}</textarea>
                                 </div>

                                 <div class="modal-footer row mt-3 gap-2 pt-3">
                                    <div class="col">
                                       <button class="btn admin-staff-cancel-btn text-black fw-bold w-100 p-1"
                                          type="button" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    <div class="col">

                                       <button class="btn admin-staff-btn w-100 fw-bold text-white p-1"
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
</div>

{{-- Modal to Add supplies --}}
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">

      <div class="modal-content">
         <div class="modal-header fw-semibold d-flex justify-content-between">
            <h5 class="modal-title" id="addServiceModalLabel">ADD SERVICE</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>

         <div class="modal-body mt-3">
            <form action="{{route('service.store')}}" method="POST">
               @csrf
               @method('POST')
               <div class="row mb-3">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="text" id="ServiceName" name="service_name"
                        placeholder="Service Name" class="form-control p-2 @error('service_name') is-invalid @enderror"
                        value="{{ old('service_name') }}">

                     @error('service_name')
                     <div class="text-danger small">{{ $message }}</div>
                     @enderror
                  </div>
               </div>

               <div class="row gap-2 mb-3">
                  <div class="col">
                     <input style="background-color: #d9d9d9" type="number" id="ServicePrice" name="base_price"
                        placeholder="Base price" class="form-control p-2 @error('base_price') is-invalid @enderror"
                        value="{{ old('base_price') }}">

                     @error('base_price')
                     <div class="text-danger small">{{ $message }}</div>
                     @enderror
                  </div>

                  <div class="col">
                     <input style="background-color: #d9d9d9" type="number" id="ServicePrice" name="estimated_max_price"
                        placeholder="Estimated max price"
                        class="form-control p-2 @error('estimated_max_price') is-invalid @enderror">

                     @error('estimated_max_price')
                     <div class="text-danger small">{{ $message }}</div>
                     @enderror
                  </div>
               </div>

               <div class="row">
                  <textarea style="background-color: #d9d9d9" name="service_description" id="ServiceDescription"
                     class="form-control pb-5" placeholder="Description"></textarea>
               </div>

               <div class="modal-footer row mt-3 gap-2 pt-3">
                  <div class="col">
                     <button class="btn admin-staff-cancel-btn fw-bold w-100 p-1" type="button"
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
      document.addEventListener('DOMContentLoaded', function(){
         var myModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
         myModal.show();
      });
   @endif

   // Clear errors when Add Service modal is closed
   document.addEventListener('DOMContentLoaded', function() {
      var addServiceModal = document.getElementById('addServiceModal');
      if (addServiceModal) {
         addServiceModal.addEventListener('hidden.bs.modal', function () {
            // Remove all error messages
            addServiceModal.querySelectorAll('.text-danger.small').forEach(function(el) {
               el.remove();
            });
            // Remove is-invalid class from all inputs
            addServiceModal.querySelectorAll('.is-invalid').forEach(function(input) {
               input.classList.remove('is-invalid');
            });
            // Optionally, reset the form fields (uncomment if you want to clear all fields)
            // addServiceModal.querySelector('form').reset();
         });
      }
   });
</script>