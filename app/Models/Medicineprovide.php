<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicineprovide extends Model
{

    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class, 'member_id'); 
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function careof()
    {
        return $this->hasOneThrough(Family::class, Appointment::class, 'id', 'id', 'appointment_id', 'careof_id');
    }

    public function create(){
        return $this->belongsTo(User::class, 'created_by'); 
    }
}
