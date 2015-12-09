<?php

namespace Alyya\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    protected $connection = 'site';

    public function products(){
        return $this->belongsToMany('Alyya\Models\Site\Product')->withPivot('position');
    }
    public function children(){
        return $this->hasMany('Alyya\Models\Site\Category', 'parent');
    }
    public function parent(){
        return $this->hasOne('Alyya\Models\Site\Category', 'id' , 'parent');
    }

    //
}
