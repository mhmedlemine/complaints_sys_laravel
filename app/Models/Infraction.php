<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraction extends Model
{
    protected $fillable = ['code', 'label', 'description'];

    public function summons()
    {
        return $this->belongsToMany(Summon::class, 'infraction_summon');
    }
}