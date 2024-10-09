<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moughataa extends Model
{
    protected $fillable = ['code', 'name', 'name_ar', 'lat', 'lon', 'wilaya_id'];

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}