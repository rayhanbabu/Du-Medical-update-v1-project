<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'generic_id',
        'available_piece',
        'total_amount',
        'id',
    ];


    public function create(){
        return $this->belongsTo(User::class,'created_by'); 
    }
 
    public function generic(){
        return $this->belongsTo(Generic::class, 'generic_id'); 
    }


    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id'); 
    }

}
