<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    public function character(){
        return $this->belongsTo(Character::class,'character_id');
    }

    
    public function testcategory(){
        return $this->belongsTo(Testcategory::class,'test_id');
    }
}
