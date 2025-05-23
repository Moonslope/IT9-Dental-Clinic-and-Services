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
    public function staff_service(Request $request)
    {
        // Get the search input from the request
        $search = $request->input('search');

        // Retrieve services from the database, filter by search keyword if provided
        $services = Service::when($search, function ($query, $search) {
            $query->where('service_name', 'like', "%{$search}%")
                ->orWhere('service_description', 'like', "%{$search}%");
        })->latest()->get();

        // Return the service list view with the retrieved services
        return view('staff.service', ['services' => $services]);
    }

    public function admin_service(Request $request)
    {
        $search = $request->input('search');
        $services = Service::when($search, function ($query, $search) {
            $query->where('service_name', 'like', "%{$search}%")
                ->orWhere('service_description', 'like', "%{$search}%");
        })->latest()->get();

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
        // Validate the incoming request using custom ServiceRequest rules
        $newService = $request->validated();

        // Create a new service record in the database
        Service::create($newService);

        return redirect()->back()->with('added_success', 'Service successfully added!');
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
        // Validate the incoming request using custom ServiceRequest rules
        $newService = $request->validated();

        // Update the existing service with new data
        $service->update($newService);

        return redirect()->back()->with('updated_success', 'Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Service $service)
    {
        // Delete the service from the database
        $service->delete();

        return redirect()->back()->with('deleted_success', 'Successfully deleted!');
    }
}
