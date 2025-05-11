@extends('layout.layout')

@section('title', 'Login')

@section('content')
<div style="background-color: #1e466b;" class="container-fluid vh-100">
   <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-md-10 col-lg-8">
         <div class="card shadow p-3">
            <div class="card-body">
               <div class="row">
                  <div
                     class="col col-12 col-md-6 d-flex justify-content-center align-items-center border border-2 border-top-0 border-start-0 border-bottom-0 border-bottom-sm-2">
                     <div class="text-center">
                        <img class="img-fluid" style="max-height: 250px;" src="{{ asset('images/final_logo.svg') }}"
                           alt="Logo">
                        <h1 class="fs-5 mt-3">"Where Your Smile Gets <br> the Best Care!"</h1>
                     </div>
                  </div>

                  <div class="col col-12 col-md-6 p-4">
                     <h1 style="color:#1e466b;" class="text-center fw-bold">Welcome</h1>
                     <p class="text-center text-secondary">Login into your account to continue.</p>

                     <div class="pt-4">
                        <form action="{{ route('login') }}" method="POST">
                           @csrf

                           <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" id="email" name="email" class="form-control p-2 rounded-pill @error('email') is-invalid @enderror" value="{{ old('email') }}">
                              
                              @error('email')
                                 <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>

                           <div class="mb-3">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" id="password" name="password"
                                 class="form-control p-2 rounded-pill @error('password') is-invalid @enderror">

                              @error('password')
                                 <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>

                           <input type="submit" value="Login"
                              class="btn log-reg form-control p-2 rounded-pill fw-bold text-white mt-3"
                              style="background-color: #1e466b;">

                           </input>

                           <p class="text-center mt-3">Don't have an account? <a href="{{route('register')}}"
                                 class="text-info">Register</a>
                           </p>
                        </form>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection