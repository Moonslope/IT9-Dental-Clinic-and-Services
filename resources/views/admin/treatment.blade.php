@extends('layout.admin_nav_layout')

@section('title', 'Treatments')

@section('breadcrumb')

<div class="px-4 py-2 text-secondary" style="font-size: 0.95rem;">
   <span><a href="" class="text-decoration-none text-dark">Home</a></span>
   <span class="mx-2">></span>
   <span class="text-muted">Treatments</span>
</div>

@endsection

@section('adminContent')
{{-- @include('layout.supply_crud', [
'supplies' => $supplies, 'suppliers' => $suppliers, 'user' => $user,
'redirect_route' => route('admin.supply')
]) --}}

@include('layout.treatment', ['redirect_route' => route('admin.treatment')])
@endsection