<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(15);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'starts_at' => 'required|date',
            'location' => 'nullable|string|max:150',
            'notes' => 'nullable|string|max:500',
        ]);
        Service::create($data);
        return redirect()->route('services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'starts_at' => 'required|date',
            'location' => 'nullable|string|max:150',
            'notes' => 'nullable|string|max:500',
        ]);
        $service->update($data);
        return redirect()->route('services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }
}
