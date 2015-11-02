<?php

namespace alyya\Models;

use Illuminate\Database\Eloquent\Model;

class CdiscountProCategory extends Model
{
    protected $guarded = [];
    //
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('alyya\Models\Category');
    }
}
