<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    // ─── Dashboard / Read ──────────────────────────────────────────────────────

    /**
     * Show the dashboard with the user's own records, paginated 10 per page.
     * The where() clause makes sure you only ever see your own data.
     */
    public function index()
    {
        $records = Record::where('user_id', Auth::id())
                         ->latest()
                         ->paginate(10);

        return view('dashboard.index', compact('records'));
    }

    // ─── Create ────────────────────────────────────────────────────────────────

    /** Show the create form. */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Validate and save a new record.
     * Eloquent uses PDO prepared statements so SQL injection isn't a concern here.
     * We manually attach the user_id so records are always owned by whoever's logged in.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes'   => ['nullable', 'string', 'max:1000'],
        ]);

        // Attach the authenticated user's ID
        $validated['user_id'] = Auth::id();

        Record::create($validated);

        return redirect()->route('dashboard')->with('success', 'Record created successfully.');
    }

    // ─── Update ────────────────────────────────────────────────────────────────

    /** Show the edit form. We abort with 403 if it's not their record. */
    public function edit(Record $record)
    {
        // Authorization: ensure the record belongs to the current user
        abort_if($record->user_id !== Auth::id(), 403, 'That\'s not your record.');

        return view('dashboard.edit', compact('record'));
    }

    /**
     * Validate and save the updated record.
     * Same ownership check as edit — not just trusting the route.
     */
    public function update(Request $request, Record $record)
    {
        abort_if($record->user_id !== Auth::id(), 403, 'Unauthorized.');

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes'   => ['nullable', 'string', 'max:1000'],
        ]);

        $record->update($validated);

        return redirect()->route('dashboard')->with('success', 'Record updated successfully.');
    }

    // ─── Delete ────────────────────────────────────────────────────────────────

    /**
     * Delete the record after confirming ownership.
     * The JS confirm() dialog on the frontend is the UX gate;
     * this is the actual server-side gate.
     */
    public function destroy(Record $record)
    {
        abort_if($record->user_id !== Auth::id(), 403, 'Unauthorized.');

        $record->delete();

        return redirect()->route('dashboard')->with('success', 'Record deleted successfully.');
    }
}
