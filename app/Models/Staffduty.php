<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staffduty extends Model
{
    use HasFactory;
    protected $table='staffduties';
    protected $fillable =[
         'id',
         'week_name',
         'user_id',
         'duty_time',
         'userType',
        
    ];
}
