<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function staff_service()
    {
        $services = Service::latest()->get();
        return view('staff.service', ['services' => $services]);
    }

    public function admin_service()
    {
        $services = Service::latest()->get();
        return view('admin.service', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $newService = $request->validated();
        Service::create($newService);

        return redirect($request->input('redirect_to', route('staff.service')));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $newService = $request->validated();
        $service->update($newService);

        return redirect($request->input('redirect_to', route('staff.service')));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Service $service)
    {
        $service->delete();
        return redirect($request->input('redirect_to', route('staff.service')));
    }
}