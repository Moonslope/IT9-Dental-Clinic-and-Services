@extends('layout.layout')

@section('title', 'Dental Clinic and Services')

@section('content')
@include('layout.custom_scrollbar')
<style>
   .modal-dialog {
      margin: auto !important;
   }

   .modal,
   .modal-dialog,
   .modal-content {
      padding: 15px !important;
   }

   .custom-dropdown {
      min-width: 80px;
   }
</style>

{{-- Header --}}
<div class="">
   <nav class="navbar sticky-top bg-body-secondary px-3">
      <ul class="sidebar">
         <li onclick=hideSidebar()><a href="#">
               <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                  fill="#000000">
                  <path
                     d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
               </svg>
            </a></li>
         <li><a href="#section1" class="a-hover">Home</a></li>
         <li><a href="#section2" class="a-hover">About Us</a></li>
         <li><a href="#section3" class="a-hover">Services</a></li>
         @guest
         <li><a href="{{ route('login') }}" class="a-hover">Sign in</a></li>
         <li><a href="{{ route('register') }}" class="a-hover">Sign up</a></li>
         @endguest

         @auth
         <li><a href="#" class="">{{ Auth::user()->first_name }}</a></li>
         <li>
            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="a-hover border-0 bg-transparent">Logout</button>
            </form>
         </li>
         @endauth
      </ul>

      <div class="d-flex align-items-center border w-100">
         <ul class="d-flex gap-4">
            <li><a href="#"><img class="me-3" height="65" width="65" src="{{ asset('images/final_logo.svg') }}"
                     alt="Clinic Logo">DCS</a></li>
            <li class="hideOnMobile"><a href="#section1" class="a-hover fw-semibold">Home</a></li>
            <li class="hideOnMobile"><a href="#section2" class="a-hover fw-semibold">About Us</a></li>
            <li class="hideOnMobile"><a href="#section3" class="a-hover fw-semibold">Services</a></li>
            @guest
            <li class="hideOnMobile"><a class="sign-in-btn text-white fw-semibold" href="{{ route('login') }}">Sign
                  in</a></li>
            <li class="hideOnMobile"><a class="sign-up-btn text-dark fw-semibold" href="{{ route('register') }}">Sign
                  up</a></li>
            @endguest

            @auth
            <div class="hideOnMobile">
               <div class="d-flex ms-3 gap-2 me-3">
                  <div class="dropdown">
                     <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                     </button>
                     <ul style="overflow: hidden;" class="dropdown-menu custom-dropdown">
                        <li class=""><a class="dropdown-item text-center p-2"
                              href="{{route('patient.profile')}}">Profile</a></li>
                        <li>
                           <form action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="dropdown-item text-center p-2">Logout</button>
                           </form>
                        </li>
                     </ul>
                  </div>

               </div>
            </div>
            @endauth
            <li class="menu-btn" onclick=showSidebar()><a href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                     fill="#000000">
                     <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                  </svg>
               </a></li>
         </ul>
      </div>
   </nav>
   {{-- Header --}}

   {{-- Home --}}
   <div id="section1" class="pt-3">
      <div class="row">
         <div class="col-md-6 col-12">
            <div class="d-flex justify-content-center align-items-center h-100">
               <div>
                  <h1 style="color:#1e466b ;" class="text-center fw-bold display-3 display-md-2 display-sm-5">
                     A <span style="color: #009fde;">dental clinic</span> <br> you can trust
                  </h1>

                  <p class="text-center p-4 fs-5 fs-md-4 fs-sm-3">
                     Our clinic provides exceptional care with modern treatments to
                     keep you and your family's smiles healthy for life.
                  </p>

                  <div class="d-flex justify-content-center gap-3">
                     @guest
                     <a class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" href="{{ route('login') }}">Book
                        an
                        appointment</a>
                     @endguest

                     @auth
                     <button class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" data-bs-toggle="modal"
                        data-bs-target="#bookAppointmentModal">Book an Appointment</button>
                     @endauth

                     <a class="btn btn-info px-2 py-1 btn-sm d-md-none" href="">Book</a>
                     <a class="btn btn-info px-2 py-1 btn-sm d-md-none" href="">Services</a>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-6 col-12 d-flex justify-content-center">
            <img src="{{ asset('images/woman-patient-dentist.jpg') }}" alt="" class="img-fluid p-4 p-md-3">
         </div>
      </div>
   </div>
   {{-- Home --}}

   @include('layout.appointment_modal')

   {{-- About us --}}
   <div id="section2" class="pt-5">
      <hr class="pb-4">
      <h1 style="color: #1e466b;" class="text-center pb-5">ABOUT US</h1>

      <div class="row pt-3 align-items-center">
         <div class="col-lg-6 col-md-6 col-12 d-flex justify-content-center">
            <img src="{{ asset('images/about_us.jpg') }}" alt="About Us" class="img-fluid p-4 p-md-3 w-100">
         </div>

         <div class="col-lg-6 col-md-6 col-12">
            <h1 class="text-center fw-bold display-6 display-md-2 display-sm-5" style="color:#1e466b;">
               <span style="color:#009fde;">Quality Care</span> for a <br>Healthier, Brighter Smile
            </h1>

            <p class="text-center p-4 fs-5 fs-md-4 fs-sm-3 w-100">
               We are dedicated to providing high-quality dental care in a comfortable and friendly environment.
               Our mission is to offer exceptional dental services while ensuring a stress-free experience for our
               patients. We prioritize preventive care, patient education, and state-of-the-art treatments to
               promote lifelong oral health.
            </p>
         </div>
      </div>
   </div>
   {{-- About us --}}

   {{-- Services --}}
   <div id="section3">
      <hr class="pb-4">
      <h1 style="color: #1e466b;" class="text-center pb-5">SERVICES</h1>

      <div class="row row-cols-1 row-cols-md-3 p-3">
         @foreach ($services as $service)
         <div class="col text-center mb-4">
            <div style="border: solid 1.5px #009fde" class="p-4 ms-3 rounded shadow-sm h-100 me-3">
               <h5 class="fw-bold mb-3">{{ $service->service_name }}</h5>
               <p>{{ $service->service_description }}</p>
               <button class="sign-in-btn text-white w-50 p-1 mt-3 border border-0">
                  ₱{{ number_format($service->base_price) }} - ₱{{ number_format($service->estimated_max_price) }}
               </button>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   {{-- Services --}}
   @include('layout.modals.appointment_success')
   @include('layout.modals.login_success')

   <script>
      function showSidebar(){
         const sidebar = document.querySelector(`.sidebar`);
         sidebar.style.display = `flex`;
      }

      function hideSidebar(){
         const sidebar = document.querySelector(`.sidebar`);
         sidebar.style.display = `none`;
      }

      @if ($errors->any()) 
         document.addEventListener('DOMContentLoaded', function(){
            var myModal = new bootstrap.Modal(document.getElementById('bookAppointmentModal'));
            myModal.show();
         })
      @endif
   </script>

   @endsection