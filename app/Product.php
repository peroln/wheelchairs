<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function characteristics(){
        return $this->hasMany(Characteristic::class);
    }

    public function getPriceAttribute($value){
        return $value / 100;
    }
}
