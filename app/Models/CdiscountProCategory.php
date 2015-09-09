<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CdiscountProCategory extends Model
{
    protected $guarded = [];
    //
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}
