<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupInfraction extends Model
{
    protected $fillable = [
        'checkup_id',
        'infraction_id',
        'custom_infraction_text',
        'notes',
        'is_reported',
        'status',          // 'pending', 'confirmed', 'rejected'
        'evidence_files',
        'verified_by',
        'verified_at',
    ];
    
    protected $casts = [
        'evidence_files' => 'array',
        'is_reported' => 'boolean',
        'verified_at' => 'datetime'
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function infraction()
    {
        return $this->belongsTo(Infraction::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
