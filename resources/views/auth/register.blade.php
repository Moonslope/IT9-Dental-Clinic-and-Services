@extends('layout.layout')

@section('title', 'Register')

@section('content')
<div style="background-color: #1e466b;" class="container-fluid vh-100">
   <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-md-10 col-lg-8">
         <div class="card shadow p-3">
            <div class="card-body px-3">
               <h1 style="color:#1e466b;" class="fw-bold">Registration</h1>
               <p class="pb-3 text-secondary">Fill out the fields to create an account.</p>
               <hr>

               <form action="{{ route('register') }}" method="POST">
                  @csrf

                  <div class="row pt-4 gap-3">
                     <div class="col">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control p-2">
                     </div>
                     <div class="col">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control p-2">
                     </div>
                  </div>

                  <div class="row pt-3 gap-3">
                     {{-- <div class="col col-12 col-md-2">
                        <label for="age">Age</label>
                        <input type="number" id="age" name="age" class="form-control p-2">
                     </div>
                     {{-- <div class="col col-12 col-md-2">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control p-2">
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                        </select>
                     </div> --}}
                     <div class="col col-12 col-md-6">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control p-2">
                     </div>
                     <div class="col">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control p-2">
                     </div>
                  </div>

                  <div class="row pt-3 gap-3">
                     <div class="col col-12 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control p-2">
                     </div>
                     <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control p-2">
                     </div>
                  </div>

                  <input type="text" hidden name="role" value="patient">

                  <div class="pt-4 d-flex flex-column flex-md-row gap-3">
                     <a href=" {{ route('login') }}" class="btn cancel-btn w-100 p-2 rounded-pill fw-bold text-center">Cancel</a>
                     <button type="submit"
                        class="btn log-reg w-100 p-2 rounded-pill fw-bold text-white">Register</button>
                  </div>

                  <p class="text-center mt-3">Already have an account? <a href="{{route('login')}}"
                        class="text-info">Login</a></p>
               </form>

            </div>
         </div>
      </div>
   </div>
</div>
@endsection



{{-- @extends('layout.layout')

@section('title', 'Register')

@section('content')
<div style="background-color: #1e466b;" class="container-fluid vh-100">
   <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-md-10 col-lg-8">
         <div class="card shadow p-3">
            <div class="card-body">
               <div class="row">
                  <div class="col col-12 col-md-6 p-4">
                     <h1 style="color:#1e466b;" class="text-center fw-bold">Register</h1>
                     <p class="text-center text-secondary">Create your account to get started.</p>

                     <div class="pt-4">
                        <form action="{{ route('register') }}" method="POST">
                           @csrf

                           <div class="mb-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" id="name" name="name" class="form-control p-2 rounded-pill"
                                 value="{{ old('name') }}">
                              @error('name')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>

                           <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" id="email" name="email" class="form-control p-2 rounded-pill"
                                 value="{{ old('email') }}">
                              @error('email')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>

                           <div class="mb-3">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" id="password" name="password"
                                 class="form-control p-2 rounded-pill">
                              @error('password')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>

                           <div class="mb-3">
                              <label for="password_confirmation" class="form-label">Confirm Password</label>
                              <input type="password" id="password_confirmation" name="password_confirmation"
                                 class="form-control p-2 rounded-pill">
                           </div>

                           <div class="mb-3">
                              <label for="contact_number" class="form-label">Contact Number</label>
                              <input type="text" id="contact_number" name="contact_number"
                                 class="form-control p-2 rounded-pill" value="{{ old('contact_number') }}">
                              @error('contact_number')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>

                           <div class="mb-3">
                              <label for="address" class="form-label">Address</label>
                              <input type="text" id="address" name="address" class="form-control p-2 rounded-pill"
                                 value="{{ old('address') }}">
                              @error('address')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>

                           <div class="mb-3">
                              {{-- <label for="role" class="form-label">Role (Optional)</label>
                              <select id="role" name="role" class="form-control p-2 rounded-pill">
                                 <option value="">Select Role</option>
                                 <option value="patient" {{ old('role')=='patient' ? 'selected' : '' }}>Patient</option>
                                 <option value="dentist" {{ old('role')=='dentist' ? 'selected' : '' }}>Dentist</option>
                                 <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>Staff</option>
                              </select>
                              @error('role')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror

                              <input type="text" name="role" value="patient" hidden>
                           </div>


                           <input type="submit" value="Register"
                              class="btn log-reg form-control p-2 rounded-pill fw-bold text-white mt-3"
                              style="background-color: #1e466b;">
                           <p class="text-center mt-3">Already have an account? <a href="{{ route('login') }}"
                                 class="text-info">Login</a></p>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection --}}