<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    protected $fillable = ['code', 'name', 'name_ar', 'lat', 'lon'];

    public function moughataas()
    {
        return $this->hasMany(Moughataa::class);
    }
}