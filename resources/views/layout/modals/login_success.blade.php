<!-- login Modal -->
<div class="modal fade" id="loginSuccessModal" tabindex="-1" aria-labelledby="loginSuccessModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-success">
         <div class="modal-header text-dark mb-2">
            <h3 class="modal-title" id="loginSuccessModalLabel">Success</h3>
         </div>
         <div class="modal-body text-center">
            <i class="bi bi-check-circle fs-1 text-success"></i>
            <h5 class="py-3">{{ session('login_success') }}</h5>
         </div>

         <div class="modal-footer row mt-3 gap-2 pt-3">
            <div class="col">
               <button type="button" class="btn w-100 fw-bold admin-staff-btn text-white p-1"
                  data-bs-dismiss="modal">Continue</button>
            </div>
         </div>
      </div>
   </div>
</div>

@if(session('login_success'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
   let loginModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'));
   loginModal.show();
});
</script>
@endif