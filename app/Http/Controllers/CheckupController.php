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
    public function index()
    {
        $checkups = Checkup::with(['entreprise', 'agent'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('admin.checkups.index', compact('checkups'));
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
