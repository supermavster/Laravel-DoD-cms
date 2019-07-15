<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function answers()
    {
        return $this->belongsToMany('App\Models\Demolition', 'answers', 'question_id', 'demolition_id')
            ->withTimestamps();
    }

    public function scopeFilter($query, $user_id)
    {
        if (!empty($question_id)) {
            $query = $query->where('id', $question_id);
        }
        return $query;
    }

    // public function scopeFilter($query,$user_id){
    // 	if (!empty($user_id)){
    // 		$query = $query->where('user_id',$user_id);
    // 	}
    // 	return $query;
    // }
}
