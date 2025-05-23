@extends('layout.staff_nav_layout')

@section('title', 'Stock In History')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Stock In History</span>
</div>

@endsection

@section('staffContent')
@include('layout.stock_in_history_layout')
@include('layout.modals.crud_success')
@endsection