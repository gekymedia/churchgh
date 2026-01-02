<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('starts_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('starts_at', '<=', $request->date_to);
        }

        // Filter by upcoming/past
        if ($request->filled('time_filter')) {
            if ($request->time_filter === 'upcoming') {
                $query->where('starts_at', '>=', now());
            } elseif ($request->time_filter === 'past') {
                $query->where('starts_at', '<', now());
            }
        }

        $services = $query->latest('starts_at')->paginate(15)->withQueryString();
        
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
