<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summon extends Model
{
    protected $fillable = [
        'code', 'status', 'complaint_id', 'filledon', 'agent_id', 'reason',
        'action', 'duedate', 'infraction_id'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id');
    }

    public function infractions()
    {
        return $this->belongsToMany(Infraction::class, 'infraction_summon');
    }
}