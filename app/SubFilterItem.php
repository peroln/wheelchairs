<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SubFilterItem extends Model
{
    public $count_filter = 0;

    public function characteristic(){
        return $this->hasOne(Characteristic::class);
    }
    public function characteristics(){
        return $this->hasMany(Characteristic::class);
    }

    public function filterItem(){
        return $this->belongsTo(FilterItem::class);
    }


    public function products(){
        return $this->hasManyThrough(
            Product::class,
            Characteristic::class,
            'sub_filter_item_id',
            'id',
            'id',
            'product_id'
            );
    }
}
