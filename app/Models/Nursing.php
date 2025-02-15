<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nursing extends Model
{
    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class, 'member_id'); 
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id'); 
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function careof()
    {
        return $this->hasOneThrough(Family::class, Appointment::class, 'id', 'id', 'appointment_id', 'careof_id');
    }

}
