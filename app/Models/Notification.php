<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = "notifications";

    protected $filleable = ["user_id", "description"];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id') //->withTimestamps()
        ;
    }


    public function demolition()
    {
        return $this->belongsTo('App\Models\Demolition', 'demolition_id') //->withTimestamps()
        ;
    }
}
