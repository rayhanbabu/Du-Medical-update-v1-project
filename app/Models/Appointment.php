<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class, 'member_id'); 
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
        
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by'); 
    }

    public function careof(){
        return $this->belongsTo(Family::class,'careof_id');
        
    }


    // public function answer(){
    //     return $this->hasMany(Answer::class, 'question_id', 'id');
    // }
}
