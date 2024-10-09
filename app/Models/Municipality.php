<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = ['code', 'name', 'name_ar', 'lat', 'lon', 'moughataa_id'];

    public function moughataa()
    {
        return $this->belongsTo(Moughataa::class);
    }

    public function neighbourhoods()
    {
        return $this->hasMany(Neighbourhood::class);
    }
}
