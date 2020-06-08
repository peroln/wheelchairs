<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
