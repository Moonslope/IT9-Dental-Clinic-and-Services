@extends('layout.dentist_nav_layout')

@section('title', 'Dentist Dashboard')

@section('user_type', 'Hi, ' . $dentist->first_name . ' ' . $dentist->last_name)

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dashboard</span>
</div>

@endsection

@section('dentistContent')
<h1>dashboard</h1>

@include('layout.modals.login_success')
@endsection