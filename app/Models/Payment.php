<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function demolition()
    {
        return $this->belongsTo('App\Models\Demolition', 'demolition_id');
    }

    public function typePayment()
    {
        return $this->belongsTo('App\Models\TypePayment', 'typePayment_id');
    }

    public function scopeFilter($query, $demolition_id)
    {
        if (!empty($demolition_id)) {
            $query = $query->where('demolition_id', $demolition_id);
        }
        return $query;
    }
}
