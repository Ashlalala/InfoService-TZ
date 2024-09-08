<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Status;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    
    public function index()
    {
        // return Lead::all();
        $leads = Lead::with('status')->get();
        return $leads;
    }

    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return response()->json($lead);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // $lead = Lead::create($request->all());
        $lead = Lead::create($validated + ['status_id' => Status::where('name', 'Новый')->first()->id]);

        return response()->json($lead, 201);
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $lead->update($validated);

        return response()->json($lead, 201);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json($lead, 201);
    }
}
