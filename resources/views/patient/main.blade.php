@extends('layout.layout')

@section('title', 'Dental Clinic and Services')

@section('content')

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
               <div class="d-flex ms-5 gap-2">
                  <div class="dropdown">
                     <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                     </button>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('patient.profile')}}">Profile</a></li>
                        <li>
                           <form action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="a-hover border-0 bg-transparent">Logout</button>
                           </form>
                        </li>
                     </ul>
                  </div>
                  <div class="me-3">
                     <p class="fw-semibold">
                        {{ Auth::user()->first_name
                        }}
                        {{ Auth::user()->last_name
                        }}</p>
                  </div>
               </div>
            </div>
            {{-- <li class="hideOnMobile"><a class="fw-semibold" href="#">{{ Auth::user()->first_name
                  }}</a></li> --}}
            {{-- <li class="hideOnMobile">
               <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="sign-in-btn text-dark fw-semibold border-0">Logout</button>
               </form>
            </li> --}}
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
                     <a class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" href="{{ route('login') }}">Book an
                        appointment</a>
                     @endguest
                    
                     @auth
                     <button class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">Book an Appointment</button>
                     @endauth

                     <a class="btn btn-info px-3 py-2 btn-lg d-none d-md-inline-block" href="">Browse
                        services</a>

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

   {{-- Modal for booking an appointment --}}
   <div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">

         
         <div class="modal-content">
            <div class="modal-header justify-content-end">
               <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <h2>Schedule your visit with ease</h2> 
            
            <div class="modal-body mt-3">
               <form action="" method="POST">
                  @csrf

                  <div class="row gap-2 mb-2">
                     <div class="col">
                        <select style="background-color: #d9d9d9" name="services" id="services" class="form-select">
                           <option value="" disabled selected>Select a service</option>
                           {{-- @foreach ($services as $service)
                               <option value="{{ $servece->id }}">{{ $service->name }}</option>
                           @endforeach --}}
                        </select>
                     </div>
                     <div class="col">
                        <input type="date" id="appointmentDate" name="appointmentDate" class="form-control" style="background-color: #d9d9d9" required>
                     </div>
                  </div>

                  <div class="row mb-2">
                     <input type="text" id="name" name="name" placeholder="Name" class="form-control" style="background-color: #d9d9d9" required>
                  </div>

                  <div class="row mb-2">
                     <input type="email" id="email" name="email" placeholder="Email" class="form-control" style="background-color: #d9d9d9" required>
                  </div>

                  <div class="row mb-2">
                     <input type="tel" id="phone" name="phone" placeholder="Phone number: +63 9XXXXXXXXX" class="form-control" style="background-color: #d9d9d9" pattern="^(09|\+639)\d{9}$" required>
                  </div>
                  
                  <div class="row mb-3">
                     <textarea name="Message" id="message" class="form-control" placeholder="Message(optional)" style="background-color: #d9d9d9"></textarea>
                  </div>

                  <div class="row">
                     <button class="btn w-100 fw-bold text-white p-1" style="background-color: #00a1df"
                        type="submit">Submit Appointment</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>

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
                  ₱{{ number_format($service->service_price) }}
               </button>
            </div>
         </div>
         @endforeach
      </div>
      {{-- Services --}}
   </div>

   <script>
      function showSidebar(){
            const sidebar = document.querySelector(`.sidebar`);
            sidebar.style.display = `flex`;
        }

        function hideSidebar(){
            const sidebar = document.querySelector(`.sidebar`);
            sidebar.style.display = `none`;
        }
   </script>

   @endsection