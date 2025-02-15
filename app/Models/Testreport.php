<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testreport extends Model
{
    use HasFactory;
    protected $table='testreports';
    protected $fillable =[
         'id',
         'result',
         'reference_range',
         'testprovide_id',
         'appointment_id',
         'test_id',
         'diagnostic_id',
         'character_id',
         'testcategory_id',
    ];


    public function character(){
        return $this->belongsTo(Character::class,'character_id');   
    }


    public function diagnostic(){
        return $this->belongsTo(Diagnostic::class,'diagnostic_id');   
    }

}
