<!-- added Modal -->
<div class="modal fade" id="addedSuccessModal" tabindex="-1" aria-labelledby="addedSuccessModalLabel"
   aria-hidden="true">
   <div style="padding: 0px !important;" class="modal-dialog modal-dialog-centered">
      <div style="padding: 0px !important;" class="modal-content">
         <div class=" mb-2 d-flex justify-content-end">
            <button type="button" class="btn-close p-2" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body text-center">
            <img class="me-3" height="65" width="65" src="{{ asset('images/checkmark.png') }}" alt="Clinic Logo">
            <h4 class="pt-3">@yield('text'){{ session('added_success') }}</h4>
         </div>

         <div class=" row mt-3 gap-2">
            <div class="col p-2">
               <button type="button" class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                  data-bs-dismiss="modal">Okay</button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- deleted Modal -->
<div class="modal fade" id="deletedSuccessModal" tabindex="-1" aria-labelledby="deletedSuccessModalLabel"
   aria-hidden="true">
   <div style="padding: 0px !important;" class="modal-dialog modal-dialog-centered">
      <div style="padding: 0px !important;" class="modal-content">
         <div class=" mb-2 d-flex justify-content-end">
            <button type="button" class="btn-close p-2" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body text-center">
            <img class="me-3" height="65" width="65" src="{{ asset('images/checkmark.png') }}" alt="Clinic Logo">
            <h4 class="pt-3">@yield('text'){{ session('deleted_success') }}</h4>
         </div>

         <div class=" row mt-3 gap-2">
            <div class="col p-2">
               <button type="button" class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                  data-bs-dismiss="modal">Okay</button>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- updated Modal -->
<div class="modal fade" id="updatedSuccessModal" tabindex="-1" aria-labelledby="updatedSuccessModalLabel"
   aria-hidden="true">
   <div style="padding: 0px !important;" class="modal-dialog modal-dialog-centered">
      <div style="padding: 0px !important;" class="modal-content">
         <div class=" mb-2 d-flex justify-content-end">
            <button type="button" class="btn-close p-2" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body text-center">
            <img class="me-3" height="65" width="65" src="{{ asset('images/checkmark.png') }}" alt="Clinic Logo">
            <h4 class="pt-3">@yield('text'){{ session('updated_success') }}</h4>
         </div>

         <div class=" row mt-3 gap-2">
            <div class="col p-2">
               <button type="button" class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                  data-bs-dismiss="modal">Okay</button>
            </div>
         </div>
      </div>
   </div>
</div>




@if(session('added_success'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
   let addedModal = new bootstrap.Modal(document.getElementById('addedSuccessModal'));
   addedModal.show();
});
</script>

@elseif(session('updated_success'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
   let updatedModal = new bootstrap.Modal(document.getElementById('updatedSuccessModal'));
   updatedModal.show();
});
</script>

@elseif(session('deleted_success'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
   let deletedModal = new bootstrap.Modal(document.getElementById('deletedSuccessModal'));
   deletedModal.show();
});

</script>


@endif