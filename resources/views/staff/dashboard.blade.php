@extends('layout.staff_nav_layout')

@section('title', 'Staff Dashboard')

@section('user_type', 'Hi, ' . $staff->first_name . ' ' .$staff->last_name)

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Dashboard</span>
</div>

@endsection

@section('staffContent')
<h1>dashboard</h1>


@endsection