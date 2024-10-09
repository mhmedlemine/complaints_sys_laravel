<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return Complaint::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'filledby' => 'required|exists:consumers,id',
            'filledon' => 'required|date',
        ]);

        $complaint = Complaint::create($request->all());

        return response()->json($complaint, 201);
    }

    public function show(Complaint $complaint)
    {
        return $complaint;
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'code' => 'sometimes|string|max:255',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $complaint->update($request->all());

        return response()->json($complaint, 200);
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return response()->json(null, 204);
    }
}