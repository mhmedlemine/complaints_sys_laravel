<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'code', 'amount', 'filledon', 'filledby', 'status', 'duedate', 'paidon'
    ];

    public function filledBy()
    {
        return $this->belongsTo(User::class, 'filledby');
    }
}