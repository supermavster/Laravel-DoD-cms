<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
