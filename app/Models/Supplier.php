<?php

namespace Alyya\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function products(){
        return $this->hasMany('Alyya\Models\Product');
    }
}
