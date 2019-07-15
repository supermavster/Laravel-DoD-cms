<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demolition extends Model
{
    protected $fillable = [
        'code',
        'type',
        'adress',
        'status',
        'description',
        'phoneUser',
        'comment',
        'schedule'
        // 'user_id'
    ];

    public function answers()
    {
        return $this->belongsToMany('App\Models\Question', 'answers', 'demolition_id', 'question_id')
            ->withPivot('answer')
            ->withTimestamps();
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function types()
    {
        return $this->hasMany('App\Models\DemolitionType');
    }

    public function sheduleDates()
    {
        return $this->hasMany('App\Models\ScheduleDate');
    }


    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
        // ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }


    public function scopeFilter($query, $user_id, $status_id)
    {
        if (!empty($user_id)) {
            $query = $query->where('user_id', $user_id);
        }

        if (!empty($status_id)) {
            $query = $query->where('status_id', $status_id);
        }
        return $query;
    }

    public function scopeIdStatus($query, $status_id)
    {
        if (!empty($status_id)) {
            $query = $query->where('status_id', $status_id);
        }
        return $query;
    }

    public function scopeIdDemolition($query, $id)
    {
        if (!empty($id)) {
            $query = $query->where('id', $id);
        }
        return $query;
    }
}
