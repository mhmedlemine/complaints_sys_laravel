<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    protected $fillable = ['nni', 'fname', 'lname', 'phonenumber', 'address'];

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'filledby');
    }
}