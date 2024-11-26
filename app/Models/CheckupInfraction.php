<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupInfraction extends Model
{
    protected $fillable = [
        'checkup_id',
        'infraction_id',
        'custom_infraction_text',
        'notes'
    ];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function infraction()
    {
        return $this->belongsTo(Infraction::class);
    }
}
