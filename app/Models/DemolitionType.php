<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemolitionType extends Model
{
    protected $table = 'types';

    public function demolition()
    {
        return $this->belongsTo('App\Models\Demolition', 'demolition_id')
            ->withTimestamps();
    }
}
