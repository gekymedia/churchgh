<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

/**
 * Class QuoteController
 *
 * Provides CRUD operations for managing devotional quotes. Only users
 * with admin/pastor roles should be allowed to access these routes.
 */
class QuoteController extends Controller
{
    /**
     * Display a listing of quotes.
     */
    public function index(Request $request)
    {
        $query = Quote::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('scripture', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('delivery_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('delivery_date', '<=', $request->date_to);
        }

        // Filter by sent status
        if ($request->filled('sent_status')) {
            if ($request->sent_status === 'sent') {
                $query->whereNotNull('sent_at');
            } elseif ($request->sent_status === 'pending') {
                $query->whereNull('sent_at');
            }
        }

        $quotes = $query->orderByDesc('delivery_date')->paginate(20)->withQueryString();
        
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new quote.
     */
    public function create()
    {
        return view('quotes.create');
    }

    /**
     * Store a newly created quote.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:150',
            'scripture'     => 'nullable|string|max:255',
            'message'       => 'required|string',
            'delivery_date' => 'required|date',
            'delivery_time' => 'nullable|date_format:H:i',
        ]);
        Quote::create($data);
        return redirect()->route('quotes.index')->with('success', 'Quote created successfully.');
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        return view('quotes.edit', compact('quote'));
    }

    /**
     * Update the specified quote.
     */
    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:150',
            'scripture'     => 'nullable|string|max:255',
            'message'       => 'required|string',
            'delivery_date' => 'required|date',
            'delivery_time' => 'nullable|date_format:H:i',
        ]);
        $quote->update($data);
        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully.');
    }

    /**
     * Remove the specified quote from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();
        return back()->with('success', 'Quote deleted successfully.');
    }
}