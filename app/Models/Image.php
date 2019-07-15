<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function demolition()
    {
        return $this->belongsTo('App\Models\Demolition', 'demolition_id')
            ->withTimestamps();
    }
}
