@extends('layout.admin_nav_layout')

@section('title', 'Patients')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Patients</span>
</div>

@endsection

@section('adminContent')
@include('layout.patient_crud',[
'users' => $users,
'redirect_route' => route('admin.patient')
])

@endsection