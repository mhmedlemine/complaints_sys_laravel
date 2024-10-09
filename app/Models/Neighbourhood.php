<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{
    protected $fillable = ['code', 'name', 'name_ar', 'lat', 'lon', 'municipality_id'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class);
    }
}