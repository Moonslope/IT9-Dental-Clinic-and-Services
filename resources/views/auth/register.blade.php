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
                        <input type="text" id="first_name" name="first_name" class="form-control p-2" value="{{ old('first_name') }}">

                        @error('first_name')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control p-2" value="{{ old('last_name') }}">

                        @error('last_name')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <div class="row pt-3 gap-3">
                     <div class="col col-12 col-md-6">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" class="form-control p-2" value="{{ old('address') }}">

                        @error('address')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control p-2" value="{{ old('contact_number') }}">

                        @error('contact_number')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>

                  <div class="row pt-3 gap-3">
                     <div class="col col-12 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control p-2" value="{{ old('email') }}">

                        @error('email')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control p-2">

                        @error('password')
                           <div class="text-danger small">{{ $message }}</div>
                        @enderror
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
