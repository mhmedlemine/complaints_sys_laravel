<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Summon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'checkup_id',
        'status',         // 'pending', 'fined', 'completed', 'appealed'
        'filledon',
        'agent_id',
        'entreprise_id',
        'duedate',
    ];
    
    protected $casts = [
        'filledon' => 'datetime',
        'duedate' => 'datetime',
    ];

    public static function generateUniqueCode()
    {
        do {
            $code = Str::random(6);
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}