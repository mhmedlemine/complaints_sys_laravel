<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'code', 'name', 'name_ar', 'moughataa_id', 'owner_id', 'status',
        'type', 'registeredon', 'agent_id', 'lat', 'lon', 'rg', 'notes', 'address', 'neighbourhood', 'agentname'
    ];

    public function moughataa()
    {
        return $this->belongsTo(Moughataa::class);
    }

    public function owner()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}