<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'code', 'title', 'description', 'greenNumber', 'consumer_id', 'filledon',
        'receiver_agent_id', 'investigator_agent_id', 'type', 'entreprise_id', 'status', 'address'
    ];

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'consumer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_agent_id');
    }

    public function investigator()
    {
        return $this->belongsTo(User::class, 'investigator_agent_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}