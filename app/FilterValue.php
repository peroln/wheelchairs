<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterValue extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function subFilterItem(){
        return $this->belongsTo(SubFilterItem::class);
    }
}
