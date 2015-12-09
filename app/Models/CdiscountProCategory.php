<?php

namespace Alyya\Models;

use Illuminate\Database\Eloquent\Model;

class CdiscountProCategory extends Model
{
    protected $guarded = [];
    //
    public function CdiscountProCategories()
    {
        return $this->belongsToMany('Alyya\Models\Category');
    }
}
