<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'code', 'name', 'name_ar', 'neighbourhood_id', 'owner_id', 'status',
        'type', 'registeredon', 'agent_id', 'lat', 'lon', 'rg', 'notes', 'address'
    ];

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
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