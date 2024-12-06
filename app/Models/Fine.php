<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $fillable = [
        'code',
        'summon_id',
        'amount',
        'status',   // 'pending', 'paid', 'appealed'
        'duedate',
        'issued_on',
        'issued_by',
        'paid_on',
        'notes',
        'receipt_number',
        'receipt_date',
    ];

    protected $casts = [
        'duedate' => 'datetime',
        'issued_on' => 'datetime',
        'paid_on' => 'datetime',
        'receipt_date' => 'datetime',
    ];

    public static function generateUniqueCode()
    {
        do {
            $code = 'AMND-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function summon()
    {
        return $this->belongsTo(Summon::class);
    }
    
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Get entreprise through summon
    public function entreprise()
    {
        return $this->hasOneThrough(
            Entreprise::class,
            Summon::class,
            'id', // Foreign key on summons table
            'id', // Foreign key on entreprises table
            'summon_id', // Local key on fines table
            'entreprise_id' // Local key on summons table
        );
    }

    public function isPaid()
    {
        return $this->status === 'paid' || $this->paid_on;
    }

    public function isappealed()
    {
        return $this->status === 'appealed';
    }

    public function isOverdue()
    {
        return !$this->isPaid() && now()->gt($this->duedate);
    }
}