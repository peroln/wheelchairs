<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    const WHEELCHAIR_TYPE_NAME = 'wheelchairs';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function filterItems()
    {
        return $this->hasMany(FilterItem::class);
    }

}
