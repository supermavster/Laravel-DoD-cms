<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function user()
    {
        // Una verificación pertenece a un usuario
        return $this->belongsTo('App\User', 'user_id');
    }
}
