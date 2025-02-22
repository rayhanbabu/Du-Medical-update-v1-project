<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productrequest extends Model
 {

    use HasFactory;

    protected $fillable = [
        'stock_id',
        'cmo_status',
        'provide_status',
        'provide_by',
        'id',
    ];

    public function provide(){
        return $this->belongsTo(User::class,'provide_by');  
    }


    public function request(){
        return $this->belongsTo(User::class,'request_by');  
    }


 }
