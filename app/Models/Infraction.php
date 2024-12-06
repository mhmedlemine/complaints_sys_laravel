<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraction extends Model
{
    protected $fillable = [
        'code',
        'label',
        'label_ar',
        'description',
        'description_ar',
        'severity',     // 'low', 'medium', 'high'
        'fine_min_amount',
        'fine_max_amount',
    ];

    public function checkupInfractions()
    {
    return $this->hasMany(CheckupInfraction::class);
    }

    public function checkups()
    {
        return $this->belongsToMany(Checkup::class, 'checkup_infractions')
            ->withPivot(['custom_infraction_text', 'notes', 'status', 'verified_at'])
            ->withTimestamps();
    }
}