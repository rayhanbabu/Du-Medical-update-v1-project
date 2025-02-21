<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substore extends Model
{
       use HasFactory;

        public function generic(){
          return $this->belongsTo(Generic::class, 'generic_id'); 
        }


        public function stock(){
           return $this->belongsTo(Stock::class, 'stock_id'); 
        }
}
