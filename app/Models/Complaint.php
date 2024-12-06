<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'greenNumber',
        'consumer_id',
        'receiving_agent_id',
        'moughataa_id',
        'entreprise_id',
        'reported_at',
        'priority',         // 'low', 'medium', 'high'
        'status',          // 'pending', 'assigned', 'investigating', 'resolved'
        'shop_address',
        'is_valid',
        'resolved_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
        'is_valid' => 'boolean',
    ];

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'consumer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiving_agent_id');
    }

    public function investigator()
    {
        return $this->hasOneThrough(
            User::class,
            Checkup::class,
            'complaint_id', // Foreign key on checkups table
            'id',          // Foreign key on users table
            'id',          // Local key on complaints table
            'agent_id'     // Local key on checkups table
        );
    }

    public function checkup()
    {
        return $this->hasOne(Checkup::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function moughataa()
    {
        return $this->belongsTo(Moughataa::class, 'moughataa_id');
    }
}
