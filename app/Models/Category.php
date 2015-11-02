<?php

namespace alyya\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('alyya\Models\CdiscountProCategory');
    }
    //
}
