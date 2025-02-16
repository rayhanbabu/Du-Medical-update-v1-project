<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    public function generic(){
        return $this->belongsTo(Generic::class, 'generic_id'); 
    }

    public function form()
    {
        return $this->hasOneThrough(Form::class, Generic::class, 'id', 'id', 'generic_id', 'form_id');
    }
}
