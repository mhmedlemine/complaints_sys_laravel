<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCheckupProgressRequest;
use App\Http\Requests\StartCheckupRequest;
use App\Http\Requests\SubmitCheckupRequest;
use App\Models\Checkup;
use App\Models\CheckupInfraction;
use App\Models\Complaint;
use App\Models\Consumer;
use App\Models\Evidence;
use App\Models\Infraction;
use App\Models\Summon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the checkups.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $checkups = Checkup::with(['complaint', 'entreprise'])
            ->paginate(10);

        return response()->json($checkups);
    }

    /**
     * Store a newly created checkup in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'code' => 'required|string',
            'entreprise_id' => 'required|exists:entreprises,id',
            'type' => 'required|in:regular,special',
            'status' => 'required|in:clean,with_infractions',
            'duedate' => 'required',
            'action_taken' => 'required|in:none,closed',
            'notes' => 'nullable|string',
            'infractions' => 'array|required_if:status,with_infractions',
            'infractions.*.id' => 'required|exists:infractions,id',
            'infractions.*.notes' => 'nullable|string',
            'custom_infractions' => 'array|nullable',
            'custom_infractions.*.text' => 'required|string',
            'custom_infractions.*.notes' => 'nullable|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                // Create Checkup
                $checkup = Checkup::create([
                    'code' => $request->code,
                    'complaint_id' => null,
                    'entreprise_id' => $request->entreprise_id,
                    'agent_id' => $request->user()->id,
                    'type' => $request->type,
                    'status' => $request->status,
                    'action_taken' => $request->action_taken,
                    'date' => now()->format('Y-m-d H:i:s'),
                    'notes' => $request->notes
                ]);

                // Handle infractions if status is with_infractions
                if ($request->status === 'with_infractions') {
                    // Add predefined infractions
                    foreach ($request->infractions as $infraction) {
                        CheckupInfraction::create([
                            'checkup_id' => $checkup->id,
                            'infraction_id' => $infraction['id'],
                            'notes' => $infraction['notes']
                        ]);
                    }

                    // Add custom infractions
                    foreach ($request->custom_infractions ?? [] as $customInfraction) {
                        CheckupInfraction::create([
                            'checkup_id' => $checkup->id,
                            'custom_infraction_text' => $customInfraction['text'],
                            'notes' => $customInfraction['notes']
                        ]);
                    }


                    // Create Summon
                    $summon = Summon::create([
                        'code' => Summon::generateUniqueCode(),
                        'checkup_id' => $checkup->id,
                        'entreprise_id' => $request->entreprise_id,
                        'agent_id' => $request->user()->id,
                        'action' => $request->action_taken,
                        'reason' => 'e',
                        'status' => 'pending',
                        'duedate' => $request->duedate,
                        'filledon' => now(),
                    ]);

                    return response()->json([
                        'message' => 'Checkup created successfully',
                        'data' => $summon
                    ], 201);
                }

                return response()->json([
                    'message' => 'Checkup created successfully',
                    'data' => $checkup
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating checkup',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function start(StartCheckupRequest $request)
    {
        $entreprise = $this->findClosestShop($request->lat, $request->lon, 0.02);
        if (!$entreprise) {
            return response()->json([
                'message' => 'This location has no registred entreprise. add one if you wish.',
                null
            ], 204);
        }

        try {
            $checkup = Checkup::create([
                'code' => 'CTRL-' . Str::random(8),
                'agent_id' => auth()->id(),
                'entreprise_id' => $entreprise->id,
                'type' => $request->type,
                'status' => 'in_progress',
                'started_at' => now(),
            ]);

            $checkup->entreprise = $entreprise;
            return response()->json([
                'message' => 'Checkup started successfully',
                'data' => $checkup
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error starting checkup',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveProgress(Request $request, Checkup $checkup)
    {
        $validated = Validator::make($request->all(), [
            'notes' => 'nullable|string',
            'infractions' => 'nullable|array',
            'infractions.*.infraction_id' => 'required|exists:infractions,id',
            'infractions.*.notes' => 'nullable|string',
            'custom_infractions' => 'array|nullable',
            'custom_infractions.*.text' => 'required|string',
            'custom_infractions.*.notes' => 'nullable|string',
            'custom_infractions.*.evidence_files' => 'nullable|array',
            'custom_infractions.*.evidence_files.*.file' => [
                'required',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'custom_infractions.*.evidence_files.*.description' => 'nullable|string',
            'infractions.*.evidence_files' => 'nullable|array',
            'infractions.*.evidence_files.*.file' => [
                'nullable',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'infractions.*.evidence_files.*.file' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx,mp3,mp4|max:10240',
            'infractions.*.evidence_files.*.description' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request, $checkup) {
                if (!in_array($checkup->status, ['in_progress'])) {
                    throw new \Exception('Checkup progress can only be saved while in progress');
                }

                $currentInfractionIds = [];
                if ($request->has('infractions')) {
                    $currentInfractionIds = collect($request->infractions)
                        ->pluck('id')
                        ->filter()
                        ->toArray();
                }

                $currentCustomInfractionIds = [];
                if ($request->has('custom_infractions')) {
                    $currentCustomInfractionIds = collect($request->custom_infractions)
                        ->pluck('id')
                        ->filter()
                        ->toArray();
                }

                $checkup->checkupInfractions()
                    ->whereNotIn('id', array_merge($currentInfractionIds, $currentCustomInfractionIds))
                    ->get()
                    ->each(function ($infraction) {
                        if (!empty($infraction->evidence_files)) {
                            foreach ($infraction->evidence_files as $evidence) {
                                Storage::disk('public')->delete($evidence['file_path'] ?? '');
                            }
                        }
                        $infraction->delete();
                    });

                // return response()->json(['debug' => $request->all()]);

                if ($request->has('deleted_evidence_files')) {
                    foreach ($request->deleted_evidence_files as $file_path) {
                        Storage::disk('public')->delete($file_path ?? '');
                    }
                }

                if ($request->has('infractions')) {
                    foreach ($request->infractions as $infractionData) {
                        $evidenceFiles = [];

                        $checkupInfraction = isset($infractionData['id'])
                            ? CheckupInfraction::find($infractionData['id'])
                            : new CheckupInfraction();

                        if (isset($infractionData['evidence_files'])) {
                            foreach ($infractionData['evidence_files'] as $evidenceFile) {
                                if (!isset($evidenceFile['file_path'])) {
                                    $filePath = $evidenceFile['file']->store('evidence_files', 'public');
                                    $evidenceFiles[] = [
                                        'file_path' => $filePath,
                                        'file_type' => $evidenceFile['file_type'],
                                        'description' => $evidenceFile['description'] ?? null,
                                        'uploaded_by' => auth()->id(),
                                        'uploaded_at' => now(),
                                    ];
                                } else {
                                    $evidenceFiles[] = [
                                        'file_path' => $evidenceFile['file_path'],
                                        'file_type' => $evidenceFile['file_type'],
                                        'description' => $evidenceFile['description'] ?? null,
                                        'uploaded_by' => auth()->id(),
                                        'uploaded_at' => now(),
                                    ];
                                }
                            }
                        }

                        $checkupInfraction->fill([
                            'checkup_id' => $checkup->id,
                            'infraction_id' => $infractionData['infraction_id'],
                            'notes' => $infractionData['notes'] ?? null,
                            'status' => 'pending',
                            'evidence_files' => $evidenceFiles
                        ])->save();
                    }
                }

                if ($request->has('custom_infractions')) {
                    foreach ($request->custom_infractions as $customInfraction) {
                        $evidenceFiles = [];

                        $checkupInfraction = isset($customInfraction['id'])
                            ? CheckupInfraction::find($customInfraction['id'])
                            : new CheckupInfraction();

                        if (isset($customInfraction['evidence_files'])) {
                            foreach ($customInfraction['evidence_files'] as $evidenceFile) {
                                if (!isset($evidenceFile['file_path'])) {
                                    $filePath = $evidenceFile['file']->store('evidence_files', 'public');
                                    $evidenceFiles[] = [
                                        'file_path' => $filePath,
                                        'file_type' => $evidenceFile['file_type'],
                                        'description' => $evidenceFile['description'] ?? null,
                                        'uploaded_by' => auth()->id(),
                                        'uploaded_at' => now(),
                                    ];
                                } else {
                                    $evidenceFiles[] = [
                                        'file_path' => $evidenceFile['file_path'],
                                        'file_type' => $evidenceFile['file_type'],
                                        'description' => $evidenceFile['description'] ?? null,
                                        'uploaded_by' => auth()->id(),
                                        'uploaded_at' => now(),
                                    ];
                                }
                            }
                        }

                        $checkupInfraction->fill([
                            'checkup_id' => $checkup->id,
                            'custom_infraction_text' => $customInfraction['text'],
                            'notes' => $customInfraction['notes'] ?? null,
                            'status' => 'pending',
                            'evidence_files' => $evidenceFiles
                        ])->save();
                    }
                }


                // foreach ($checkup->checkupInfractions as $infraction) {
                //     if (!empty($infraction->evidence_files)) {
                //         foreach ($infraction->evidence_files as $evidence) {
                //             Storage::disk('public')->delete($evidence['file'] ?? '');
                //         }
                //     }
                //     $infraction->delete();
                // }
                // foreach ($request->infractions as $infractionData) {
                //     $evidenceFiles = [];

                //     if (isset($infractionData['evidence_files'])) {
                //         foreach ($infractionData['evidence_files'] as $evidenceFile) {
                //             $file = $evidenceFile['file'];
                //             $filePath = $file->store('evidence_files', 'public');

                //             $evidenceFiles[] = [
                //                 'file_path' => $filePath,
                //                 'file_type' => $evidenceFile['file_type'],
                //                 'description' => $evidenceFile['description'] ?? null,
                //                 'uploaded_by' => auth()->id(),
                //                 'uploaded_at' => now(),
                //             ];
                //         }
                //     }

                //     CheckupInfraction::create([
                //         'checkup_id' => $checkup->id,
                //         'infraction_id' => $infractionData['infraction_id'] ?? null,
                //         'notes' => $infractionData['notes'] ?? null,
                //         'status' => 'pending',
                //         'evidence_files' => $evidenceFiles
                //     ]);
                // }

                // foreach ($request->custom_infractions ?? [] as $customInfraction) {
                //     $evidenceFiles = [];

                //     if (isset($customInfraction['evidence_files'])) {
                //         foreach ($customInfraction['evidence_files'] as $evidenceFile) {
                //             $filePath = $evidenceFile['file']->store('evidence_files', 'public');

                //             $evidenceFiles[] = [
                //                 'file_path' => $filePath,
                //                 'file_type' => $evidenceFile['file_type'],
                //                 'description' => $evidenceFile['description'] ?? null,
                //                 'uploaded_by' => auth()->id(),
                //                 'uploaded_at' => now(),
                //             ];
                //         }
                //     }

                //     CheckupInfraction::create([
                //         'checkup_id' => $checkup->id,
                //         'custom_infraction_text' => $customInfraction['text'],
                //         'notes' => $customInfraction['notes'] ?? null,
                //         'status' => 'pending',
                //         'evidence_files' => $evidenceFiles,
                //     ]);
                // }

                $checkup->update([
                    'notes' => $request->notes
                ]);

                $checkup->load(['entreprise', 'checkupInfractions.infraction']);

                return response()->json([
                    'message' => 'Checkup progress saved successfully',
                    'data' => $checkup,
                ], 200);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving checkup progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function submit(Request $request, Checkup $checkup)
    {
        $validated = Validator::make($request->all(), [
            'notes' => 'nullable|string',
            'infractions' => 'nullable|array',
            'infractions.*.infraction_id' => 'required|exists:infractions,id',
            'infractions.*.notes' => 'nullable|string',
            'custom_infractions' => 'array|nullable',
            'custom_infractions.*.text' => 'required|string',
            'custom_infractions.*.notes' => 'nullable|string',
            'custom_infractions.*.evidence_files' => 'nullable|array',
            'custom_infractions.*.evidence_files.*.file' => [
                'required',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'custom_infractions.*.evidence_files.*.description' => 'nullable|string',
            'infractions.*.evidence_files' => 'nullable|array',
            'infractions.*.evidence_files.*.file' => [
                'nullable',
                'file',
                'mimes:jpeg,png,pdf,doc,docx,mp3,mp4',
                'max:10240'
            ],
            'infractions.*.evidence_files.*.file' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx,mp3,mp4|max:10240',
            'infractions.*.evidence_files.*.description' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validated->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request, $checkup) {
                if (!in_array($checkup->status, ['in_progress'])) {
                    throw new \Exception('Checkup progress can only be saved while in progress');
                }

                $currentInfractionIds = [];
                if ($request->has('infractions')) {
                    $currentInfractionIds = collect($request->infractions)
                        ->pluck('id')
                        ->filter()
                        ->toArray();
                }

                $currentCustomInfractionIds = [];
                if ($request->has('custom_infractions')) {
                    $currentCustomInfractionIds = collect($request->custom_infractions)
                        ->pluck('id')
                        ->filter()
                        ->toArray();
                }

                $checkup->checkupInfractions()
                    ->whereNotIn('id', array_merge($currentInfractionIds, $currentCustomInfractionIds))
                    ->get()
                    ->each(function ($infraction) {
                        if (!empty($infraction->evidence_files)) {
                            foreach ($infraction->evidence_files as $evidence) {
                                Storage::disk('public')->delete($evidence['file_path'] ?? '');
                            }
                        }
                        $infraction->delete();
                    });

                // return response()->json(['debug' => $request->all()]);

                if ($request->has('deleted_evidence_files')) {
                    foreach ($request->deleted_evidence_files as $file_path) {
                        Storage::disk('public')->delete($file_path ?? '');
                    }
                }

                if ($request->has('infractions') || $request->has('custom_infractions')) {
                    if ($request->has('infractions')) {
                        foreach ($request->infractions as $infractionData) {
                            $evidenceFiles = [];

                            $checkupInfraction = isset($infractionData['id'])
                                ? CheckupInfraction::find($infractionData['id'])
                                : new CheckupInfraction();

                            if (isset($infractionData['evidence_files'])) {
                                foreach ($infractionData['evidence_files'] as $evidenceFile) {
                                    if (!isset($evidenceFile['file_path'])) {
                                        $filePath = $evidenceFile['file']->store('evidence_files', 'public');
                                        $evidenceFiles[] = [
                                            'file_path' => $filePath,
                                            'file_type' => $evidenceFile['file_type'],
                                            'description' => $evidenceFile['description'] ?? null,
                                            'uploaded_by' => auth()->id(),
                                            'uploaded_at' => now(),
                                        ];
                                    } else {
                                        $evidenceFiles[] = [
                                            'file_path' => $evidenceFile['file_path'],
                                            'file_type' => $evidenceFile['file_type'],
                                            'description' => $evidenceFile['description'] ?? null,
                                            'uploaded_by' => auth()->id(),
                                            'uploaded_at' => now(),
                                        ];
                                    }
                                }
                            }

                            $checkupInfraction->fill([
                                'checkup_id' => $checkup->id,
                                'infraction_id' => $infractionData['infraction_id'],
                                'notes' => $infractionData['notes'] ?? null,
                                'status' => 'pending',
                                'evidence_files' => $evidenceFiles
                            ])->save();
                        }
                    }

                    if ($request->has('custom_infractions')) {
                        foreach ($request->custom_infractions as $customInfraction) {
                            $evidenceFiles = [];

                            $checkupInfraction = isset($customInfraction['id'])
                                ? CheckupInfraction::find($customInfraction['id'])
                                : new CheckupInfraction();

                            if (isset($customInfraction['evidence_files'])) {
                                foreach ($customInfraction['evidence_files'] as $evidenceFile) {
                                    if (!isset($evidenceFile['file_path'])) {
                                        $filePath = $evidenceFile['file']->store('evidence_files', 'public');
                                        $evidenceFiles[] = [
                                            'file_path' => $filePath,
                                            'file_type' => $evidenceFile['file_type'],
                                            'description' => $evidenceFile['description'] ?? null,
                                            'uploaded_by' => auth()->id(),
                                            'uploaded_at' => now(),
                                        ];
                                    } else {
                                        $evidenceFiles[] = [
                                            'file_path' => $evidenceFile['file_path'],
                                            'file_type' => $evidenceFile['file_type'],
                                            'description' => $evidenceFile['description'] ?? null,
                                            'uploaded_by' => auth()->id(),
                                            'uploaded_at' => now(),
                                        ];
                                    }
                                }
                            }

                            $checkupInfraction->fill([
                                'checkup_id' => $checkup->id,
                                'custom_infraction_text' => $customInfraction['text'],
                                'notes' => $customInfraction['notes'] ?? null,
                                'status' => 'pending',
                                'evidence_files' => $evidenceFiles
                            ])->save();
                        }
                    }

                    $checkup->update([
                        'status' => 'with_infractions',
                        'completed_at' => now(),
                        'action_taken' => $request->action_taken,
                        'notes' => $request->notes,
                    ]);

                    $summon = Summon::create([
                        'code' => Summon::generateUniqueCode(),
                        'checkup_id' => $checkup->id,
                        'status' => 'pending',
                        'filledon' => now(),
                        'agent_id' => auth()->id(),
                        'entreprise_id' => $checkup->entreprise_id,
                        'duedate' => $request->duedate,
                        'notes' => $request->notes,
                    ]);

                    $checkup->load('entreprise');
                    $checkup->summon = $summon;

                    return response()->json([
                        'message' => 'Checkup submitted successfully',
                        'data' => $checkup,
                    ], 200);
                } else {
                    $checkup->update([
                        'status' => 'clean',
                        'completed_at' => now(),
                        'action_taken' => 'none',
                        'notes' => $request->notes
                    ]);

                    $checkup->load('entreprise');

                    return response()->json([
                        'message' => 'Checkup submitted successfully',
                        'data' => $checkup,
                    ], 200);
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving checkup progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancel(Checkup $checkup)
    {
        try {
            if (!in_array($checkup->status, ['in_progress'])) {
                throw new \Exception('Checkup cannot be canceled in its current status');
            }

            $checkup->update([
                'status' => 'canceled',
                'canceled_at' => now(),
                'action_taken' => 'none',
            ]);

            return response()->json([
                'message' => 'Checkup canceled successfully',
                'data' => $checkup,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error canceling checkup',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function submitComplaint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'greenNumber' => 'required|string',
            'consumer_id' => 'required|exists:consumers,id',
            'shop_address' => 'required|string',
            'infractions' => 'array|nullable',
            'infractions.*.infraction_id' => 'required|exists:infractions,id',
            'infractions.*.notes' => 'nullable|string',
            'custom_infractions' => 'array|nullable',
            'custom_infractions.*.text' => 'required|string',
            'custom_infractions.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $priority = $this->calculatePriority($request->infractions ?? []);

                $complaint = Complaint::create([
                    'code' => 'PLNT-' . Str::random(8),
                    'title' => $request->title,
                    'description' => $request->description,
                    'greenNumber' => $request->greenNumber,
                    'consumer_id' => $request->consumer_id,
                    'receiving_agent_id' => auth()->id(),
                    'shop_address' => $request->shop_address,
                    'status' => 'pending',
                    'is_valid' => false,
                    'reported_at' => now(),
                    'priority' => $priority,
                ]);

                $checkup = Checkup::create([
                    'code' => 'CTRL-' . Str::random(8),
                    'agent_id' => null,
                    'complaint_id' => $complaint->id,
                    'type' => 'complaint',
                    'status' => 'pending',
                ]);

                if ($request->has('infractions')) {
                    foreach ($request->infractions as $infraction) {
                        CheckupInfraction::create([
                            'checkup_id' => $checkup->id,
                            'infraction_id' => $infraction['infraction_id'],
                            'notes' => $infraction['notes'] ?? null,
                            'status' => 'pending',
                            'is_reported' => true,
                        ]);
                    }
                }

                if ($request->has('custom_infractions')) {
                    foreach ($request->custom_infractions as $customInfraction) {
                        CheckupInfraction::create([
                            'checkup_id' => $checkup->id,
                            'custom_infraction_text' => $customInfraction['text'],
                            'notes' => $customInfraction['notes'] ?? null,
                            'status' => 'pending',
                            'is_reported' => true,
                        ]);
                    }
                }

                $complaint->load([
                    'consumer',
                    'receiver',
                    'checkup.checkupInfractions.infraction'
                ]);

                return response()->json([
                    'message' => 'Complaint submitted successfully',
                    'data' => $complaint
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error submitting complaint',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function calculatePriority(array $infractions): string
    {
        if (empty($infractions)) {
            return 'low';
        }

        $infractionIds = array_column($infractions, 'infraction_id');

        $selectedInfractions = Infraction::whereIn('id', $infractionIds)
            ->get(['id', 'severity']);

        if ($selectedInfractions->contains('severity', 'high')) {
            return 'high';
        }

        if ($selectedInfractions->contains('severity', 'medium')) {
            return 'medium';
        }

        $lowSeverityCount = $selectedInfractions->where('severity', 'low')->count();

        if ($lowSeverityCount > 2) {
            return 'medium';
        }

        return 'low';
    }

    private function findClosestShop($lat, $lon, $threshold)
    {
        return $closestEntreprise = DB::table('entreprises')
            ->select('*', DB::raw("(6371 * acos(cos(radians($lat))
            * cos(radians(lat))
            * cos(radians(lon) - radians($lon))
            + sin(radians($lat))
            * sin(radians(lat)))) AS distance"))
            ->having('distance', '<', $threshold)
            ->orderBy('distance', 'asc')
            ->first();
    }

    /**
     * Get closest entreprise within 50 meters to the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClosestShop(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $lat = $validated['lat'];
        $lon = $validated['lon'];
        $threshold = 0.02; // 20 meters in kilometers

        $closestEntreprise = DB::table('entreprises')
            ->select('*', DB::raw("(6371 * acos(cos(radians($lat))
            * cos(radians(lat))
            * cos(radians(lon) - radians($lon))
            + sin(radians($lat))
            * sin(radians(lat)))) AS distance"))
            ->having('distance', '<', $threshold)
            ->orderBy('distance', 'asc')
            ->first();

        if (!$closestEntreprise) {
            return response()->json(null, 204);
        }

        return response()->json($closestEntreprise, 200);
    }

    /**
     * Get Infractions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfractions(Request $request)
    {
        try {
            $infractions = Infraction::orderBy('label', 'asc')->get();

            return response()->json(
                $infractions
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving infractions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchConsumer(Request $request)
    {
        $query = $request->get('query');
        
        $merchants = Consumer::where('phonenumber', 'LIKE', "%{$query}%")
            ->get();
        
        return response()->json($merchants);
    }

    public function addConsumer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'phonenumber' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $consumer = Consumer::create($request->all());
            
            return response()->json( $consumer, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating enterprise',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get checkups registered by the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myCheckups(Request $request)
    {
        try {
            $checkups = Checkup::where('agent_id', $request->user()->id)
                ->with(['summon.entreprise', 'agent', 'entreprise', 'complaint', 'checkupInfractions.infraction'])
                ->orderBy('created_at', 'desc')->get();

            return response()->json(
                $checkups
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving checkups',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mySummons(Request $request)
    {
        try {
            $summons = Summon::where('agent_id', $request->user()->id)
                ->with(['agent', 'entreprise', 'checkup', 'fine'])
                ->orderBy('created_at', 'desc')->get();

            return response()->json(
                $summons
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving summons',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search checkups by name or code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $checkups = Checkup::where('code', 'LIKE', "%{$query}%")
            ->paginate(10);

        return response()->json($checkups);
    }
}
