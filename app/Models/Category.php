<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('App\Models\CdiscountProCategory');
    }
    //
}
