<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    protected $fillable = [
        'code',
        'agent_id',
        'entreprise_id',
        'complaint_id',
        'started_at',
        'completed_at',
        'canceled_at',
        'type',              // 'regular', 'complaint'
        'status',            // 'pending', 'in_progress', 'clean', 'with_infractions', 'canceled'
        'investigation_result', // 'all_confirmed', 'all_false', 'partially_confirmed'
        'action_taken',      // 'none', 'closed', 'summon_issued'
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function checkupInfractions()
    {
        return $this->hasMany(CheckupInfraction::class);
    }

    public function infractions()
    {
        return $this->belongsToMany(Infraction::class, 'checkup_infractions')
            ->withPivot(['custom_infraction_text', 'notes', 'status', 'verified_at'])
            ->withTimestamps();
    }

    public function summon()
    {
        return $this->hasOne(Summon::class);
    }
}
