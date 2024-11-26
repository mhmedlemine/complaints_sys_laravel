<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'code',
        'summon_id',
        'amount',
        'filledon',
        'filledby',
        'status', // 'pending', 'paid', 'overdue'
        'duedate',
        'paidon',
        'receipt_number',
        'receipt_date',
    ];

    public function summon()
    {
        return $this->belongsTo(Summon::class);
    }
    
    public function filledBy()
    {
        return $this->belongsTo(User::class, 'filledby');
    }
}