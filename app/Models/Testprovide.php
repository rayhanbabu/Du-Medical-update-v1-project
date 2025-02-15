<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testprovide extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'appointment_id',
        'tested_status',
        'checked_status',
        'testcategory_id',
        'test_id',
   ];

    public function member(){
        return $this->belongsTo(Member::class, 'member_id'); 
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id'); 
    }

   public function tested(){
        return $this->belongsTo(User::class,'tested_by'); 
    }

    public function checked(){
        return $this->belongsTo(User::class,'checked_by'); 
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function careof()
    {
        return $this->hasOneThrough(Family::class, Appointment::class, 'id', 'id', 'appointment_id', 'careof_id');
    }
    
     public function testcategory(){
         return $this->belongsTo(Testcategory::class,'testcategory_id');
     }

}
