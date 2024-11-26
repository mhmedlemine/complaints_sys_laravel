<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summon extends Model
{
    protected $fillable = [
        'code',
        'checkup_id',
        'status', // 'pending', 'fined', 'completed'
        'filledon',
        'agent_id',
        'entreprise_id',
        'reason',
        'action',
        'duedate',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}