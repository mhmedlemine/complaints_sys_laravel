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
        'date',
        'type', // 'regular', 'complaint'
        'status', // 'pending', 'clean', 'with_infractions'
        'action_taken', // 'none', 'closed'
        'notes'
    ];

    protected $casts = [
        'date' => 'datetime'
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
        return $this->hasOne(Complaint::class);
    }

    public function checkupInfractions()
    {
        return $this->hasMany(CheckupInfraction::class);
    }

    public function summon()
    {
        return $this->hasOne(Summon::class);
    }
}
