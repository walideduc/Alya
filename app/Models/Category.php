<?php

namespace Alyya\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('Alyya\Models\CdiscountProCategory');
    }

    public function products()
    {
        return $this->belongsToMany('Alyya\Models\Product');
    }
    //
}
