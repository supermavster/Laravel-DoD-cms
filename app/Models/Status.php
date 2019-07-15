<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    // Table
    protected $table = 'status';

    public function demolition()
    {
        return $this->belongsTo('App\Models\Demolition', 'demolition_id')
            ->withTimestamps();
    }

    public function demolitions()
    {
        return $this->hasMany('App\Models\Demolition', 'demolition_id')
            ->withTimestamps();
    }


    public function scopeStatus($query, $id)
    {
        if (!empty($id)) {
            $query = $query->where('demolition_id', $id);
        }
        return $query;
    }


    public function scopeIdDemolition($query, $status)
    {
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }
        return $query;
    }
}
