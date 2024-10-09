<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = ['nni', 'fname', 'lname', 'phonenumber'];

    public function entreprises()
    {
        return $this->hasMany(Entreprise::class, 'owner');
    }
}