<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Checkup;
use App\Models\Complaint;
use App\Models\Consumer;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['consumer', 'receiver', 'entreprise', 'checkup.agent']);

        if ($search = $request->input('search')) {
            $query->where('code', 'like', "%{$search}%")
                ->orWhereHas('consumer', function ($q) use ($search) {
                    $q->where('fname', 'like', "%{$search}%")
                        ->orWhere('lname', 'like', "%{$search}%");
                })
                ->orWhereHas('entreprise', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($priority = $request->input('priority')) {
            $query->where('priority', $priority);
        }

        $complaints = $query->latest()->paginate(15);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $consumers = Consumer::all();
        $entreprises = Entreprise::all();
        return view('admin.complaints.create', compact('consumers', 'entreprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'consumer_id' => 'required|exists:consumers,id',
            'entreprise_id' => 'required|exists:entreprises,id',
            'priority' => 'required|in:low,medium,high',
            'shop_address' => 'required|string',
            'reported_at' => 'required|date',
            'greenNumber' => 'nullable|string',
        ]);

        $validated['code'] = 'CPT-' . uniqid();
        $validated['status'] = 'pending';

        $complaint = Complaint::create($validated);

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Complaint registered successfully.');
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['consumer', 'receiver', 'entreprise', 'checkup']);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $consumers = Consumer::all();
        $entreprises = Entreprise::all();
        return view('admin.complaints.edit', compact('complaint', 'consumers', 'entreprises'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'consumer_id' => 'required|exists:consumers,id',
            'entreprise_id' => 'required|exists:entreprises,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,assigned,investigating,resolved',
            'shop_address' => 'required|string',
            'reported_at' => 'required|date',
            'greenNumber' => 'nullable|string',
        ]);

        $complaint->update($validated);

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()
            ->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    public function assignComplaint(Complaint $complaint)
    {
        $agents = User::role('fieldagent')->get();

        return view('admin.complaints.assign', compact('complaint', 'agents'));
    }

    public function storeAssignment(Request $request, Complaint $complaint)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        DB::transaction(function () use ($request, $complaint) {
            $checkup = $complaint->checkup;

            $checkup->update([
                'agent_id' => $request->agent_id,
            ]);

            $complaint->update([
                'status' => 'assigned'
            ]);
        });

        return redirect()
            ->route('admin.complaints.show', $complaint)
            ->with('success', 'Complaint assigned successfully.');
    }

    public function getAvailableAgents()
    {
        $agents = User::role('agent')->get();
        return response()->json($agents);
    }
}
