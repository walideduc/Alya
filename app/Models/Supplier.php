<?php

namespace alyya\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function products(){
        return $this->hasMany('alyya\Models\Product');
    }
}
