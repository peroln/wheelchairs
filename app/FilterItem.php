<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterItem extends Model
{
    public function type(){
       return $this->belongsTo(Type::class);
    }
    public function subFilterItems(){
        return $this->hasMany(SubFilterItem::class);
    }
    public function subFilter(){
        return $this->subFilterItems()->withCount('products');
    }

}
