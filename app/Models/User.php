<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'companyName', 'companyAddress', 'phone', 'email', 'password', 'status', 'image', 'tumbnail', 'rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function demolitions()
    {
        return $this->hasMany('App\Models\Demolition');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function advertisers()
    {
        return $this->hasMany('App\Models\Advertiser');
    }

    public function isAdmin()
    {
        $user = Auth::user();
        if ($user != null) {
            if ($user->rol_id == 1) {
                return true;
            }
        }
        return false;
    }

    public function verifyUser()
    {
        // Un usuario tiene una verificación
        return $this->hasOne('App\Models\VerifyUser');
    }
}
