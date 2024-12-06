<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\CheckupInfraction;
use App\Models\Complaint;
use App\Models\Entreprise;
use App\Models\Infraction;
use App\Models\Summon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    public function index(Request $request)
    {
        $query = Checkup::with(['entreprise', 'agent', 'complaint', 'summon']);

        // Add search functionality
        if ($search = $request->input('search')) {
            $query->where('code', 'like', "%{$search}%")
                ->orWhereHas('entreprise', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                })
                ->orWhereHas('agent', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        // Add status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Add type filter
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Add date range filter
        if ($startDate = $request->input('start_date')) {
            $query->whereDate('started_at', '>=', $startDate);
        }
        if ($endDate = $request->input('end_date')) {
            $query->whereDate('started_at', '<=', $endDate);
        }

        $checkups = $query->latest('started_at')->paginate(15)
            ->appends($request->query());

        return view('admin.checkups.index', compact('checkups'));
    }

    public function show(Checkup $checkup)
    {
        $checkup->load([
            'agent',
            'entreprise',
            'complaint.consumer',
            'checkupInfractions.infraction',
            'summon.fine',
        ]);

        return view('admin.checkups.show', compact('checkup'));
    }

    public function export(Request $request)
    {
        $query = Checkup::with(['entreprise', 'agent', 'complaint', 'summon']);

        // Apply the same filters as index method
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($startDate = $request->input('start_date')) {
            $query->whereDate('started_at', '>=', $startDate);
        }

        if ($endDate = $request->input('end_date')) {
            $query->whereDate('started_at', '<=', $endDate);
        }

        $checkups = $query->latest('started_at')->get();

        // Create the export file
        $filename = 'checkups-' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Code',
            'Type',
            'Status',
            'Entreprise',
            'Agent',
            'Started At',
            'Completed At',
            'Infractions Found',
            'Action Taken',
        ];

        $callback = function() use ($checkups, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($checkups as $checkup) {
                fputcsv($file, [
                    $checkup->code,
                    $checkup->type,
                    $checkup->status,
                    $checkup->entreprise->name,
                    $checkup->agent->name,
                    $checkup->started_at->format('Y-m-d H:i'),
                    $checkup->completed_at ? $checkup->completed_at->format('Y-m-d H:i') : 'N/A',
                    $checkup->checkupInfractions->count(),
                    $checkup->action_taken,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function create()
    {
        $entreprises = Entreprise::all();
        $infractions = Infraction::all();

        return view('admin.checkups.create', compact('entreprises', 'infractions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entreprise_id' => 'required|exists:entreprises,id',
            'type' => 'required|in:regular,complaint',
            'complaint_id' => 'required_if:type,complaint|exists:complaints,id',
            'status' => 'required|in:pending,clean,with_infractions',
            'action_taken' => 'required|in:none,closed',
            'notes' => 'nullable|string',
            'infractions' => 'array|required_if:status,with_infractions',
            'infraction_notes.*' => 'nullable|string',
            'custom_infractions' => 'array|nullable'
        ]);

        DB::transaction(function () use ($validated, $request) {
            $checkup = Checkup::create([
                'code' => 'CHK-' . time(),
                'agent_id' => auth()->id(),
                'entreprise_id' => $validated['entreprise_id'],
                //'complaint_id' => null,
                'date' => now()->format('Y-m-d H:i:s'),
                'type' => $validated['type'],
                'status' => $validated['status'],
                'action_taken' => $validated['action_taken'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Handle infractions if any
            if ($validated['status'] === 'with_infractions') {
                // Add predefined infractions
                foreach ($validated['infractions'] ?? [] as $infractionId => $notes) {
                    CheckupInfraction::create([
                        'checkup_id' => $checkup->id,
                        'infraction_id' => $infractionId,
                        'notes' => $validated['infraction_notes'][$infractionId]
                    ]);
                }

                foreach ($validated['custom_infractions'] ?? [] as $customInfraction) {
                    CheckupInfraction::create([
                        'checkup_id' => $checkup->id,
                        'custom_infraction_text' => $customInfraction['text'],
                        'notes' => $customInfraction['notes']
                    ]);
                }

                // Create Summon if infractions found
                if ($validated['status'] === 'with_infractions') {
                    Summon::create([
                        'code' => 'SUM-' . $validated['entreprise_id'] . '-' . $checkup->id . time(),
                        'checkup_id' => $checkup->id,
                        'entreprise_id' => $validated['entreprise_id'],
                        'agent_id' => auth()->id(),
                        'action' => $validated['action_taken'],
                        'reason' => 'e',
                        'status' => 'pending',
                        'duedate' => now(),
                        'filledon' => now(),
                    ]);
                }
            }
        });

        return redirect()->route('admin.checkups.index')
            ->with('success', 'Checkup created successfully');
    }
}
