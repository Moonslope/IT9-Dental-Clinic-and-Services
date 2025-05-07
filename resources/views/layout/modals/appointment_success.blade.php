<!-- appointment Modal -->
<div class="modal fade" id="appointmentSuccessModal" tabindex="-1" aria-labelledby="appointmentSuccessModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content ">
         <div class="modal-header mb-2">
            <h3 class="modal-title" id="appointmentSuccessModalLabel">Success</h3>
         </div>
         <div class="modal-body text-center">
            <h5 class="py-3">{{ session('appointment_success') }}</h5>
         </div>

         <div class="modal-footer row mt-3 gap-2 pt-3">
            <div class="col">
               <button type="button" class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                  data-bs-dismiss="modal">Okay</button>
            </div>
         </div>
      </div>
   </div>
</div>

@if(session('appointment_success'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
   let appointmentModal = new bootstrap.Modal(document.getElementById('appointmentSuccessModal'));
   appointmentModal.show();
});
</script>
@endif