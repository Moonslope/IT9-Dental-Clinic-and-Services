@extends('layout.staff_nav_layout')

@section('title', 'Supplier Lists')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Supplier</span>
</div>

@endsection

@section('staffContent')
@include('layout.supplier_crud', ['suppliers' => $suppliers])
@include('layout.modals.crud_success')
@endsection